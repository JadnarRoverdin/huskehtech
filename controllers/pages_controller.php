<?php
Class PagesController
{
  public function index()
  {
    $newsPost = Post::quantity(3)[1];
    $projects = Project::quantity(3)[1];
    require_once('views/pages/index.php');
  }

  public function news()
  {
    $newsPost = Post::all()[1];
    require_once('views/pages/news.php');
  }

  public function portfolio()
  {
    $projects = Project::all()[1];
    require_once('views/pages/portfolio.php');
  }

  public function error()
  {
    require_once('views/pages/error.php');
  }
  public function admin()
  {
    require_once('views/pages/adminstration.php');
  }
  public function contact()
  {
    $result = "";
    if(isset($_POST['email']))
    {
      $name = $_POST['firstname']." ".$_POST['lastname'];
      Email::send($_POST['email'], $name, $_POST['message']);
      $result = "Email Sent. You will recieve a reply as soon as possible. Thank you";
    }
      require_once('views/pages/contact.php');
  }
}
?>
