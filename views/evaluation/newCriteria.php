<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

    $(".numtoup").on("change", function(){
      var val = $(this).val();
      var string = "<table><tr><td>Name of criteria: </td><td>Description of criteria:</td></tr><tr><td><input type='text' name='criterianame[]'></td><td><input type='text' name='criteriatext[]'></td></tr></table>"
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



<h2>Add a Criteria</h2>

<div>
<?php
echo $message;
?>
</div><br>

<div>
<form action='?controller=evaluation&action=insertCriteria' method="post">
  <input type="number" class="numtoup" value = "1">
  <div class="postimage">
  <table><tr><td>Name of criteria: </td><td>Description of criteria:</td></tr><tr><td><input type='text' name='criterianame[]'></td><td><input type='text' name='criteriatext[]'></td></tr></table>
</div>
  <input type='submit' value ='Submit'>
</form>
</div>
