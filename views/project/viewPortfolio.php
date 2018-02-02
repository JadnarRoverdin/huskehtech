<?php
  $maxImages = 1;

  if(isset($_SESSION['user']))
    $user = unserialize($_SESSION['user']);
  foreach($projects as $p)
  {
    $currImageCount =0;
    $currUser = $p->user;
    echo "<div class='newsCard'>";
    echo "<a href='?controller=project&action=viewProject&id=".$p->id."'><h3>".$p->title."</h3></a>";
    echo "<div class='thumbnailcontainer'>";
    foreach($p->content as $c)
    {
      if($c->format == "image" and $currImageCount < $maxImages)
      {
        echo "<img src='".$c->data."' height='200'><br>";
        $currImageCount++;
      }
    }
    echo "</div><hr>";
    echo "Author: ".$currUser->firstName." ".$currUser->lastName."<br>";
    echo $p->date." | ".$p->time."<hr>";

    $splitstring = explode(" ", $p->description);
    $sizeofspliltString = sizeof($splitstring);
    $limit = ($sizeofspliltString < 30) ? $sizeofspliltString : 30;
    if($limit <= 30)
    {
      $outstring = "";
      for($i = 0; $i < $limit; $i++)
      {
        $outstring .= $splitstring[$i]." ";
      }
      echo nl2br($outstring)."<a href='?controller=project&action=viewProject&id=".$p->id."'>...</a><hr>";

    }
    else
    {
        echo nl2br($p->description)."<hr>";

    }

    $tagSize = sizeof($p->tags);
    for($i = 0; $i<$tagSize; $i++)
    {

      if($i == $tagSize-2)
      {
        echo "<a href='?controller=project&action=getByTag&id=".$p->tags[$i]->id."'>".$p->tags[$i]->title."</a>, <a href='?controller=project&action=getByTag&id=".$p->tags[$i+1]->id."'>".$p->tags[$i+1]->title."</a>";
        $i++;
      }
      else {
        echo "<a href='?controller=project&action=getByTag&id=".$p->tags[$i]->id."'>".$p->tags[$i]->title."</a>, ";
      }
    }
    echo "<br>";



    if(isset($user) && $user->level < 2)
    {
      echo "<a href='?controller=project&action=update&projectID=".$p->id."'>Edit</a> | ";
      echo "<a href='?controller=project&action=delete&projectID=".$p->id."'>Delete</a>";
    }
    echo "</div>";
  }
?>
