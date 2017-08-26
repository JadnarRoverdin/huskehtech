<?php
Class AdminController
{
  public function index()
  {
    $message = "";
    require_once('views/admin/index.php');
  }
  public function addPost()
  {
    $tags = Tag::getTags();
    require_once('views/admin/newPost.php');
  }

  public function uploadImage($fileDestination)
  {
    $target_dir = $fileDesitination;
  }

  public function editPost()
  {
    $message = "EDIT THIS POST";
    $post = Post::getPost($_GET['postID']);
    require_once('views/admin/editPost.php');
  }

  public function updatePost()
  {
    $message = Post::updatePost($_POST['postID'], $_POST['postName'],$_POST['postDate'],$_POST['postTime'],$_POST['content'], $_POST['contentID']);
    require_once('views/admin/index.php');
  }

  public function removePost()
  {
    $postData = Database::getPost($_GET['postID']);
    $postName = $postData[0];
    $postID = $_GET['postID'];
    require_once('views/admin/confirmDelete.php');
  }

  public function deletePosts()
  {
    $message ="";
  }

  public function deletePost()
  {
    $message = "";
    $value = $_POST['yesno'];
    if($value == 'yes')
    {
      $message = Post::deletePost($_POST['postID']);
      require_once('views/admin/index.php');
    }
    else
    {
      $message = 'nope';
    }
  }

  public function insertPost()
  {
    $target_dir = "img/postImages/";
    $names = array();
    $tempNames = array();
    $baseNames = array();
    $targetFiles=array();

    if(isset($_FILES["fileToUpload"]))
    {
      foreach($_FILES["fileToUpload"]["name"] as $this)
      {
        $names[] = $this;
        $baseNames[] = basename($this);
      }
      foreach($_FILES["fileToUpload"]["tmp_name"] as $this)
      {
        $tempNames[] = $this;
      }

      foreach($names as $name)
      echo $name."<br>";
      for($i=0;$i<sizeof($names);$i++)
      {
        $target_file = $target_dir . $baseNames[$i];
        $targetFiles[]=$target_file;
        echo $target_file."<br>";
        $uploadOK = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if(isset($_POST["submit"]))
        {
          $check = $names[$i];

            if(move_uploaded_file($tempNames[$i], $target_file))
            {
              echo "The File " . $baseNames[$i]. "has Been Uploaded.";
            }
            else
            {
              echo "File not uploaded<br>";
            }
          }
      }
    }
    $taglisting = [];
    foreach($_POST['taglist'] as $selected)
      $taglisting[] = $selected;
    $message = Post::insertPost($_POST['postname'], $_POST['posttext'], $taglisting, $baseNames,$targetFiles, $_POST['date'], $_POST['time'] );
    require_once('views/admin/index.php');
  }
  public function addTag()
  {
    require_once('views/admin/newTag.php');
  }

  public function addCat()
  {

    require_once('views/admin/newCat.php');
  }

  public function linkTag()
  {
    $tags = Tag::getTags();
    $cats = Catagory::getCats();
    require_once('views/admin/linkTag.php');
  }

  public function attachtagtocat()
  {
    $message = Tag::associateTagWithCatagory($_POST['catID'], $_POST['tagIDs']);
    require_once('views/admin/index.php');
  }

  public function insertTag()
  {
    $message = Tag::insertTag($_POST['tagname'], $_POST['tagtext']);
    require_once('views/admin/index.php');
  }

  public function insertCat()
  {
    $message = Catagory::insertCat($_POST['catname'], $_POST['catdesc']);
    require_once('views/admin/index.php');
  }
  public function linktagtocat()
  {
    $message = Tag::associateTagWithCatagory($_POST['cat'],$_POST['tags']);
    require_once('views/admin/index.php');

  }

  public function error()
  {
    require_once('views/pages/error.php');
  }
}
?>
