<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if (empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  exit("Invalid input.");
}

$name = htmlspecialchars(strip_tags($_POST['name']));
$email = htmlspecialchars(strip_tags($_POST['email']));
$m_subject = htmlspecialchars(strip_tags($_POST['subject']));
$message = htmlspecialchars(strip_tags($_POST['message']));

$mail = new PHPMailer(true);

try {
  // Server settings
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
  $mail->SMTPAuth = true;
  $mail->Username = 'sandeepamallawarachchi444@gmail.com';
  $mail->Password = 'qkxx lmnw intx twru';
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
  $mail->Port = 587; // SMTP port

  // Recipients
  $mail->setFrom('sandeepamallawarachchi444@gmail.com', 'Explorer Center'); // Your email and name
  $mail->addAddress('sandeepamallawarachchi444@gmail.com', 'Sandeepa Mallawarachchi'); // Recipient email and name
  $mail->addReplyTo($email, $name); // Reply-To email and name

  // Content
  $mail->isHTML(true);
  $mail->Subject = $m_subject;
  $mail->Body = "You have received a new message from your website contact form.<br><br>
                   <strong>Name:</strong> $name<br>
                   <strong>Email:</strong> $email<br>
                   <strong>Subject:</strong> $m_subject<br>
                   <strong>Message:</strong> $message";

  $mail->send();
  http_response_code(200);
  echo "Message has been sent successfully";
} catch (Exception $e) {
  http_response_code(500);
  echo "Message could not be sent. Error: {$mail->ErrorInfo}";
}
