
<div>
  <?php
    foreach($postList as $post)
    {
      echo "<div class = 'post'>";
      echo $post->id."<br>";
      echo $post->title."<br>";
      echo $post->author."<br>";
      if($post->tags > 0)
        foreach($post->tags as $tag)
          echo $tag." ";
      echo "<br>";
      if($post->content > 0)
        foreach($post->content as $content)
          echo $content . "<br>";
      if($post->images > 0)
        foreach($post->images as $image)
           echo "<img src=".$image." width='200'><br>";
      echo "</div><hr>d";
    }
  ?>
</div>
