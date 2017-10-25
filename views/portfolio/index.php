<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src ="java/postTrimmer.js"></script>
<div>
  <?php
  if($catagories)
    foreach($catagories as $cat)
    {
      if($cat->title != "Academic")
      {
        echo "<div class='postCard'>";
        echo "<h3>".$cat->title."</h3><br>";

        foreach($cat->tags as $tag)
        {
          echo "<a href='?controller=portfolio&action=getByTag&tagName=".$tag->title."'>".$tag->title."</a><br>";
        }
        echo "</div>";
      }
    }
  ?>
