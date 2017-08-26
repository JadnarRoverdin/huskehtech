<?php
Class PagesController
{
  public function index()
  {
    $posts = Post::tag("News");
    require_once('views/pages/index.php');
  }

  public function error()
  {
    require_once('views/pages/error.php');
  }

  public function about()
  {
    require_once('views/pages/about.php');
  }

  public function sandbox()
  {
    require_once('views/pages/sandbox.php');
  }
  public function mobilelab()
  {
    require_once('views/pages/mobilelab.php');
  }
  public function services()
  {
    require_once('views/pages/services.php');
  }
  public function food()
  {
    require_once('views/pages/food.php');
  }
  public function viewPost()
  {
    $tagList = Post::getTags($_GET['postID']);
    $post = Post::getPost($_GET['postID']);
    require_once('views/pages/viewPost.php');
  }
}

?>
