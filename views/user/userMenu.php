<?php
    if(isset($_SESSION['user']))
    {
      $user = unserialize($_SESSION['user']);
      ?>
      <div class='hovermenucontainer'>
        <button class='hoverbutton'><?php echo "Hello ".$user->firstName." ".$user->lastName; ?></button>
        <div class='hovermenu'>
          <a class='dropmenulink' href='?controller=news&action=new'>Write Post</a>
          <a class='dropmenulink' href='?controller=project&action=insert'>Submit Project</a>
          <a class='dropmenulink' href='?controller=project&action=viewPortfolio'>Your Portfolio</a>
          <a class='dropmenulink' href='?controller=user&action=viewProfile&id=<?php echo $user->id;?>'>Your Profile</a>
          <?php if($user->level < 2) { ?>
            <a class='dropmenulink' href='?controller=pages&action=admin'>Administration</a>
          <?php } ?>
          <a class='dropmenulink' href='?controller=user&action=logout'>Logout</a>
        </div>
      </div>
      <?php
    }
    else
    {
      echo "<button class='popupmaker menulink' id='register'>Register</button>";
      echo "<button class='popupmaker menulink' id='login'>Login</button>";
    }
      ?>
<div id='register' class='popup'><?php include_once('views/user/register.php')?></div>
<div id='login' class='popup'><?php include_once('views/user/login.php');?></div>
