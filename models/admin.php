<?php
Class Admin
{
  public static function insertPost($postName, $postContent, $postCatagory, $imageNames, $imagePath,$date,$time)
  {
    $message="";

    try
    {
      $db = Db::getInstance();                                                                                //Create a database object for PDO
      $stmt = $db->prepare("INSERT INTO  post (postName, postDate, postTime,author) VALUES (?,?,?,?)");
      echo $date;              //Insert post name, date and time into the database
      $data = array($postName, $date, $time,$_SESSION['userID']);                                                 //Collects name from input, and gets current date and time
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


  public static function getTags()
  {
    $list = [];
    $postNames = [];
    $postIDs = [];
    $db = Db::getInstance();
    $results = $db->query("SELECT * FROM tag ORDER BY tagName");
    try
    {
      foreach($results->fetchAll() as $result)
      {
        $postNames[] = $result['tagName'];
        $postIDs[] = $result['tagID'];
      }
      $list = array($postNames, $postIDs);
    }
    catch(PDOException $e)
    {
      echo "Error: " . $e->getMessage();
    }
    return $list;
  }

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
}
?>
