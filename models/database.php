<?php
Class Database
{
  public static function index($int)
  {
    $postIDs=[];
    $postNames=[];
    $postDates=[];
    $postContents=[];
    $db = Db::getInstance();
    $stmt = $db->prepare("SELECT * FROM post ORDER BY postTime, postDate ASC LIMIT 3");
    //$data = array($int);
    $results = $stmt->execute();
    $outputresults ="";
    if(!$stmt)
    {
      echo "\nPDO::errorINFO():\n";
      print_r($db->errorInfo());
    }
    try
    {
      while($result = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        $postIDS[] = $result['postID'];
        $postNames[] = $result['postName'];
        $postDates[]= $result['postDate'];
        $content = $db->query("SELECT * FROM content WHERE postID = ".$result['postID']);
        foreach($content->fetchAll() as $item)
        {
          $postContents[] = $item['contenetContents'];
        }
      }
    }
    catch (PDOException $e)
    {
      return "Error: " . $e->getMessage();
    }
    return array($postIDs, $postNames, $postDates, $postContents);
  }

  public static function getByTag($tagArray)
  {
    $db = Db:: getInstance();
    $postNames=[];
    $postContents=[];
    $postIDs=[];
    $postDates=[];
    $postImages=[];
    $postAuthorID = "";
    $postAuthors=[];
    foreach($tagArray as $tagfetch)
    {
      $stmt = $db->prepare("SELECT post.postName, post.postID, post.postDate,post.author FROM post INNER JOIN (SELECT post_tag.postID FROM post_tag WHERE post_tag.tagID = (SELECT tagID FROM tag WHERE tagName = ?)) as a on a.postID = post.postID ORDER BY post.postDate DESC, post.postTime DESC");
      $data = array($tagfetch);
      $results = $stmt->execute($data);
      while($result=$stmt->fetch(PDO::FETCH_ASSOC))
      {
        $stmt2 = $db->prepare("SELECT * FROM content WHERE postID = ?");
        $data= array($result['postID']);
        $postIDs[]=$result['postID'];
        $postDates[] = $result['postDate'];
        $results2 = $stmt2->execute($data);
        $postNames[] = $result['postName'];
        $postAuthorID = $result['author'];
        while($results2 = $stmt2->fetch(PDO::FETCH_ASSOC))
        {
          $postContents[]= $results2['contentContents'];
        }
        $stmt3 = $db->prepare("SELECT imageFile FROM image WHERE image.imageID IN (SELECT imageID from post_image WHERE postID = ?)");
        $data = array($result['postID']);
        $results3 = $stmt3->execute($data);
        $stmt4 = $db->prepare("SELECT firstName, lastName FROM user WHERE userID = ?");
        $data = array($postAuthorID);
        $results4 = $stmt4->execute($data);
        if($stmt4->rowCount()>0)
        {
          $list=[];
          while($results4 = $stmt4->fetch(PDO::FETCH_ASSOC))
          {
            $list[]= $results4['firstName']." ".$results4['lastName'];
          }
          $postAuthors[]=$list;
        }
        else
        {
          $postAuthors[]="";
        }
        if($stmt3->rowCount()>0)
        {
          $list = [];
          while($results3 = $stmt3->fetch(PDO::FETCH_ASSOC))
          {
            $list[]= $results3["imageFile"];
          }
          $postImages[]=$list;
        }
        else
        {
          $postImages[] = "";
        }
      }
      $list = array($postNames, $postContents, $postIDs, $postDates,$postImages,$postAuthors);
      return $list;
    }
  }

  public static function getTags($postID)
  {
    $list = [];
    $db = Db::getInstance();
    $stmt = $db->prepare("SELECT tagID FROM post_tag where postID = ?");
    $data = array($postID);
    $stmt->execute($data);
    while($result = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      $stmt2 = $db->prepare("SELECT tagName FROM tag WHERE tagID = ?");
      $data = array($result['tagID']);
      $rows = $stmt2->execute($data);
      while($row = $stmt2->fetch(PDO::FETCH_ASSOC))
      {
        $list[] = $row['tagName'];
      }
    }
    return $list;
  }

  public static function getPost($postID)
  {
    $postName = "";
    $postDate = "";
    $postTime = "";
    $postContents = array();
    $postContentIDs = array();
    $postImages= array();
    $db = Db::getInstance();
    $stmt = $db->prepare("SELECT * FROM post WHERE postID = ?");
    $data = array($postID);
    $stmt->execute($data);
    $row = $stmt->fetch();
    $content = $db->query("SELECT * FROM content WHERE postID =" . $postID);

    $postName = $row['postName'];
    $postDate = $row['postDate'];
    $postTime = $row['postTime'];

    $stmt3 = $db->prepare("SELECT imageFile FROM image WHERE image.imageID IN (SELECT imageID from post_image WHERE postID = ?)");
    $data = array($postID);
    $results3 = $stmt3->execute($data);
    if($stmt3->rowCount()>0)
    {
      while($results3 = $stmt3->fetch(PDO::FETCH_ASSOC))
      {
        $postImages[]= $results3["imageFile"];
      }
    }
    else
    {
      $postImages[] = "";
    }
    foreach($content->fetchAll() as $item)
    {
      $postContents[] = $item['contentContents'];
      $postContentIDs[] = $item['contentID'];
    }
    return array($postName, $postDate, $postTime, $postContents, $postContentIDs, $postImages);
  }

  public static function updatePost($postID, $postName, $postDate, $postTime, $contents, $contentsID)
  {
    $message ="";
    $db = Db::getInstance();
    $PostChange = "UPDATE post SET postName = ?, postDate = ?, postTime= ? WHERE postID = ?";
    $postchangedata = array($postName, $postDate, $postTime, $postID);

    $stmt = $db->prepare($PostChange);
    $stmt->execute($postchangedata);

    $ContentChange = "UPDATE content SET contentContents = ? WHERE contentID = ?";
    $stmt = $db->prepare($ContentChange);
    for($i=0;$i<sizeof($contents);$i++)
    {
      $contentchangedata = array($contents[$i], $contentsID[$i]);
      $stmt->execute($contentchangedata);
    }

    $message = "Update Successful";
    return $message;
  }

  public static function deletePost($postID)
  {
    $db = Db::getInstance();
    $stmt = $db->prepare($sql);
    $sql = "DELETE FROM post WHERE postID =?";
    foreach($postID as $id)
    {
      $data = array($id);
      $stmt->execute($data);
    }
    return "Posts Deleted";
  }
}
?>
