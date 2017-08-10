
<?php session_start();?>
<!DOCTYPE html>
<html id="scroller">

  <head>
    <title>HuskehTech</title>
    <link rel="stylesheet"  type="text/css" href="css/baseStyle.css">
    <link rel="stylesheet"  type="text/css" href="css/postStyle.css">
    <link rel="stylesheet"  type="text/css" href="css/inputStyle.css">
  </head>

  <body>
    <div id="wrapper">
      <div id="header">
        <a class='header' href='/html/'>HuskehTech</a>
      </div>

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

      <div class ="footer" id="footer">
        Site design and contents ©HuskehTech Industsries 2017</a>
      </div>
    </div>
  </body>

</html>
