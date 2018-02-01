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
}
?>
