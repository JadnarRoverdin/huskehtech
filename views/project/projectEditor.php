<script src='js/contentSubmissionManager.js'></script>

<h2> New Project </h2>

<form>
  <div class='editorContainer'>

    <div class='dataEntry'>
      <h4>Enter Project Details</h4>
      <input type='hidden' id='author' value="<?php echo $authorID; ?>">
      <input type='hidden' id='update' value="<?php if(isset($update)) echo 'true'; else echo'false'; ?>">
      <input type='hidden' id='projectID' value="<?php if(isset($update)) echo $project->id; else echo "-1"; ?>">
      <input type='text' id='title' placeholder='Title' <?php if(isset($update)) echo "value='".$project->title."'"; ?> required><br>
      <textarea id='description' placeholder='Project Description' required cols='50' rows='10'><?php if(isset($update)) echo $project->description; ?></textarea><br>
      Date: <input type='date' id='date' value='<?php if(isset($update)) echo $project->rawdate; else echo $rawdate; ?>'><br>
      Time: <input type='time' id='time' value='<?php if(isset($update)) echo $project->rawtime; else echo $rawtime; ?>'><br>
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
    <div class='fileuploadzone'>
      <h4>Upload Content</h4>
      Number of Files: <input type ="number" name='numtoup' id="numtoup" value ="0"><br>
      <div class='fileupload' id='fileUpload'></div>
    </div>

  </div>
  <input type="button" onclick ='submission()' value='<?php if(isset($update)) echo "Update Project"; else echo "Add Project"; ?>'>

</form>

<div id='ProjectView'></div>
