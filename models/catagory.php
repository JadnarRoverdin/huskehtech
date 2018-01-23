<?php
Class Catagory
{
  public $id;
  public $title;
  public $desc;
  public $tags;

//  ==================================================================================== TAG OBJECT
  public function __construct($idin, $titlein, $descin,$tagsin)
  {
    $this->id       = $idin;
    $this->title    = $titlein;
    $this->desc     = $descin;
    $this->tags     = $tagsin;
  }
//  ====================================================================================  GET TAGS
  public static function getCats()
  {
    $list = [];
    $postNames = [];
    $postIDs = [];
    $db = Db::getInstance();
    $stmt = $db->prepare("SELECT * FROM catagory ORDER BY catagoryName");
    try
    {
      $stmt->execute();
      $output = array();
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $tags = Tag::catagory($r['catagoryID']);
        $output[] = new Catagory($r['catagoryID'],$r['catagoryName'],$r['catagoryDescription'],$tags);
      }
      return $output;
    }
    catch(PDOException $e)
    {
      return "Error: " . $e->getMessage();
    }
  }
//  ==================================================================================== INSERT TAG
  public static function insertCat($catName, $catDesc)
  {
    $message = "";
    try
    {
      $db = Db:: getInstance();
      $stmt = $db->prepare("INSERT INTO catagory (catagoryName, catagoryDescription) VALUES (?,?)");
      $data = array($catName, $catDesc);
      $stmt->execute($data);
      $message ="Successfully inserted a new catagory";
    }
    catch (PDOException $e)
    {
      $message = "Error: " . $e->getMessage();
    }
    return $message;
  }
}
