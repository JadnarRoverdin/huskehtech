<?php

class User
{
  public static function insertUser($fname, $lname, $email, $password)
  {
    $db = Db::getInstance();
    $stmt = $db->prepare("INSERT INTO user (firstName, lastName,email,password) VALUES(?,?,?,?)");
    $data = array($fname, $lname, $email, $password);
    $stmt->execute($data);
    return  "User has been registered";
  }

  public static function login($username, $password)
  {
    $db = Db::getInstance();
    $stmt = $db->prepare("SELECT * FROM user WHERE email = ? AND password=?");
    $data = array($username, $password);
    $stmt->execute($data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['admin']= $result['admin'];
    $_SESSION['fname']= $result['firstName'];
    $_SESSION['lname']= $result['lastName'];
    $_SESSION['userID'] = $result['userID'];

  }

  public static function logout()
  {
    session_unset();
    return "User has been logged off";
  }
}



?>
