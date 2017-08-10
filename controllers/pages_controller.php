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
    $tagList = Database::getTags($_GET['postID']);
    $postData = Database::getPost($_GET['postID']);
    $postName = $postData[0];
    $postDate = $postData[1];
    $postTime = $postData[2];
    $postContent = $postData[3];
    $postContentIDs=$postData[4];
    $postImages = $postData[5];
    require_once('views/pages/viewPost.php');
  }
}

?>
