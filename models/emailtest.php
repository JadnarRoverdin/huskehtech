<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

$to = "jason.dignan@maine.edu";
      $subject = 'HuskehTech Test';
      $message = "Testing the email system";
      $headers = 'From: no-reply@huskeh.com' . "\r\n" . 'Reply-To: no-reply@huskehtech.com';
      mail($to, $subject, $message, $headers);
      return array(1, "Email confirmation email sent");

?>
