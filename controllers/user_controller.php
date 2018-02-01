<?php

class UserController
{
//=================================================================================== REGISTER
  function register()
  {
      if(isset($_POST['firstname']))
      {
        $out='';
        $outcome = User::create($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['new-password'], $_POST['level']);
        $out = $outcome[1];
        $_SESSION['message'] = $out;
        echo("<script>location.href = 'index.php';</script>");
      }
      else
      {
        require_once('views/user/register.php');
      }
  }
//=================================================================================== LOGIN
  function login()
  {
    if(isset($_POST['email']))
    {
      $outcome =  User::login($_POST['email'], $_POST['current-password']);
      if($outcome[0] != 1)
      {
        $_SESSION['message'] = $outcome[1];
        echo("<script>location.href = 'index.php';</script>");
      }
      else
      {
        $sessionData = $outcome[1];
        $_SESSION['user'] = serialize($sessionData[0]);
        $_SESSION['token'] = $sessionData[1];
        echo("<script>location.href = 'index.php';</script>");
      }
    }
  }
//=================================================================================== LOGOUT
  function logout()
  {
    if(isset($_SESSION['token']))
      User::logout($_SESSION['token']);
    session_unset();													//unsets all Session variables effecitvly logging the user out of current session
    echo("<script>location.href = 'index.php';</script>");
  }
//=================================================================================== EDIT USER
  function editUser()
  {
    $userSelected = false;
    $userEdited = false;
    $selectedUser = "";
    $userList = User::all()[1];
    if(isset($_POST['user']))
    {
      $userSelected = true;
      $selectedUser = User::id($_POST['user'])[1];
    }
    else if(isset($_POST['firstname']))
    {
      User::update($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['userLevel'],$_POST['userid']);
      $userSelected = false;
      $userEdited = true;
      $userList = User::all()[1];
    }
    require_once('views/user/editUser.php');
  }
//=================================================================================== DELETE
  function delete()
  {
    $_SESSION['message'] = "Select a User";
    $userSelected = false;
    $userEdited = false;
    $selectedUser = "";
    $userList = User::all()[1];
    if(isset($_POST['user']))
    {
      $_SESSION['message'] = "Confirm deletion of user";
      $userSelected = true;
      $selectedUser = User::id($_POST['user'])[1];
    }
    else if(isset($_POST['confirm']))
    {
      if($_POST['confirm'] == "yes")
      {
        $_SESSION['message'] = "User has been deleted";
        User::delete($_POST['userid']);
        $userSelected = false;
        $userEdited = true;
        $userList = User::all()[1];
      }
      else
      {
        $_SESSION['message'] = "User has not been deleted";
        $userSelected = false;
        $userEdited = false;
      }
    }
    require_once('views/user/userDelete.php');
  }
//=================================================================================== INDEX
  function index()
  {
    $results = User::all()[1];
    require_once('views/user/viewUsers.php');
  }
//=================================================================================== PASSWORD RESET
  function resetPassword(){
    $code = $_GET['code'];

    if (isset($_POST['passwordConfirm']))
    {
      if($_POST['new-password'] == $_POST['passwordConfirm'])
      {
        $outcome = User::resetPassword($code, $_POST["new-password"]);
        if($outcome[0] == 1)
        {
          $_SESSION['message'] = $outcome[1];
          echo "<script> if(confirm('".$message."')) document.location = 'index.php'</script>";
        }
      }
      else
      {
        $_SESSION['message'] = "Your passwords do not match. Please try again.";
      }
    }
    require_once('views/user/passwordReset.php');

  }
//=================================================================================== PASSWORD RESET REQUEST
  function passwordResetRequest(){

    if (isset($_POST['email']))
    {
      $outcome = User::sendResetEmail($_POST['email']);
      $_SESSION['message'] = $outcome[1];
      echo("<script>location.href = 'index.php';</script>");
    }
  }
//=================================================================================== EMAIL CONFIRMATION
  function emailConfirmation(){
    $code = $_GET['code'];
    $outcome = User::confirmEmail($code);
    $_SESSION['message'] = $outcome[1];
    echo("<script>location.href = 'index.php';</script>");
  }
//=================================================================================== SEND EMAIL CONFIRMATION
  function sendEmailConfirmation()
  {
    $email = $_GET['email'];
    $outcome = User::sendConfirmEmail($email);
    $_SESSION['message'] = $outcome[1];
    require_once('views/user/login.php');
  }
  //=================================================================================== SEND EMAIL CONFIRMATION
    function viewProfile()
    {
      $targetUser = User::id($_GET['id'])[1];
      $profile = $targetUser->profile;
      require_once('views/user/viewProfile.php');
    }
}



?>
