<?php
Class Content
{
  public $id;
  public $title;
  public $caption;
  public $size;
  public $format;
  public $data;
  public $projectID;

  public function __construct($idin, $titlein, $captionin, $sizein, $formatin, $datain,$projectIDin)
  {
    $this->id          = $idin;
    $this->title       = $titlein;
    $this->caption     = $captionin;
    $this->size        = $sizein;
    $this->format      = $formatin;
    $this->data        = $datain;
    $this->projectID   = $projectIDin;
  }
  //  ====================================================================================
  public static function insert ($title, $caption, $size, $format, $data, $authorID, $projectID)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "INSERT INTO  content (title, caption, size, format, data, projectID) VALUES (?,?,?,?,?,?)";
    $data = array($title, $caption, $size, $format, $data, $projectID);

    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      $code = 1;
      $message = $db->lastInsertId();
    }
    catch (PDOException $e)
    {
      $message = $e->getMessage();
      $code = $e->getCode();
    }
    return array($code, $message);
  }
  //  ==================================================================================== GET A POST
    public static function id($ID)
    {
      $message="";
      $code;
      $db = Db::getInstance();
      $sql = "SELECT * FROM content WHERE ID = ?";
      $data = array($ID);
      $dataout = array();
      try
      {
        $stmt=$db->prepare($sql);
        $stmt->execute($data);
        while($r = $stmt->fetch(PDO::FETCH_ASSOC))
          $dataout[] =  new Content($r['ID'], $r['title'], $r['caption'],$r['size'], $r['format'], $r['data'],$r['projectID']);
        $code = 1;
        $message = $dataout;
      }
      catch(PDOException $e)
      {
        $message = $e->getMessage();
        $code = $e->getCode();
      }
      return array($code, $message);
    }
//  ==================================================================================== GET A POST
  public static function project($projectID)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "SELECT * FROM content WHERE projectID = ?";
    $data = array($projectID);
    $dataout = array();
    try
    {
      $stmt=$db->prepare($sql);
      $stmt->execute($data);
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
        $dataout[] =  new Content($r['ID'], $r['title'], $r['caption'],$r['size'], $r['format'], $r['data'],$r['projectID']);
      $code = 1;
      $message = $dataout;
    }
    catch(PDOException $e)
    {
      $message = $e->getMessage();
      $code = $e->getCode();
    }
    return array($code, $message);
  }
  //  ====================================================================================
  public static function associateWithProject($contentID, $projectID)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "INSERT INTO  project_content (projectID, contentID) VALUES (?,?)";
    $data = array($projectID, $contentID);

    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      $code = 1;
      $message = $db->lastInsertId();
    }
    catch (PDOException $e)
    {
      $message = $e->getMessage();
      $code = $e->getCode();
    }
    return array($code, $message);
  }


}
?>
