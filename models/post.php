<?php
Class Post
{
  public $id;
  public $title;
  public $date;
  public $content;
  public $files;
  public $author;
  public $images;
  public $tags;

//  ==================================================================================== POST OBJECT
  public function __construct($idin, $titlein, $datein, $contentin, $filesin, $authorin, $imagesin, $tagsin)
  {
    $this->id       = $idin;
    $this->title    = $titlein;
    $this->date     = $datein;
    $this->content  = $contentin;
    $this->files    = $filesin;
    $this->author   = $authorin;
    $this->images   = $imagesin;
    $this->tags     = $tagsin;
  }
//  ==================================================================================== GET A POST
  public static function getPost($postID)
  {
    $db = Db::getInstance();
    $sql = "SELECT * FROM post WHERE postID = ? ";
    $data = array($postID);
    try
    {
      $stmt=$db->prepare($sql);
      $stmt->execute($data);
      $post = $stmt->fetch(PDO::FETCH_ASSOC);
      $contents = Post::getContent($postID);
      $tags = Post::getTags($postID);
      $author = Post::getAuthor($post['author']);
      $images = Post::getImages($postID);
      return new Post($postID, $post['postName'], $post['postDate'],$contents,[],$author,$images,$tags);
    }
    catch(PDOException $e)
    {
      echo "ERROR in getPost: " . $e->getMessage();
    }
  }
//  ==================================================================================== GET ALL POSTS
  public function all()
  {
    $db = Db::getInstance();
    $sql = "SELECT postID FROM post ORDER BY post.postDate DESC, post.postTime DESC";
    $postList = array();

    try
    {
      $stmt = $db->prepare($sql);
      $results = $stmt->execute();
      while($result = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $postList[] = Post::getPost($result['postID']);
      }
      return $postList;
    }
    catch(PDOException $e)
    {
      echo "ERROR in all: " . $e->getMessage();
    }
  }
//  ==================================================================================== GET A NUMBER OF POSTS
  public static function quantity($quant)
  {
    $db = Db::getInstance();
    $sql = "SELECT postID FROM post ORDER BY post.postDate DESC, post.postTime DESC LIMIT :howmany ";
    $postList = array();

    try
    {
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':howmany', $quant, PDO::PARAM_INT);
      $stmt->execute();
      while($result = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $postList[] = Post::getPost($result['postID']);
      }
      return $postList;
    }
    catch(PDOException $e)
    {
      echo "ERROR in quantity: " . $e->getMessage();
    }
  }
  //  ==================================================================================== GET POST BY TAG
    public static function tag($tag)
    {
      $db = Db::getInstance();
      $sql = "SELECT post.postID FROM post INNER JOIN (SELECT post_tag.postID FROM post_tag WHERE post_tag.tagID IN (SELECT tagID FROM tag WHERE tagName = ?)) as a on a.postID = post.postID ORDER BY post.postDate DESC, post.postTime DESC";
      $data = array($tag);
      $postList = array();
      $counter = 0;
      try
      {
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        while($result = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $postList[] = Post::getPost($result['postID']);
        }
        return $postList;
      }
      catch(PDOException $e)
      {
        echo "ERROR in tag: " . $e->getMessage();
      }
    }
//  ==================================================================================== GET CONTENT OF POST
  public static function getContent($postID)
  {
    $db = Db::getInstance();
    $sql = "SELECT contentContents FROM content WHERE postID =?";
    $data = array($postID);


    try
    {
      $stmt = $db->prepare($sql);
      $results = $stmt->execute($data);
      return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
    catch(PDOException $e)
    {
      echo "ERROR in getcontent: " . $e->getMessage();
    }

  }
//  ==================================================================================== GET IMAGES
  public static function getImages($postID)
  {
    $db = Db::getInstance();
    $sql ="SELECT imageFile FROM image WHERE image.imageID IN (SELECT imageID FROM post_image WHERE postID = ?)";
    $data = array($postID);
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
    catch(PDOException $e)
    {
      echo "ERROR in getImages: " . $e->getMessage();
    }
  }
//  ==================================================================================== GET AUTHORS
  public static function getAuthor($userID)
  {
    $db = Db::getInstance();
    $sql="SELECT firstName, lastName FROM user WHERE userID =?";
    $data = array($userID);
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result['firstName']." ".$result['lastName'];
    }
    catch(PDOException $e)
    {
      echo "ERROR in getAuthor: " . $e->getMessage();
    }
  }
//  ==================================================================================== GET TAGS
  public static function getTags($postID)
  {
    $db = Db::getInstance();
    $sql = "SELECT tag.tagName FROM tag WHERE tag.tagID IN (SELECT post_tag.tagID FROM post_tag WHERE post_tag.postID = ?) ";
    $data = array($postID);
    try
    {
      $stmt = $db->prepare($sql);
      $result = $stmt->execute($data);
      return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
    catch(PDOException $e)
    {
      echo "ERROR in getTags: " . $e->getMessage();
    }
  }
}
