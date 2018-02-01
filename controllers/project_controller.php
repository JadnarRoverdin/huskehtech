<?php
Class ProjectController
{

//===================================================================================
  public function insert()
  {
    $projectID;
    $authorID = User::getIDbyToken($_SESSION['token'])[1];
    $currentTimeStamp = $_SERVER['REQUEST_TIME'];
    $rawdate = date("Y-m-d", $currentTimeStamp);
    $rawtime = date("h:i:s", $currentTimeStamp);
    $tag = Tag::catagoryName("Portfolio")[1];



      require_once('views/project/projectEditor.php');

  }
//===================================================================================
  public function update()
  {
    $authorID = User::getIDbyToken($_SESSION['token'])[1];
    $update = true;
    $project = Project::id($_GET['projectID'])[1];
    $tag = Tag::all()[1];

    require_once('views/project/projectEditor.php');
  }
//===================================================================================
  public function upload()
  {
    $authorID = $_POST['author'];
    $contentIDs = array();
    $projectID;


    //=========== Project update/insert
    if($_POST['update'] == 'true')
    {
      $projectID = Project::update($_POST['projectID'], $_POST['title'],$_POST['description'],$_POST['date'],$_POST['time'])[1];
    }
    else
    {
      $projectID = Project::insert($authorID, $_POST['title'],$_POST['description'],$_POST['date'],$_POST['time'])[1];
      foreach($_POST['tags'] as $t)
      {
        Tag::associateWithProject($t, $projectID);
      }

      for($i = 0; $i < $_POST['numtoup']; $i++)
      {
        $caption = $_POST['contentCaption'.$i];
        $format = $_POST['format'.$i];
        $title = $_POST['contentTitle'.$i];
        if($format == 'text' || $format =='link')
          $theData = $_POST['data'.$i];
        else
        {
          $theData = $_FILES['data'.$i];
        }


        echo $format." ".$caption." ".$title;

        switch($format)
        {
          case 'link':
            $submission = Content::insert($title, $caption, '0', $format, $theData, $authorID, $projectID)[1];
            //Content::associateWithProject($submission, $projectID);
            break;
          case 'text':
            $submission = Content::insert($title, $caption, '0', $format, $theData, $authorID, $projectID)[1];
            //Content::associateWithProject($submission, $projectID);
            break;
          case 'image':
            $target_dir = "submissions/images/";
            $target_file = $target_dir . basename($theData["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
              $check = $theData["name"];
              if(move_uploaded_file($theData["tmp_name"], $target_file))
              {
                $successful = true;
                $submission = $contentIDs[] = Content::insert($title, $caption, '0', $format, $target_dir.basename($theData["name"]), $authorID, $projectID)[1];
                //Content::associateWithProject($submission, $projectID);
              }
            break;
          case 'file':
            $target_dir = "submissions/files/";
            $target_file = $target_dir . basename($theData["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $check = $theData["name"];
            if(move_uploaded_file($theData["tmp_name"], $target_file))
            {
              $submission = Content::insert($title, $caption, '0', $format, $target_dir.basename($theData["name"]), $authorID, $projectID)[1];
              //Content::associateWithProject($submission, $projectID);
              $successful = true;
            }
            break;
          }
        }
      }
    echo("<script>location.href = '?controller=project&action=insert';</script>");
  }
//===================================================================================
  public function delete()
  {
    Project::delete($_GET['projectID']);
    echo("<script>location.href = '?controller=pages&action=portfolio';</script>");
  }
//===================================================================================
  public function viewPortfolio()
  {
    $authorID = User::getIDbyToken($_SESSION['token'])[1];
    $projects = Project::byAuthor($authorID)[1];
    require_once('views/project/viewPortfolio.php');
  }
//===================================================================================
  public function getByTag()
  {
    $projects = Project::tag($_GET['id'])[1];
    require_once('views/project/viewPortfolio.php');
  }
//===================================================================================
  public function viewProject()
  {

    $project = Project::id($_GET['id'])[1];
    $user = $project->user;
    $contents = $project->content;
    $links = array();
    $files = array();
    $images = array();
    $texts = array();
    foreach($contents as $c)
    {
      switch($c->format)
      {
        case "link":
          $links[] = $c;
          break;
        case "file":
          $files[] = $c;
          break;
        case "image":
          $images[] = $c;
          break;
        case "text":
          $texts[] = $c;
          break;
      }
    }
    require_once('views/project/viewProject.php');
  }
}
?>
