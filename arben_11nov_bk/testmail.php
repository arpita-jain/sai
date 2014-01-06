<?php
/*phpinfo();
echo "I am here";
// The message
$message="hell0";
$message = "Line 1\r\nLine 2\r\nLine 3";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70, "\r\n");

// Send
mail('madhuri.g@cisinlabs.com', 'My Subject', $message);*/

include('PHPMailerAutoload.php');
$mail = new PHPMailer;

$mail->isSMTP();                    // Set mailer to use SMTP
$mail->Host = 'smtp.rsasearch.co.za';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->SMTPDebug  = 1;
$mail->Username = 'schools@rsasearch.co.za';                            // SMTP username
$mail->Password = 'Pol44qwe';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'from@example.com';
$mail->FromName = 'Mailer';
$mail->addAddress('prachi.c@cisinlabs.com', 'Prachi');  // Add a recipient
$mail->addAddress('prachi.c@cisinlabs.com');               // Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
print_r($mail);
if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo 'Message has been sent';
?>
