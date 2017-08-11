<?php
include_once('\PHPMailer\PHPMailerAutoload.php');
$mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch
try {
    $mail->SMTPDebug = 4;                               // Enable verbose debug output
    $mail->isSMTP();                                    // Set mailer to use SMTP
    $mail->Host = 'http://localhost:8080/'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                             // Enable SMTP authentication
    $mail->Username = 'root';           // SMTP username
    $mail->Password = '';                       // SMTP password
    $mail->SMTPSecure = 'tls';                          // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                  // TCP port to connect, tls=587, ssl=465
    $mail->From = 'admin@teknaps.com';
    $mail->FromName = 'Teknaps Contact Form';
    $mail->addAddress('vramya.rv@gmail.com', 'Ramya');     // Add a recipient
    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    $mail->isHTML(false);                                  // Set email format to HTML
    $mail->Subject = 'subject';
    $mail->Body    = 'message';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
    $errors[] = "Send mail sucsessfully";
} catch (phpmailerException $e) {
    $errors[] = $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    $errors[] = $e->getMessage(); //Boring error messages from anything else!
}
?>