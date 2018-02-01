<?php
Class NewsController
{
  public function new()
  {
    $authorID = User::getIDbyToken($_SESSION['token'])[1];
    $currentTimeStamp = $_SERVER['REQUEST_TIME'];
    $rawdate = date("Y-m-d", $currentTimeStamp);
    $rawtime = date("h:i:s", $currentTimeStamp);
    $tag = Tag::catagoryName('News')[1];
    $postID;
    if(isset($_POST['title']))
    {
      if($_POST['update'] == 'true')
        $postID = Post::update($_POST['postID'], $_POST['title'],$_POST['content'],$_POST['date'],$_POST['time'])[1];
      else
      {
        $postID = Post::insert($_POST['title'],$_POST['content'],$_POST['date'],$_POST['time'],$_POST['author'])[1];
        foreach($_POST['tags'] as $t)
        {
          echo  Tag::associateWithPost($t, $postID)[1];
        }
      }
        //echo("<script>location.href = '?controller=pages&action=news';</script>");
    }
    else
    {
      require_once('views/news/postEditor.php');
    }

  }

  public function update()
  {
    $authorID = User::getIDbyToken($_SESSION['token'])[1];
    $update = true;
    $post = Post::id($_GET['postID'])[1];

    require_once('views/news/postEditor.php');
  }

  public function delete()
  {
    echo Post::delete($_GET['postID'])[1];
    echo("<script>location.href = '?controller=pages&action=news';</script>");

  }
}
?>
