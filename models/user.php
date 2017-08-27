<?php

class User
{
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $token;
    public $admin;
    public $profile;

//  ==================================================================================== USER OBJECT
    public function __construct($idin, $fn, $ln, $email, $token, $admin, $profile)
    {
      $this->id         = $idin;
      $this->firstName  = $fn;
      $this->lastName   = $ln;
      $this->email      = $email;
      $this->token      = $token;
      $this->admin      = $admin;
      $this->profile    = $profile;
    }
//  ==================================================================================== INSERT USER
  public static function insertUser($fname, $lname, $email, $password)
  {
    $db = Db::getInstance();
    $stmt = $db->prepare("INSERT INTO user (firstName, lastName,email,password,token) VALUES(?,?,?,?,?)");
    $data = array($fname, $lname, $email, $password,'test');
    $stmt->execute($data);
    return  "User has been registered";
  }
//  ==================================================================================== INSERT USER
  public static function login($username, $password)
  {
    $db = Db::getInstance();
    $stmt = $db->prepare("SELECT * FROM user WHERE email = ? AND password=?");
    $data = array($username, $password);
    $stmt->execute($data);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    $profile = Profile::userID($r['userID']);
    $output = new User($r['userID'], $r['firstName'], $r['lastName'],$r['email'], $r['token'], $r['admin'], $profile);
    return $output;
  }
//  ==================================================================================== PULL USER
  public static function getUser($userID)
  {
    $ouput;
    $db = Db::getInstance();
    $sql = "SELECT * FROM user WHERE userID = ?";
    $stmt = $db->prepare($sql);
    try
    {
      $data = array($userID);
      $stmt->execute($data);
      $r = $stmt->fetch(PDO::FETCH_ASSOC);
      $profile = Profile::userID($r['userID']);
      $output = new User($r['userID'], $r['firstName'], $r['lastName'],$r['email'], $r['token'], $r['admin'], $profile);
    }
    catch(PDOException $e)
    {
      $output = $e->getMessage();
    }
    return $output;
  }
//  ==================================================================================== LOGOUT USER
  public static function logout()
  {
    session_unset();
    return "User has been logged off";
  }

}



?>
