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
      if($c->format == "image")
      {
        if($currImageCount < $maxImages)
          echo "<a href='".$c->data."' target='_blank'><img src='".$c->data."' height='200'></a><br>";
        else
          $currImageCount++;
      }
    if($currImageCount > 0)
      echo "+".$currImageCount." more.";
    }
    echo "</div><hr>";
    echo "Author: ".$currUser->firstName." ".$currUser->lastName."<br>";
    echo $p->date."<hr>";

    $splitstring = explode(" ", $p->description);
    $sizeofspliltString = sizeof($splitstring);
    if($sizeofspliltString <= 100)
    {
      echo nl2br($p->description)."<hr>";
    }
    else
    {
      $outstring = "";
      for($i = 0; $i < 100; $i++)
      {
        $outstring .= $splitstring[$i]." ";
      }
      echo "<a href='?controller=project&action=viewProject&id=".$p->id."'>".nl2br($outstring)."...</a><hr>";
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
