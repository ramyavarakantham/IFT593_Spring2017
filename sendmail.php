<?php
$to= 'ramya.ams6@gmail.com';
$subject= 'subject';
$message= 'message';
$headers= 'From: vramya.rv@gmail.com';
if(mail($to, $subject, $message, $headers))
	echo "email sent";
else
	echo 'email sending failed';
?>