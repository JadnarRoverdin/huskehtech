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
  //  ==================================================================================== INSERT POST

  public static function insertPost($postName, $postContent, $postCatagory, $imageNames, $imagePath,$date,$time, $userID)
  {
    $message="";

    try
    {
      $db = Db::getInstance();                                                                                //Create a database object for PDO
      $stmt = $db->prepare("INSERT INTO  post (postName, postDate, postTime,author) VALUES (?,?,?,?)");
      echo $date;              //Insert post name, date and time into the database
      $data = array($postName, $date, $time,$userID);                                                 //Collects name from input, and gets current date and time
      $stmt->execute($data);
      $lastInsert = $db->lastInsertId();                                                                      //get the post's ID
      $stmt = $db->prepare("INSERT INTO content (contentContents, postID) VALUES (?,?)");                     //Insert the post content into the database
      $data = array($postContent, $lastInsert);                                                               //collects content from input, and uses the post's id
      $stmt->execute($data);
      for($i=0; $i < sizeof($postCatagory);$i++)                                                              //Works to connect post to one or more tags
      {
        $stmt = $db->prepare("INSERT INTO post_tag (postID, tagID) VALUES (?,?)");
        $data = array($lastInsert, $postCatagory[$i]);
        $stmt->execute($data);
      }
      for($i=0;$i<sizeof($imageNames);$i++)                                                                   //works to connect one or more files to the post
      {
        $stmt = $db->prepare("INSERT INTO image (imageName, imageFile, imageCaption, imageDate) VALUES (?,?,?,?)");
        $data = array($imageNames[$i], $imagePath[$i], " ", $date );
        $stmt->execute($data);
        $lastInsertImage = $db->lastInsertId();
        $stmt = $db->prepare("INSERT INTO post_image (imageID, postID) VALUES (?,?)");
        $data = array($lastInsertImage, $lastInsert);
        $stmt->execute($data);
      }

      $message = "Successfully inserted a new Post";                                                          //if the try catch block executes without issue, this message is generated
    }
    catch (PDOException $e)
    {
      $message = "Error: " . $e->getMessage();                                                                //else, capture the fault and make that the message
    }
    return $message;                                                                                          //output the generated message.
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
      $author = User::getUser($post['author']);
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
    $sql = "SELECT contentID, contentContents FROM content WHERE postID =?";
    $data = array($postID);


    try
    {
      $stmt = $db->prepare($sql);
      $results = $stmt->execute($data);
      $output = array();
      while($r = $stmt->fetch(PDO::FETCH_ASSOC, 0))
      {
        $output[] = array($r['contentID'], nl2br($r['contentContents']));
      }
      return $output;
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
  //  ==================================================================================== UPDATE POST

  public static function updatePost($postID, $postName, $postDate, $postTime, $postContent, $postContentID)
  {



  }

}
