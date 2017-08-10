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
    User::login($_POST['username'], $_POST['password']);
    header('Location: index.php');
    // $fetchlist = array("News");
    // $postList = Database::getByTag($fetchlist);
    // $postNames = $postList[0];
    // $postContents = $postList[1];
    // $postIDs = $postList[2];
    // $postDates = $postList[3];
    // $postImages= $postList[4];
    // require_once('views/pages/index.php');
  }

  public function logout()
  {
    User::logout();
    header('Location: index.php');
    // $fetchlist = array("News");
    // $postList = Database::getByTag($fetchlist);
    // $postNames = $postList[0];
    // $postContents = $postList[1];
    // $postIDs = $postList[2];
    // $postDates = $postList[3];
    // $postImages= $postList[4];
    // require_once('views/pages/index.php');
  }

}
?>
