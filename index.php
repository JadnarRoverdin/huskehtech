
<?php require_once('models/user.php'); session_start();?>
<!DOCTYPE html>
<html id="scroller">
  <head>
    <script src="vendor/jquery.min.js"></script>
    <script src="java/popup.js"></script>
    <title>HuskehTech</title>
    <link rel="stylesheet"  type="text/css" href="css/baseStyle.css">
    <link rel="stylesheet"  type="text/css" href="css/postStyle.css">
    <link rel="stylesheet"  type="text/css" href="css/inputStyle.css">
  </head>
  <div class="overlay"></div>
  <header>
    <div class='headertitle'>
          <a class='header' href='/'>HuskehTech</a>
    </div>
    <div class='headerlogin'>
          <?php
          if(!isset($_SESSION['user']))
          {
            echo "<a class='popupmaker' id='login'>Login/Register</a>";
          }
          else
          {
            $user = $_SESSION['user'];
            echo "Hello ".$user->firstName." ".$user->lastName." <a href='?controller=user&action=logout'>LogOut</a>";
            echo "";
           }
            ?>
        </div>
      <div class='headerMenu'>
        <button class='popupmaker dropbtn' id='menu'>Menu</a>
      </div>


    </header>

    <body>
      <div class=spacer></div>
      <div id="content">
        <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors',1);
            error_reporting(E_ALL);
            require_once('connection.php');
            if(isset($_GET['controller']) && isset($_GET['action']))
            {
              $controller = $_GET['controller'];
              $action     = $_GET['action'];
            }
            else
            {
              $controller = 'pages';
              $action     = 'index';
            }
            require_once('views/layout.php');
        ?>
      </div>
      <div id="push">
      </div>
      <?php
        require_once('views/elements/login.php');
        require_once('views/elements/menu.php');
      ?>
  </body>

  <footer>
    Site design and contents ©HuskehTech Industsries 2017
  </footer>

</html>
