<?php
Class Post
{
  public $id;
  public $title;
  public $date;
  public $time;
  public $content;
  public $author;
  public $rawtime;
  public $rawdate;
  public $tags;

//  ==================================================================================== POST OBJECT
  public function __construct($idin, $titlein, $datein, $timein,$contentin, $authorin)
  {
    $this->id       = $idin;
    $this->title    = $titlein;
    $this->date     = date("m/d/Y", strtotime($datein));
    $this->time     = date_format(date_create($timein), 'g:i a');
    $this->content  = $contentin;
    $this->author   = User::id($authorin)[1];
    $this->rawdate  = $datein;
    $this->rawtime  = $timein;
    $this->tags    = Tag::post($idin)[1];
  }
  //  ==================================================================================== INSERT POST

  public static function insert($title, $content, $date, $time, $authorID)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "INSERT INTO  post (title, content, publishDate, publishTime ,author) VALUES (?,?,?,?,?)";
    $data = array($title, $content, $date, $time, $authorID);

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
  public static function id($postID)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "SELECT * FROM post WHERE ID = ? ";
    $data = array($postID);
    try
    {
      $stmt=$db->prepare($sql);
      $stmt->execute($data);
      $r = $stmt->fetch(PDO::FETCH_ASSOC);
      $code = 1;
      $message =  new Post($r['ID'], $r['title'], $r['publishDate'],$r['publishTime'], $r['content'], $r['author']);
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
    $sql = "SELECT * FROM post ORDER BY post.publishDate DESC, post.publishTime DESC";
    $list = array();
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute();
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $list[] = new Post($r['ID'], $r['title'], $r['publishDate'],$r['publishTime'], $r['content'], $r['author']);
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
    $sql = "SELECT * FROM post ORDER BY post.publishDate DESC, post.publishTime DESC";
    $list = array();
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $counter = 0;
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        if($counter < $quant)
          $list[] = new Post($r['ID'], $r['title'], $r['publishDate'],$r['publishTime'], $r['content'], $r['author']);
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
  public static function byAuthor($authorID)
  {
    $message="";
    $code;
    $db = Db::getInstance();
    $sql = "SELECT * FROM post WHERE author =? ORDER BY post.publishDate DESC, post.publishTime DESC";
    $data = array($userID);
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      while($r = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $list[] = new Post($r['ID'], $r['title'], $r['publishDate'],$r['publishTime'], $r['content'], $r['author']);
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

  public static function update($id, $title, $content, $publishDate, $publishTime)
  {
    $message;
    $code;
    $db = Db::getInstance();
    $sql = "UPDATE post SET title = ?, content = ?, publishDate = ?, publishTime = ? WHERE ID = ? ";
    $data = array($title, $content, $publishDate, $publishTime,$id);
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

  public static function delete($postID)
  {

    $db = Db::getInstance();
    $sql = "DELETE FROM post WHERE ID = ? ";
    $data = array($postID);
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
