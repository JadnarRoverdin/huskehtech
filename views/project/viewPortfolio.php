<?php
  $maxImages = 1;

  if(isset($_SESSION['user']))
    $user = unserialize($_SESSION['user']);
  foreach($projects as $p)
  {
    $currImageCount =0;
    $fileCount = 0;
    $textCount = 0;
    $linkCount = 0;
    $currUser = $p->user;
    $firstisDone = false;
    echo "<div class='newsCard'>";
    echo "<a href='?controller=project&action=viewProject&id=".$p->id."'><h3>".$p->title."</h3></a>";
    echo "<div class='thumbnailcontainer'>";
    foreach($p->content as $c)
    {
      switch($c->format)
      {
        case "image":
          if(!$firstisDone)
          {
            echo "<a href='".$c->data."' target='_blank'><img src='".$c->data."' height='200'></a><br>";
            $firstisDone = true;
          }
          else
            $currImageCount++;
          break;
        case "link":
          $linkCount++;
          break;
        case "text":
          $textCount++;
          break;
        case "file":
          $fileCount++;
          break;
        }
      }
      $firstline = true;
      $projectLink = "<a href='?controller=project&action=viewProject&id=".$p->id."'>";

      if($currImageCount > 0 || $fileCount > 0 || $textCount > 0 || $linkCount > 0)
        $projectLink.= "";

      if($currImageCount > 0)
      {
        $projectLink.= " +".$currImageCount." more images";
      }

      if($fileCount > 0)
      {
        $projectLink.= " +".$fileCount." files";
      }

      if($textCount > 0)
      {
        $projectLink.= " +".$textCount." texts";
      }

      if($linkCount > 0)
      {
        $projectLink.= " +".$linkCount." links";
      }

        echo $projectLink."</a>";





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
      echo nl2br($outstring)."<a href='?controller=project&action=viewProject&id=".$p->id."'>...</a><hr>";
    }



    $tagSize = sizeof($p->tags);
    for($i = 0; $i<$tagSize; $i++)
    {
      echo "<a href='?controller=project&action=getByTag&id=".$p->tags[$i]->id."'>".$p->tags[$i]->title."</a>";
      if(($tagSize - $i) > 1)
        echo ", ";

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
