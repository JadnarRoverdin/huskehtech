<?php
Class Portfolio
{
  public $id;
  public $userID;
  public $title;
  public $description;


//  ==================================================================================== POST OBJECT
  public function __construct($idin, $useridin, $titlein, $descriptionin)
  {
    $this->id           = $idin;
    $this->userID       = $useridin;
    $this->title        = $titlein;
    $this->description  = $descriptionin;

  }
  //  ==================================================================================== INSERT POST

  public static function insert($useridin, $titlein, $descriptionin)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "INSERT INTO  portfolio (userID, title, description) VALUES (?,?,?)";
    $data = array($useridin, $titlein, $descriptionin);

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
  public static function id($portfolioID)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "SELECT * FROM portfolio WHERE ID = ? ";
    $data = array($postID);
    try
    {
      $stmt=$db->prepare($sql);
      $stmt->execute($data);
      $r = $stmt->fetch(PDO::FETCH_ASSOC);
      $code = 1;
      $message =  new Portfolio($r['ID'], $r['userID'], $r['title'],$r['description']);
    }
    catch(PDOException $e)
    {
      $message = $e->getMessage();
      $code = $e->getCode();
    }
    return array($code, $message);
  }
//  ==================================================================================== GET ALL POSTS
  public static function all()
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "SELECT * FROM portfolio";
    $list = array();
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute();
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $list[] = new Portfolio($r['ID'], $r['userID'], $r['title'],$r['description']);
      }
      $code = 1;
      $message = $list;
    }
    catch(PDOException $e)
    {
      $message = $e->getMessage();
      $code = $e->getCode();
    }
    return array($code, $message);
  }

//  ==================================================================================== GET AUTHORS
  public static function byAuthor($userID)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "SELECT * FROM portfolio WHERE userID =?";
    $data = array($userID);
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $list[] = new Project($r['ID'], $r['userID'], $r['title'],$r['description']);
      }
      $code = 1;
      $message = $list;
    }
    catch(PDOException $e)
    {
      $message = $e->getMessage();
      $code = $e->getCode();
    }
    return array($code, $message);
  }

  //  ==================================================================================== UPDATE POST

  public static function update($id, $titlein, $descriptionin)
  {
    $message;
    $code;
    $db = Db::getInstance();
    $sql = "UPDATE portfolio SET title = ?, description = ? WHERE ID = ? ";
    $data = array($title, $descriptionin, $id);
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      $code = 1;
      $message = "Successfully updated post";
    }
    catch (PDOException $e)
    {
      $message = $e->getMessage();
      $code = $e->getCode();
    }
    return array($code, $message);
  }
  //  ==================================================================================== Delete POST

  public static function delete($portfolioID)
  {

    $db = Db::getInstance();
    $sql = "DELETE FROM portfolio WHERE ID = ? ";
    $data = array($portfolioID);
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      $code = 1;
      $message = "Successfully deleted post";
    }
    catch (PDOException $e)
    {
      $message = $e->getMessage();
      $code = $e->getCode();
    }
    return array($code, $message);

  }

}
