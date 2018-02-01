<?php

class SubmissionController
{
  public function submit()
  {
    $message = "";
    $successful = false
    $targetDir = "";
    $format = $_POST['format'];

    switch($format)
    {
      case 'link':
        break;
      case 'text':
        break;
      case 'image':
        $targetDir = "submissions/images";
        break;
      case 'file':
        $targetDir = "submissions/files";
        break;
    }
  }
}
