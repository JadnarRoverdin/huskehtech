<?php
class Upload
{
  public static function avatarUpload($avatar)
  {
    $message;
    $target_dir = "img/profileAvatars/";
    $name;
    $tempName;
    $baseName;
    $targetFile;
    $name = $avatar["name"];

    $baseName = basename($avatar["name"]);
    $tempName = $avatar["tmp_name"];
    $target_file = $target_dir . $baseName;
    $targetFile =$target_file;
    $uploadOK = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $check = $name;
    if(move_uploaded_file($tempName, $target_file))
    {
    $message =  $target_file;
    }
    else
    {
      $message =  "";
    }
    return $message;
  }
}
?>
