<?php
class Email
{
  $to = "jadnarroverdin@gmail.com";
  
  public send($fromemail, $fromname,$text)
  {
    $subject = 'HT-CONTACT from '.$fromname;
    $headers = 'From: contact@huskehtech.com' . "\r\n" . 'Reply-To: no-reply@huskehtech.com';
    $message = $fromname." used Huskeh Tech's contact form \n".
                $fromemail." is their email\n".
                "Their Message:\n".$text;
    mail($to, $subject, $message, $headers);
    return "Email sent";

  }
}
?>
