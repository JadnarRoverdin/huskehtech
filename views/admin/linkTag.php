

<form action='?controller=admin&action=linktagtocat' method ='post'>
Choose Tags:<br> <select id='scroller' class='input' multiple name="tags[]" required>
                        <?php
                        foreach($tags as $tag)
                        {
                          echo "<option value ='".$tag->id."'>".$tag->title."</option>";
                        }
                        ?>
                    </select><br>


Choose Catagory:<br> <select id='scroller' class='input' name="cat" required>
                        <?php
                        foreach($cats as $cat)
                        {
                            echo "<option value ='".$cat->id."'>".$cat->title."</option>";
                        }
                        ?>
                    </select><br>
<input type='submit' value='Make Link'>
</form>
