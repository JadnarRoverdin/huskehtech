<?php
Class User {
  public $id;
  public $firstName;
  public $lastName;
  public $email;
  public $level;
  public $profile;
//=================================================================================== STRUCT
  public function __construct($id, $firstName, $lastName, $email, $level) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->level = $level;
        $this->profile = Profile::getbyUser($id)[1];
    }
//=================================================================================== CHECK ADMIN
    public static function checkLevel($token)
    {
      $db = Db::getInstance();
      $sql = "SELECT userLevel FROM user WHERE token = ?";
      $data = array($token);
      $stmt = $db->prepare($sql);
      $stmt ->execute($data);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return array(1, $result['userLevel']);
    }
//=================================================================================== CREATE
    public static function create($fn, $ln, $em, $pw, $ul){		//inserts user information into database
      $errorCode;
      $message;
      $check = User::getIDbyEmail($em)[1];					//check if the email already exists in the database

      if($check > 0)
      {
        $errorCode = 4;
        $message   = "Email address is already registered";
      }
      else 																	//else, we insert our new user into the database
      {
        $salted = password_hash($pw, PASSWORD_DEFAULT);
        $db = Db::getInstance();
        $sql = "INSERT INTO user (firstName, lastName, email, userLevel, password, emailConfirmed) VALUES (?,?,?,?,?,?)";
        try
        {
          $stat = 'user';
          $stmt = $db->prepare($sql);
          $data = array($fn, $ln, $em, $ul, $salted, "0");
          $stmt->execute($data);
          $id = $db->lastInsertId();
          Profile::create($id, "","","","");
          User::sendConfirmEmail($em);
          $errorCode = 1;
          $message = "Account Created, Check your email for a confirmation link prior to logging in.";
        }
        catch(PDOException $e)
        {
          $errorCode  = "usercreation ".$e->getCode();
          $message    = $e->getMessage();
        }
      }
      return array($errorCode, $message);
    }
//=================================================================================== DELETE
    public static function delete($id)
    {
      $errorCode;
      $message;
      $db = Db::getInstance();
      $sql = "DELETE FROM user WHERE userID = ?";
      $data = array($id);
      try
      {
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        $errorCode = 1;
        $message = "User Deleted";
      }
      catch(PDOException $e)
      {
        $errorCode  = $e->getCode();
        $message    = $e->getMessage();
      }
      return array($errorCode, $message);
    }
//=================================================================================== CONFIRM EMAIL
    public static function confirmEmail($code)
    {
      $db = Db::getInstance();
      $req = $db->prepare("UPDATE user SET emailConfirmed = '1', emailCode ='' WHERE emailCode = '$code'");
      $req->execute();
      return array(1, "Email Confirmed");

    }
//=================================================================================== SEND CONFIRM EMAIL
    public static function sendConfirmEmail($email)
    {
      $db = Db::getInstance();
      $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
      $result = '';
      for ($i = 0; $i < 19; $i++){
          $result .= $characters[mt_rand(0, 61)];
      }
      $req = $db->prepare("UPDATE user SET emailCode = ? WHERE email = ?");
      $data = array($result, $email);
      $req->execute($data);

      $to = $email;
      $subject = 'HuskehTech Email confirmation';
      $message = 'You registered for an account at HuskehTech.com. Click the link below to confirm your email address \n  ' .
      "http://wwww.HuskehTech.com?controller=user&action=emailConfirmation&code=$result\n" .
      "  If you didn't register for an account ignore this email. \n Do not reply to this email, the inbox is not monitored.";
      $headers = 'From: confirmAccount@huskehtech.com' . "\r\n" . 'confirmAccount: confirmAccount@huskehtech.com';
      mail($to, $subject, $message, $headers);
      return array(1, "Email confirmation email sent");
    }
//=================================================================================== RESET PASSWORD
    public static function resetPassword($code, $password)
    {
      $db = Db::getInstance();
      $salted = password_hash($password, PASSWORD_DEFAULT);
      $req = $db->prepare("UPDATE user SET password = ?, resetCode = '' WHERE resetCode = ?");
      $data = array($salted, $code);
      $req->execute($data);
      return array(1, "Password has been reset");
    }
//=================================================================================== SEND RESET PASSWORD EMAIL
    public static function sendResetEmail($email){
      $db = Db::getInstance();

    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
      $result = '';
      for ($i = 0; $i < 19; $i++){
          $result .= $characters[mt_rand(0, 61)];
      }
    $req = $db->prepare("UPDATE user SET resetCode = ? WHERE email = ?");
    $data = array($result, $email);
    $req->execute($data);

    $to = $email;
    $subject = 'HuskehTech Password Reset';
    $message = 'You requested a password reset. Click the link below to complete the process. \n  ' .
    "www.huskehtech.com?controller=user&action=passwordReset&code=$result" .
    "  If you didn't request a password reset ignore this email";
    $headers = 'From: passwordReset@huskehtech.com' . "\r\n" . 'Reply-To: passwordReset@haggis.com';
    mail($to, $subject, $message, $headers);
    return array(1, "Password Reset Email Sent");
    }
