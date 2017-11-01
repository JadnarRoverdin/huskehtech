<?php

$to = "jason.dignan@maine.edu";
      $subject = 'HuskehTech Test';
      $message = "Testing the email system";
      $headers = 'From: no-reply@huskeh.com' . "\r\n" . 'Reply-To: no-reply@huskehtech.com';
      mail($to, $subject, $message, $headers);
      return array(1, "Email confirmation email sent");

?>
