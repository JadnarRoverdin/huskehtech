

<!--  $postImages  -->
<?php

echo $message ."<br>";

?>

<div>
  <form action ='?controller=admin&action=updatePost' method='post'>
    <input type='hidden' value='<?php echo $post->id; ?>' name='postID'>
    <input class='input'type='text' value='<?php echo $post->title; ?>' name ='postName'><br>
    <input class='input' type='date' value='<?php echo $post->date; ?>' name ='postDate'><br>
    <input class='input' type='time' value='<?php echo $post->time; ?>' name ='postTime'><br>
    <div>
      <?php
        for($i=0;$i<sizeof($post->content);$i++)
        {
            echo "<textarea class='input' id='scroller' name='content[]' rows='10' cols='100'>";
            echo $post->content[$i][1];
            echo "</textarea>";
            echo "<input type='hidden' name='contentID[]' value='".$post->content[$i][0]."'>";
        }
      ?>
    </div>
    <input type="submit" value="Update">
  </form>
</div>
