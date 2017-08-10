

<!--  $postImages  -->
<?php

echo $message ."<br>";

?>

<div>
  <form action ='?controller=admin&action=updatePost' method='post'>
    <input type='hidden' value='<?php echo $postID; ?>' name='postID'>
    <input class='input'type='text' value='<?php echo $postName; ?>' name ='postName'><br>
    <input class='input' type='date' value='<?php echo $postDate; ?>' name ='postDate'><br>
    <input class='input' type='time' value='<?php echo $postTime; ?>' name ='postTime'><br>
    <div>
      <?php
        for($i=0;$i<sizeof($postContents);$i++)
        {
            echo "<textarea class='input' id='scroller' name='content[]' rows='10' cols='100'>";
            echo $postContents[$i];
            echo "</textarea>";
            echo "<input type='hidden' name='contentID[]' value='".$postContentsIDs[$i]."'>";
        }
      ?>
    </div>
    <input type="submit" value="Update">
  </form>
</div>
