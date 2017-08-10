<?php

class Evaluation
{
  public static function addCriteria($criteriaNames, $criteriaDescs)
  {
    $criteriaIDs = array();

    $db = Db::getInstance();
    $sql = "INSERT INTO criteria (criteriaName, criteriaDescription) VALUES(?,?)";
    $stmt = $db->prepare($sql);

    for($i = 0; $i<sizeof($criteriaNames); $i++)
    {
      $data = array($criteriaNames[$i], $criteriaDescs[$i]);
      $stmt ->execute($data);
      $criteriaIDs[] = $db-> LastInsertId();
    }
    return $criteriaIDs;

  }

  public static function addCriteriaSet($criteriaSetName, $criteriaSetDesc)
  {
    $db = Db::getInstance();
    $sql = "INSERT INTO criteriaset (criteriaSetName, criteriaSetDescription) VALUES(?,?)";
    $data = array($criteriaSetName, $criteriaSetDesc);
    $stmt = $db->prepare($sql);
    $stmt->execute($data);
    return $db->lastInsertId();
  }

  public static function getCriteria($id)
  {
    $db = Db::getInstance();
    $sql = "";
    $data = array();
    $criteriaNames = array();
    $criteriaDescs = array();
    $criteriaIDs = array();
    if($id === 0)
    {
      $sql = "SELECT * FROM criteria ORDER BY criteriaName";
    }
    else
    {
      $sql = "SELECT * FROM criteria WHERE criteriaID = ?";
      $data = array($id);
    }
    $stmt = $db->prepare($sql);
    $results = $stmt->execute($data);
    if(!$stmt)
    {
      echo "\nPDO::errorINFO():\n";
      print_r($db->errorInfo());
    }
    try
    {
      while($results = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $criteriaIDs[]=$results['criteriaID'];
        $criteriaNames[] = $results['criteriaName'];
        $criteriaDescs[] = $results['criteriaDescription'];
      }
    }
    catch (PDOException $e)
    {
      return "Error: " . $e->getMessage();
    }
    return array($criteriaIDs, $criteriaNames, $criteriaDescs);
  }

  public static function addCriteriaToCriteriaSet($criteriaSetID, $criteriaIDs)
  {
    $db = Db::getInstance();
    $sql = "INSERT INTO criteriaset_criteria (criteriaSetID, criteriaID ) VALUES (?,?)";
    $stmt = $db->prepare($sql);
    for($i = 0; $i < sizeof($criteriaIDs);$i++)
    {
        $data = array($criteriaSetID, $criteriaIDs[$i]);
        $stmt->execute($data);
    }
  }
}

?>
