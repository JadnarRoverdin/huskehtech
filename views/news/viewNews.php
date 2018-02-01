<?php
if(isset($_SESSION['user']))
  $user = unserialize($_SESSION['user']);
foreach($newsPost as $news)
{
  echo "<div class='newsCard'>";
  echo "<h3>".$news->title."</h3>";
  echo $news->date." | ".$news->time."<hr>";
  echo nl2br($news->content)."<hr>";

  $tagSize = sizeof($news->tags);
  for($i = 0; $i<$tagSize; $i++)
  {
    if($i == $tagSize-2)
    {
      echo "<a href='?controller=news&action=getByTag&id=".$news->tags[$i]->id."'>".$news->tags[$i]->title."</a>,";

    }
    else if($i == $tagSize-1)
    {
      echo "<a href='?controller=news&action=getByTag&id=".$news->tags[$i]->id."'>".$news->tags[$i]->title."</a>";

    }

    else
    {
      echo "<a href='?controller=news&action=getByTag&id=".$news->tags[$i]->id."'>".$news->tags[$i]->title."</a>, <a href='?controller=news&action=getByTag&id=".$news->tags[$i+1]->id."'>".$news->tags[$i+1]->title."</a>";
      $i++;
    }
  }
  echo "<hr>";
  if(isset($user) && $user->level < 2)
  {
    echo "<a href='?controller=news&action=update&postID=".$news->id."'>Edit</a> | ";
    echo "<a href='?controller=news&action=delete&postID=".$news->id."'>Delete</a>";
  }
  echo "</div>";
}

 ?>
