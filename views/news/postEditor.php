<h2> New Post </h2>



<form action='?controller=news&action=new' method='post'>
  <div class='editorContainer'>
  <div class='dataEntry'>
    <h4>Post Details</h4>
    <input type='hidden' name='author' value="<?php echo $authorID; ?>">
    <input type='hidden' name='update' value="<?php if(isset($update)) echo 'true'; else echo'false'; ?>">
    <input type='hidden' name='postID' value="<?php if(isset($update)) echo $post->id; else echo "-1"; ?>">
    <input type='text' name='title' placeholder='Title' <?php if(isset($update)) echo "value='".$post->title."'"; ?> required><br>
    <textarea name='content' placeholder='Text of Post' required cols='50' rows='10'><?php if(isset($update)) echo $post->content; ?></textarea><br>
    Date: <input type='date' name='date' value='<?php if(isset($update)) echo $post->rawdate; else echo $rawdate; ?>'><br>
    Time: <input type='time' name='time' value='<?php if(isset($update)) echo $post->rawtime; else echo $rawtime; ?>'><br>
  </div>

  <div class='tagging'>
    <h4>Choose Tag(s)</h4>
    <select id="tags" name='tags[]' size='20' multiple>
      <?php foreach($tag as $t)
      {
        echo "<option value='".$t->id."'>".$t->title."</option>";
      }
      ?>
    </select>
  </div>
  </div>
<input type="submit" value='<?php if(isset($update)) echo "Update Post"; else echo "Add Post"; ?>'>
</form>
