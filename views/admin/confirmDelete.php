Deletion Confirmation

Are you sure you want to delete post titled <?php echo $postName; ?>?

<form action='?controller=admin&action=deletePost' method='post'>
  <input class='input' type='hidden' name='postID' value='<?php echo $postID; ?>'>
  <select class='input' id ='scroller' name='yesno'>
    <option value ='no'>No</option>
    <option value ='yes'>Yes</option>
  </select><br>
  <input type='submit' value='Submit'>
</form>
