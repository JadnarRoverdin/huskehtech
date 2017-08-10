
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $(".clone").click(function(){
        var cloneditem = $(".postimage").clone();
        cloneditem.addClass('postimageafter');
        cloneditem.removeClass("postimage");
        cloneditem.appendTo(".clonehere");
    });

    $(".numtoup").on("change", function(){
      var val = $(this).val();
      var string = '<br><input class="input" type ="file" name ="fileToUpload[]" id="fileToUpload"><br>'
      var out ="";
      for(var i=0;i<val;i++)
      {
        out = out+string;
      }
      $(".postimage").html(out);
    });
});
</script>
</head>

<h2>Add a post</h2>
<div>
<form action='?controller=admin&action=insertPost' method="post" enctype = "multipart/form-data">
  <div>
    Name of Post:<br> <input class='input' type='text' name='postname' required><br>
    Text of Post:<br> <textarea class='input' name='posttext' rows='25' cols='100' required></textarea><br>
    Date: <input class='input' type='date' name='date' value ='<?php echo date("Y-m-d");?>'>
    Time: <input class='input' type='time' name='time' value ='<?php echo date("H:i:s");?>'><br>
  </div>
  <div class='fileuploadzone'>
    Number of Files: <input type ="number" class="numtoup" value ="0"><br>
    <div class='postimage'></div>
  </div>
  <div>
  Choose Tags:<br> <select id='scroller' class='input' multiple name="taglist[]" required>
                          <?php
                          for($i = 0; $i < sizeof($tagNames);$i++)
                          {
                            echo "<option value ='".$tagIDs[$i]."'>".$tagNames[$i]."</option>";
                          }
                          ?>
                      </select><br>
  </div>

  <input type='submit' value ="Submit" name = "submit"><br>
</form>
</div>
