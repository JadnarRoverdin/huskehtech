<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);

    require_once('connection.php');
    require_once('models/user.php');
    require_once('models/profile.php');

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
