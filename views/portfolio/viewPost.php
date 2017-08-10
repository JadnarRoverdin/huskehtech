Tags: <br>

<?php
$i = 0;
$listsize = sizeof($tagList);
foreach($tagList as $tag)
{
  echo "<a href='?controller=portfolio&action=getByTag&tagName=".$tag."'>".$tag."</a>";
  if($i < $listsize -1)
  echo ", ";
  $i++;
}

?>
