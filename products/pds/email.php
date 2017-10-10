<?php
$to      = 'seandinwiddie@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: seandinwiddie@gmail.com' . "\r\n" .
    'Reply-To: seandinwiddie@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>
