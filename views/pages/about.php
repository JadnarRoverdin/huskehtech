<h2>About</h2>




<table class='postCard'>
  <tr>
    <td class='postLinkBack'>
      <a class='postLink' href='?controller=user&action=viewProfile&userID=<?php echo $user->id; ?>'><?php echo $user->firstName." ".$user->lastName; ?></a>
      <br><?php echo $user->profile->dob; ?>
      <br><?php echo $user->profile->location; ?>
    </td>
    <?php

        echo "<td class ='postImages' rowspan='2'>";
            echo "<a href='".$user->profile->avatar."' target='_blank'><img src='".$user->profile->avatar."' width='200'></a>";
          echo "</td>";

      ?>
  </tr>
  <tr>
    <td class='content'>
        <?php
         echo $user->profile->biography;
        ?>
    </td>
  </tr>
</table>
