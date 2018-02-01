<?php
Class Profile
{
  public $id;
  public $userID;
  public $dob;
  public $location;
  public $biography;
  public $avatar;
//=================================================================================== STRUCT
  public function __construct($id, $userID, $dob, $location, $bio, $avatar)
  {
    $this->id = $id;
    $this->userID = $userID;
    $this->dob = $dob;
    $this->location = $location;
    $this->biography = $bio;
    $this->avatar = $avatar;
  }

//=================================================================================== CREATE
  public static function create($userID, $dob, $location, $biography, $avatar)
  {
    $errorCode;
    $message;

    $db = Db::getInstance();
    $sql = "INSERT INTO profile (userID, dob, location, biography, avatar) VALUES (?,?,?,?,?)";
    try
    {
      $stmt = $db->prepare($sql);
      $data = array($userID, $dob, $location, $biography, $avatar);
      $stmt->execute($data);
      $errorCode = 1;
      $message = "Profile Created";
    }
    catch(PDOException $e)
    {
      $errorCode  = $e->getCode();
      $message    = "creation of profile. ".$e->getMessage();
    }

    return array($errorCode, $message);
  }
//=================================================================================== CREATE
  public static function getbyUser($userID)
  {
    $errorCode;
    $message;

    $db = Db::getInstance();
    $sql = "SELECT * FROM profile WHERE userID = ?";
    try
    {
      $stmt = $db->prepare($sql);
      $data = array($userID);
      $stmt->execute($data);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      $errorCode = 1;
      $message = new Profile($result['ID'],$result['userID'],$result['dob'],$result['location'],$result['biography'],$result['avatar']);
    }
    catch(PDOException $e)
    {
      $errorCode  = $e->getCode();
      $message    = "getting profile by user ".$e->getMessage();
    }

    return array($errorCode, $message);
  }
}
