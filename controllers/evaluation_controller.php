<?php
class EvaluationController
{
  public function index()
  {
    $message = "Index page of evaluation";
    require_once('views/evaluation/index.php');
  }

  public function addCriteria()
  {
    $message = "LETS ADD A CRITERIA";
    require_once('views/evaluation/newCriteria.php');
  }

  public function addCriteriaSet()
  {
    $message = "Lets create a criteria Set";
    $criterias = Evaluation::getCriteria(0);
    $criteriaIDs = $criterias[0];
    $criteriaNames=$criterias[1];
    $criteriaDescs=$criterias[2];
    require_once('views/evaluation/newCriteriaSet.php');
  }




  public function insertCriteria()
  {
    $message = "";
    $criteriaNames = array();
    $criteriaDescs = array();

    if(isset($_POST['criterianame']))
    {
      foreach($_POST['criterianame'] as $name)
      $criteriaNames[] = $name;
      foreach($_POST['criteriatext'] as $text)
      $criteriaDescs[] = $text;

      $insertedIds = Evaluation::addCriteria($criteriaNames, $criteriaDescs);
      foreach($insertedIds as $id)
      echo $id;

      $message = "Criteria Collected";
    }
    else
    {
      $message ="No Criteria to Add";
    }
    require_once('views/evaluation/newCriteria.php');
  }

  public function insertCriteriaSet()
  {
    $message ="";
    $criteriaSetID = 0;
    $selectedCriteriaIDs = array();
    if($_POST['setName'] != "")
    {
      $criteriaSetID = Evaluation::addCriteriaSet($_POST['setName'], $_POST['setDesc']);
      foreach($_POST['criterias'] as $selectedCriteria)
        $selectedCriteriaIDs[] = $selectedCriteria;
      Evaluation::addCriteriaToCriteriaSet($criteriaSetID, $selectedCriteriaIDs);
      $message = "Criteria Set created";
    }
    else
    {
      $message = "Unable to Create Criteria Set";
    }
    $criterias = Evaluation::getCriteria(0);
    $criteriaIDs = $criterias[0];
    $criteriaNames=$criterias[1];
    $criteriaDescs=$criterias[2];
    require_once('views/evaluation/newCriteriaSet.php');
  }
}


?>
