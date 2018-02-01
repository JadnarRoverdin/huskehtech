<?php
if(isset($_GET['quick']))
{
  require_once('routes.php');
}
else
{
?>


<!DOCTYPE html>
<html>

  <head>
    <title>HuskehTech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/base.css">
        <link rel="stylesheet" type="text/css" href="css/dropdownmenu.css">
        <link rel="stylesheet" type="text/css" href="css/input.css">
        <link rel="stylesheet" type="text/css" href="css/popup.css">
        <link rel="stylesheet" type="text/css" href="css/card.css">

  </head>

  <header>
    <script src="vendor/jquery.min.js"></script>
    <script src="js/popup.js"></script>
    <div id='titlecontainer'>
      <form action='index.php' method='post'>
        <button class='titleLink' type='submit'>HuskehTech</button>
      </form>
  </div>
    <div id='menucontainer'><?php require_once('views/pages/menu.php');?></div>
    <div id='logincontainer'><?php require_once('views/user/userMenu.php');?></div>

  </header>

  <body>


    <!-- <div class='push'></div> -->
    <div id='sessionMessage error'>
      <?php
        if(isset($_SESSION['message']))
        {
          echo $_SESSION['message'];
          unset($_SESSION['message']);
        }
       ?>
    </div>
    <div>
    <?php require_once('routes.php'); ?>
  </div>
  </body>

  <footer>
    Site design and contents ©HuskehTech Industries 2018
  </footer>
  <div class='overlay'></div>

</html>
<?php } ?>
