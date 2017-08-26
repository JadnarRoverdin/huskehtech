
<button onclick="goBack()">Return to previous page</button>

<div>
  <?php
      echo "<div>";
      echo "<h2>".$post->title."</h2>";
      echo "<br>Posted on: ".$post->date;
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
      foreach($post->content as $content)
        echo "<br>".$content[1]."</div><br>";

      echo "<div>";
      if(sizeof($post->images) >0)
        foreach($post->images as $postImage)
          if($postImage != null)
          echo "<a href='".$postImage."' target='_blank'><img src=".$postImage." width='400'></a>";
      echo "</div>";
?>
</div>

<script>
function goBack()
{
  window.history.back();
}
</script>
