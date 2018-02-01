<?php
Class PortfolioController
{
  public function newPortfolio()
  {

  }
//===================================================================================
  public function newProject()
  {
    $authorID = User::getIDbyToken($_SESSION['token'])[1];
    $currentTimeStamp = $_SERVER['REQUEST_TIME'];
    $rawdate = date("Y-m-d", $currentTimeStamp);
    $rawtime = date("h:i:s", $currentTimeStamp);
    if(isset($_POST['title']))
    {
      if($_POST['update'] == 'true')
        Project::update($_POST['projectID'], $_POST['title'],$_POST['description'],$_POST['date'],$_POST['time']);
      else
        Project::insert($_POST['author'], $_POST['title'],$_POST['description'],$_POST['date'],$_POST['time']);
        echo("<script>location.href = '?controller=pages&action=portfolio';</script>");
    }
    else
    {
      require_once('views/portfolio/projectEditor.php');
    }
  }
//===================================================================================
  public function update()
  {
    $authorID = User::getIDbyToken($_SESSION['token'])[1];
    $update = true;
    $post = Project::id($_GET['projectID'])[1];

    require_once('views/portfolio/projectEditor.php');
  }

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
    require_once('views/portfolio/viewPortfolio.php');
  }
}
?>
