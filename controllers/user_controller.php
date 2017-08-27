<?php
class UserController
{
  public function addUser()
  {
    require_once('views/admin/newUser.php');
  }

  public function insertUser()
  {
    $message = User::insertUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password']);
    require_once('views/admin/newUser.php');
  }

  public function login()
  {
    $_SESSION['user'] = User::login($_POST['username'], $_POST['password']);
    header('Location: index.php');
  }

  public function logout()
  {
    User::logout();
    header('Location: index.php');
  }

  public function viewProfile()
  {
    $user = User::getUser($_GET['userID']);
    require_once('views/profile/viewProfile.php');
  }

  public function editUser()
  {
    $message;
    if(!isset($_POST['userID']))
      $user = User::getUser($_SESSION['user']->id);
    else
    {
      if($_POST['profileID'] != '')
      {
        $message = Profile::update($_POST['userID'], $_POST['dob'], $_POST['location'],$_POST['biography'],$_POST['avatar']);
      }
      else
      {
        $message = Profile::insert($_POST['userID'], $_POST['dob'], $_POST['location'],$_POST['biography'],$_POST['avatar']);
      }
      $user = User::getUser($_SESSION['user']->id);
    }
    require_once('views/admin/editUser.php');
  }

}
?>
