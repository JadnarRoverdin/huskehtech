<?php
Class Tag
{
  public $id;
  public $title;
  public $desc;

//  ==================================================================================== TAG OBJECT
  public function __construct($idin, $titlein, $descin)
  {
    $this->id       = $idin;
    $this->title    = $titlein;
    $this->desc     = $descin;
  }
//  ====================================================================================  GET TAGS
  public static function getTags()
  {
    $list = [];
    $postNames = [];
    $postIDs = [];
    $db = Db::getInstance();
    $stmt = $db->prepare("SELECT * FROM tag ORDER BY tagName");
    try
    {
      $stmt->execute();
      $output = array();
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $output[] = new Tag($r['tagID'],$r['tagName'],$r['tagDescription']);
      }
      return $output;
    }
    catch(PDOException $e)
    {
      return "Error: " . $e->getMessage();
    }
  }
//  ==================================================================================== INSERT TAG
  public static function insertTag($tagName, $tagDescription)
  {
    $message = "";
    try
    {
      $db = Db:: getInstance();
      $stmt = $db->prepare("INSERT INTO tag (tagName, tagDescription) VALUES (?,?)");
      $data = array($tagName, $tagDescription);
      $stmt->execute($data);
      $message ="Successfully inserted a new Tag";
    }
    catch (PDOException $e)
    {
      $message = "Error: " . $e->getMessage();
    }
    return $message;
  }
  //  ==================================================================================== GET TAG BY CATAGORY

  public static function catagory($catID)
  {
    $db = Db::getInstance();
    $sql = "SELECT * FROM tag WHERE tagID IN (SELECT tagID FROM catagory_tag WHERE catagory_tag.catagoryID = ?)";

    $stmt = $db->prepare($sql);
    $data = array($catID);
    try
    {
      $stmt->execute($data);
      $output = array();
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $output[] = new Tag($r['tagID'],$r['tagName'],$r['tagDescription']);
      }
      return $output;
    }
    catch(PDOException $e)
    {
      return "Error: " . $e->getMessage();
    }
  }
  //  ==================================================================================== ASSOCIATE TAG WITH CATAGORY

  public static function associateTagWithCatagory($catID, $tagIDs)
  {
    $message = "";
    try
    {
      $db = Db:: getInstance();
      $stmt = $db->prepare("INSERT INTO catagory_tag (catagoryID, tagID) VALUES (?,?)");
      foreach($tagIDs as $tagID)
      {
        $data = array($catID, $tagID);
        $stmt->execute($data);
      }
      $message ="Successfully linked tags to Catagory";
    }
    catch (PDOException $e)
    {
      $message = "Error: " . $e->getMessage();
    }
    return $message;
  }
}
