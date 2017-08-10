
<button onclick="goBack()">Return to previous page</button>

<div>
  <?php
      echo "<div>";
      echo "<h2>".$postName."</h2>";
      echo "<br>Posted on: ".$postDate;
      echo "<br>Tags: ";
      $i = 0;
      $listsize = sizeof($tagList);
      foreach($tagList as $tag)
      {
        echo "<a href='?controller=portfolio&action=getByTag&tagName=".$tag."'>".$tag."</a>";
        if($i < $listsize -1)
        echo ", ";
        $i++;
      }
      echo "</div>";
      echo "<div>";
      foreach($postContent as $content)
        echo "<br>".$content."</div><br>";

      echo "<div>";
      if($postImages[0] != null)
        foreach($postImages as $postImage)
          echo "<a href='".$postImage."'><img src=".$postImage." width='400'></a>";
      echo "</div>";
?>
</div>

<script>
function goBack()
{
  window.history.back();
}
</script>
