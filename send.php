<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars($_POST['name']);
  $username = htmlspecialchars($_POST['username']);
  $message = htmlspecialchars($_POST['message']);

  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@lavantaride.com';      
    $mail->Password   = 'unol zsuj laiq xxga';     
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('info@lavantaride.com', $name);

    $mail->addAddress('info@lavantaride.com', 'Recipient Name');

    $mail->isHTML(true);
    $mail->Subject = 'Message from Lavanta Ride' . $name;

    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date("Y-m-d H:i:s");

    $mail->Body = "
      <p><b>Name:</b> $name</p>
      <p><b>Telegram:</b> $username</p>
      <p><b>Message:</b><br>$message</p>
      <hr>
      <p><small>Sended: $date</small><br>
      <small>IP: $ip</small></p>
    ";

    $mail->send();
    echo json_encode(["status" => "success", "message" => "Message sent successfully"]);
  } catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Failed to send message. Error: {$mail->ErrorInfo}"]);
  }
}
