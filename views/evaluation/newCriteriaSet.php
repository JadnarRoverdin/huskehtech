<h2>Create Criteria Set</h2>
<div><?php echo $message;?></div>
<form action='?controller=evaluation&action=insertCriteriaSet' method='post'>
  <div>
    Set's Name: <input type='text' name='setName'><br>
    Description: <input type='text' name='setDesc'>
  </div>
  <div>
    <select name='criterias[]' multiple>

      <?php
      for($i=0; $i<sizeof($criteriaNames);$i++)
      {
        echo "<option value='".$criteriaIDs[$i]."'>".$criteriaNames[$i]."</option>";
      }
      ?>
    </select>
  </div>
  <input type='submit' value='Create Set'>
</form>
