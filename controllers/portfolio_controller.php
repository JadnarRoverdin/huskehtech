<?php
Class PortfolioController
{
  public function index()
  {
    $posts = Post::tag("Portfolio");
    require_once('views/portfolio/index.php');

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
    $fetchlist = array($_GET['tagName']);
    $postList = Database::getByTag($fetchlist);
    $postNames = $postList[0];
    $postContents = $postList[1];
    $postIDs = $postList[2];
    $postDates = $postList[3];
    $postImages= $postList[4];
    require_once('views/pages/index.php');
  }

  public function error()
  {
    require_once('views/pages/error.php');
  }
}
?>
