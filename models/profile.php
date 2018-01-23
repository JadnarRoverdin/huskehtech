<?php
Class Profile
{
  public $id;
  public $dob;
  public $location;
  public $biography;
  public $avatar;

//  ==================================================================================== TAG OBJECT
  public function __construct($idin, $dobin, $locationin, $bioin, $avatarin)
  {
    $this->id         = $idin;
    $this->dob        = $dobin;
    $this->location   = $locationin;
    $this->biography  = $bioin;
    $this->avatar     = $avatarin;
  }
//  ==================================================================================== INSERT PROFILE
  public static function insert($userID, $dob, $loc, $bio, $ava)
  {
    $ouput;
    $db = Db::getInstance();
    $sql = "INSERT INTO userprofile (userID, DoB, location, biography, avatar) VALUES (?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    try
    {
      $targetFile = Upload::avatarUpload($ava);
      $data = array($dob, $loc, $bio, $targetFile, $userID);
      $stmt->execute($data);
      $output = "Profile Creation successful";
    }
    catch(PDOException $e)
    {
      $output = $e->getMessage();
    }
    return $output;
  }
//  ==================================================================================== PULL BY UserID
  public static function userID($userID)
  {
    $ouput;
    $db = Db::getInstance();
    $sql = "SELECT * FROM userprofile WHERE userID = ?";
    $stmt = $db->prepare($sql);
    try
    {
      $data = array($userID);
      $stmt->execute($data);
      $r = $stmt->fetch(PDO::FETCH_ASSOC);
      $output = new Profile($r['profileID'], $r['DoB'], $r['location'], $r['biography'], $r['avatar']);
    }
    catch(PDOException $e)
    {
      $output = $e->getMessage();
    }
    return $output;
  }
//  ==================================================================================== INSERT PROFILE
  public static function update($userID, $dob, $loc, $bio, $ava)
  {
    $ouput;
    $db = Db::getInstance();
    $sql = "UPDATE userprofile SET DoB= ?, location= ?, biography=?, avatar=? WHERE userID = ?";
    $stmt = $db->prepare($sql);
    try
    {
      $targetFile = Upload::avatarUpload($ava);
      $data = array($dob, $loc, $bio, $targetFile, $userID);
      $stmt->execute($data);
      $output = "Profile UPDATE successful";
    }
    catch(PDOException $e)
    {
      $output = $e->getMessage();
    }
    return $output;
  }
}
?>
