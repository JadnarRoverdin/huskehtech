<?php
Class PortfolioController
{
  public function index()
  {
    $posts = Post::tag("Portfolio");
    require_once('views/pages/index.php');
  }

  public function viewPost()
  {
    $post = Post::id($_GET['postID']);
    require_once('views/portfolio/viewPost.php');
  }
  public function about()
  {
    require_once('views/pages/about.php');
  }

  public function getByTag()
  {
    $posts = Post::tag($_GET['tagName']);
    require_once('views/pages/index.php');
  }

  public function error()
  {
    require_once('views/pages/error.php');
  }
}
?>
