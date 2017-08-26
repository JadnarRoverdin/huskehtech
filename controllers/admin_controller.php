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
    $taglists = Admin::getTags();
    $tagNames = $taglists[0];
    $tagIDs = $taglists[1];
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
    $message = Database::updatePost($_POST['postID'], $_POST['postName'],$_POST['postDate'],$_POST['postTime'],$_POST['content'], $_POST['contentID']);
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
      $message = Database::deletePost($_POST['postID']);
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
    $message = Admin::insertPost($_POST['postname'], $_POST['posttext'], $taglisting, $baseNames,$targetFiles, $_POST['date'], $_POST['time'] );
    require_once('views/admin/index.php');
  }
  public function addTag()
  {
    require_once('views/admin/newTag.php');
  }

  public function insertTag()
  {
    $message = Admin::insertTag($_POST['tagname'], $_POST['tagtext']);
    require_once('views/admin/index.php');
  }


  public function error()
  {
    require_once('views/pages/error.php');
  }
}
?>
