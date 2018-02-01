<?php
Class Tag
{
  public $id;
  public $title;
//=================================================================================== STRUCT
  public function __construct($id, $title)
  {
    $this->id = $id;
    $this->title = $title;

  }

//=================================================================================== CREATE
  public static function create($title)
  {
    $errorCode;
    $message;

    $db = Db::getInstance();
    $sql = "INSERT INTO tag (title) VALUES (?)";
    try
    {
      $stmt = $db->prepare($sql);
      $data = array($title);
      $stmt->execute($data);
      $errorCode = 1;
      $message = $db->lastInsertId();;
    }
    catch(PDOException $e)
    {
      $errorCode  = $e->getCode();
      $message    = $e->getMessage();
    }

    return array($errorCode, $message);
  }
//=================================================================================== CREATE
  public static function all()
  {
    $errorCode;
    $message;
    $db = Db::getInstance();
    $sql = "SELECT * FROM tag ORDER BY title ASC";
    $list = array();
    try
    {
      $stmt = $db->prepare($sql);

      $stmt->execute();
      while($result = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $list[]= new Tag($result['ID'], $result['title']);
      }

      $errorCode = 1;
      $message = $list;
    }
    catch(PDOException $e)
    {
      $errorCode  = $e->getCode();
      $message    = $e->getMessage();
    }

    return array($errorCode, $message);
  }
//=================================================================================== CREATE
  public static function id($id)
  {
    $errorCode;
    $message;

    $db = Db::getInstance();
    $sql = "SELECT * FROM tag WHERE ID = ?";
    try
    {
      $stmt = $db->prepare($sql);
      $data = array($id);
      $stmt->execute($data);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      $errorCode = 1;
      $message = new Tag($result['ID'], $result['title']);
    }
    catch(PDOException $e)
    {
      $errorCode  = $e->getCode();
      $message    = $e->getMessage();
    }
    return array($errorCode, $message);
  }
//=================================================================================== CREATE
  public static function title($title)
  {
    $errorCode;
    $message;

    $db = Db::getInstance();
    $sql = "SELECT * FROM tag WHERE title = ?";
    try
    {
      $stmt = $db->prepare($sql);
      $data = array($title);
      $stmt->execute($data);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      $errorCode = 1;
      $message = new Tag($result['ID'], $result['title']);
    }
    catch(PDOException $e)
    {
      $errorCode  = $e->getCode();
      $message    = "getting profile by user ".$e->getMessage();
    }
    return array($errorCode, $message);
  }
  //=================================================================================== CREATE
    public static function associateWithProject($tagID, $projectID)
    {
      $errorCode;
      $message;
      $db = Db::getInstance();
      $sql = "INSERT INTO project_tag (tagID, projectID) VALUES (?,?)";
      try
      {
        $stmt = $db->prepare($sql);
        $data = array($tagID, $projectID);
        $stmt->execute($data);
        $errorCode = 1;
        $message = $db->lastInsertId();;
      }
      catch(PDOException $e)
      {
        $errorCode  = $e->getCode();
        $message    = $e->getMessage();
      }

      return array($errorCode, $message);
    }
  //===================================================================================
    public static function associateWithPost($tagID, $postID)
    {
      $errorCode;
      $message;
      $db = Db::getInstance();
      $sql = "INSERT INTO post_tag (tagID, postID) VALUES (?,?)";
      try
      {
        $stmt = $db->prepare($sql);
        $data = array($tagID, $postID);
        $stmt->execute($data);
        $errorCode = 1;
        $message = $db->lastInsertId();;
      }
      catch(PDOException $e)
      {
        $errorCode  = $e->getCode();
        $message    = $e->getMessage();
      }

      return array($errorCode, $message);
    }
  //=================================================================================== CREATE
    public static function project($projectID)
    {
      $errorCode;
      $message;

      $db = Db::getInstance();
      $sql = "SELECT * FROM tag WHERE ID in (SELECT tagID FROM project_tag WHERE project_tag.projectID = ?)";
      $list = array();
      try
      {
        $stmt = $db->prepare($sql);
        $data = array($projectID);
        $stmt->execute($data);
        while($result = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $list[]= new Tag($result['ID'], $result['title']);
        }

        $errorCode = 1;
        $message = $list;
      }
      catch(PDOException $e)
      {
        $errorCode  = $e->getCode();
        $message    = "getting profile by user ".$e->getMessage();
      }
      return array($errorCode, $message);
    }
  //===================================================================================
  public static function post($postID)
  {
    $errorCode;
    $message;

    $db = Db::getInstance();
    $sql = "SELECT * FROM tag WHERE ID in (SELECT tagID FROM post_tag WHERE post_tag.postID = ?)";
    $list = array();
    try
    {
      $stmt = $db->prepare($sql);
      $data = array($postID);
      $stmt->execute($data);
      while($result = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $list[]= new Tag($result['ID'], $result['title']);
      }

      $errorCode = 1;
      $message = $list;
    }
    catch(PDOException $e)
    {
      $errorCode  = $e->getCode();
      $message    = "getting profile by user ".$e->getMessage();
    }
    return array($errorCode, $message);
  }
  //=================================================================================== CREATE
    public static function catagory($catagoryID)
    {
      $errorCode;
      $message;

      $db = Db::getInstance();
      $sql = "SELECT * FROM tag WHERE ID in (SELECT tagID FROM catagory_tag WHERE catagory_tag.catagoryID = ?)";
      $list = array();
      try
      {
        $stmt = $db->prepare($sql);
        $data = array($catagoryID);
        $stmt->execute($data);
        while($result = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $list[]= new Tag($result['ID'], $result['title']);
        }

        $errorCode = 1;
        $message = $list;
      }
      catch(PDOException $e)
      {
        $errorCode  = $e->getCode();
        $message    = "getting profile by user ".$e->getMessage();
      }
      return array($errorCode, $message);
    }
  //=================================================================================== CREATE
    public static function catagoryName($catName)
    {
      $errorCode;
      $message;

      $db = Db::getInstance();
      $sql = "SELECT * FROM tag WHERE ID in (SELECT tagID FROM catagory_tag WHERE catagory_tag.catagoryID IN (SELECT ID FROM catagory WHERE catagory.title = ?))";
      $list = array();
      try
      {
        $stmt = $db->prepare($sql);
        $data = array($catName);
        $stmt->execute($data);
        while($result = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $list[]= new Tag($result['ID'], $result['title']);
        }

        $errorCode = 1;
        $message = $list;
      }
      catch(PDOException $e)
      {
        $errorCode  = $e->getCode();
        $message    = "getting profile by user ".$e->getMessage();
      }
      return array($errorCode, $message);
    }
}