//=================================================================================== ALL USERS
    public static function all(){					//collects user ID's from Database
      $errorCode;
      $message;
      $db = Db::getInstance();
      $sql = "SELECT * FROM user";
      $userList = array();								//used to store User objects
      try
      {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        while($result = $stmt->fetch(PDO::FETCH_ASSOC))		//goes through list
        {
          $userList[] = new User($result['ID'], $result['firstName'], $result['lastName'], $result['email'], $result['userLevel']);	//and adds a user object with information aquired
        }
        $errorCode = 1;
        $message = $userList;			//returns array of User Objects

      }
      catch(PDOException $e)
      {
        $errorCode  = $e->getCode();
        $message    = $e->getMessage();
      }
      return array($errorCode, $message);
    }
//=================================================================================== USERS BY ID
    public static function id($id)
    {
      $errorCode;
      $message;
      $db= Db::getInstance();
      $sql = "SELECT * FROM user WHERE ID = ?";
      $data = array($id);
      try
      {
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result)																									//if we have a result, we pull data out
        {
          $errorCode = 1;
          $message =  new User($result['ID'], $result['firstName'], $result['lastName'], $result['email'], $result['userLevel']);	//and adds a user object with information aquired
        }
        else
        {
          $errorCode = 3;
          $message = "User not found";
        }
      }
      catch(PDOException $e)
      {
        $errorCode  = $e->getCode();
        $message    = $e->getMessage();
      }
      return array($errorCode, $message);
    }
//=================================================================================== LOGIN
    public static function login($email, $password){
      $errorCode;
      $message;
      $userID ='';
      $db= Db::getInstance();
      $sql = "SELECT * FROM user WHERE email = ?";		//Pull from the database anything that matches both email and password
      $data = array($email);
      try
      {
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result)																									//if we have a result, we pull data out
        {
          $hash = $result['password'];
          if(password_verify($password, $hash))
          {
            if($result['emailConfirmed'] == '1')
            {
              $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
              $token = '';
              for ($i = 0; $i < 20; $i++)
                $token .= $characters[mt_rand(0, 61)];
              User::insertToken($result['ID'], $token);
              $errorCode = 1;
              $user = new User($result['ID'], $result['firstName'], $result['lastName'], $result['email'], $result['userLevel']);
              $message = array($user, $token);
            }
            else
            {
              $errorCode = 2;
              $message = "Your email has not yet been confirmed. Please check your email for a confirmation link.";
            }
          }
          else
          {
            $errorCode = 3;
            $message = "Your email and/or password were incorrect. Please try again.";
          }
        }
        else
        {
          $errorCode = 3;
          $message =  "Your email and/or password were incorrect. Please try again.";
        }
      }
      catch(PDOException $e)
      {
        $errorCode  = $e->getCode();
        $message    = $e->getMessage();
      }
      return array($errorCode, $message);
    }
//=================================================================================== INSERT TOKEN
  static function insertToken($userID, $token)
  {
    $errorCode;
    $message;
    $db = Db::getInstance();
    try
    {
      $stmt = $db->prepare("UPDATE user SET token = ? WHERE ID = ?");
      $data = array($token, $userID);
      $stmt->execute($data);
      $errorCode = 1;
      $message = "Token Update Successful";
    }
    catch(PDOException $e)
    {
      $errorCode =  $e->getCode();
      $message =    $e->getMessage();
    }
    return array($errorCode, $message);
  }
//=================================================================================== LOGOUT
    public static function logout($token)
    {
      $db = Db::getInstance();
      $req = $db->prepare("UPDATE user SET token = '' WHERE token = ?");
      $data = array($token);
      $req->execute($data);
      return array(1, "Successful Logoff");
    }
//=================================================================================== UPDATE USER
    public static function update($fn, $ln, $em, $ul, $ui){
      $errorCode;
      $message;
      $db= Db::getInstance();
      $data = array($fn, $ln, $em, $ul, $ui);
      $sql = "UPDATE user SET firstName = ?, lastName = ?,  email = ?, userLevel = ? WHERE userID = ?";
      try
      {
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        $errorCode = 1;
        $message = "User succesfully updated";
      }
      catch(PDOException $e)
      {
        $errorCode  = $e->getCode();
        $message    = $e->getMessage();
      }
      return array($errorCode, $message);
    }
//=================================================================================== GET USER ID
    public static function getIDbyToken($token)
    {
      $errorCode;
      $message;
      $db = Db::getInstance();
      $data= array($token);
      $sql = "SELECT * FROM user WHERE token = ?";
      try
      {
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        $errorCode = 1;
        $message = $r['ID'];
      }
      catch(PDOException $e)
      {
        $errorCode  = $e->getCode();
        $message    = $e->getMessage();
      }
      return array($errorCode, $message);
    }
//=================================================================================== GET BY EMAIL
  public static function getIDbyEmail($em)
  {
    $errorCode;
    $message;
    $db = Db::getInstance();
    $data= array($em);
    $sql = "SELECT * FROM user WHERE email = ?";
    try
    {
      $stmt = $db->prepare($sql);
      $stmt->execute($data);
      $r = $stmt->fetch(PDO::FETCH_ASSOC);
      $errorCode = 1;
      $message = $r['ID'];
    }
    catch(PDOException $e)
    {
      $errorCode  = $e->getCode();
      $message    = "getIDemail ".$e->getMessage();
    }
    return array($errorCode, $message);
  }
}
?>
