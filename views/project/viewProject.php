<?php

 echo "<h2>$project->title</h2>";
 echo "Author: $user->firstName $user->lastName <br>";
 echo "Publish Date: $project->date at $project->time";
 echo "<div><h3>Description</h3>$project->description</div>";


if(sizeof($links) > 0)
{
  echo "<div>";
  echo "<h3>Links</h3>";
  foreach($links as $l)
  {
    echo "<strong>".$l->title."</strong><br>$l->caption<br>$l->data<hr>";
  }
  echo "</div>";
}

if(sizeof($files) > 0)
{
  echo "<div>";
  echo "<h3>Files</h3>";
  foreach($files as $l)
  {
    echo "<strong>".$l->title."</strong><br>$l->caption<br><a href='$l->data'>Download</a><hr>";
  }
  echo "</div>";
}

if(sizeof($texts) > 0)
{
  echo "<div>";
  echo "<h3>Links</h3>";
  foreach($texts as $l)
  {
    echo "<strong>".$l->title."</strong><br>$l->caption<br>$l->data<hr>";
  }
  echo "</div>";
}

if(sizeof($images) > 0)
{
  echo "<div>";
  echo "<h3>images</h3>";
  foreach($images as $l)
  {
    echo "<strong>".$l->title."</strong><br>$l->caption<br><img src='$l->data'><hr>";
  }
  echo "</div>";
}
?>
