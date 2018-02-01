<?php
Class Project
{
  public $id;
  public $user;
  public $title;
  public $description;
  public $date;
  public $time;
  public $rawtime;
  public $rawdate;
  public $content;
  public $tags;

//  ==================================================================================== POST OBJECT
  public function __construct($idin, $useridin, $titlein, $descriptionin, $publishDate, $publishTime)
  {
    $this->id           = $idin;
    $this->user       = User::id($useridin)[1];
    $this->title        = $titlein;
    $this->description  = $descriptionin;
    $this->date  = date("m-d-Y", strtotime($publishDate));
    $this->time  = date_format(date_create($publishTime), 'g:i a');
    $this->rawdate      = $publishDate;
    $this->rawtime      = $publishTime;
    $this->content      = Content::project($idin)[1];
    $this->tags         = Tag::project($idin)[1];

  }
  //  ==================================================================================== INSERT POST

  public static function insert($useridin, $titlein, $descriptionin, $publishDate, $publishTime)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "INSERT INTO  project (userID, title, description, publishDate, publishTime) VALUES (?,?,?,?,?)";
    $data = array($useridin, $titlein, $descriptionin, $publishDate, $publishTime);

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
  public static function id($projectID)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "SELECT * FROM project WHERE ID = ? ";
    $data = array($projectID);
    try
    {
      $stmt=$db->prepare($sql);
      $stmt->execute($data);
      $r = $stmt->fetch(PDO::FETCH_ASSOC);
      $code = 1;
      $message =  new Project($r['ID'], $r['userID'], $r['title'],$r['description'],$r['publishDate'], $r['publishTime']);
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
    $sql = "SELECT * FROM project ORDER BY project.publishDate DESC, project.publishTime DESC";
    $list = array();
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute();
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $list[] = new Project($r['ID'], $r['userID'], $r['title'],$r['description'],$r['publishDate'], $r['publishTime']);
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
//  ==================================================================================== GET A NUMBER OF POSTS
  public static function quantity($quant)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "SELECT * FROM project ORDER BY project.publishDate DESC, project.publishTime DESC";
    $list = array();
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $counter = 0;
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        if($counter < $quant)
          $list[] = new Project($r['ID'], $r['userID'], $r['title'],$r['description'],$r['publishDate'], $r['publishTime']);
          $counter++;
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
    $sql = "SELECT * FROM project WHERE userID = ? ORDER BY project.publishDate DESC, project.publishTime DESC";
    $data = array($userID);
    $list = array();
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $list[] = new Project($r['ID'], $r['userID'], $r['title'],$r['description'],$r['publishDate'], $r['publishTime']);
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
  public static function tag($tagID)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "SELECT * FROM project WHERE ID IN (SELECT projectID FROM project_tag WHERE project_tag.tagID = ?)";
    $data = array($tagID);
    $list = array();
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $list[] = new Project($r['ID'], $r['userID'], $r['title'],$r['description'],$r['publishDate'], $r['publishTime']);
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

  public static function update($id, $titlein, $descriptionin, $publishDate, $publishTime)
  {
    $message;
    $code;
    $db = Db::getInstance();
    $sql = "UPDATE project SET title = ?, description = ?, publishDate = ?, publishTime = ? WHERE ID = ? ";
    $data = array( $title, $descriptionin, $publishDate, $publishTime, $id);
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      $code = 1;
      $message = "Successfully updated project";
    }
    catch (PDOException $e)
    {
      $message = $e->getMessage();
      $code = $e->getCode();
    }
    return array($code, $message);
  }
  //  ==================================================================================== Delete POST

  public static function delete($projectID)
  {
    $project = Project::id($projectID)[1];
    foreach($project->content as $c)
    {
      if($c->format == 'image' || $c->format == 'file')
        unlink($c->data);
    }

    $db = Db::getInstance();
    $sql = "DELETE FROM project WHERE ID = ? ";
    $data = array($projectID);
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      $code = 1;
      $message = "Successfully deleted project";
    }
    catch (PDOException $e)
    {
      $message = $e->getMessage();
      $code = $e->getCode();
    }
    return array($code, $message);

  }

}
