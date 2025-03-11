<?php
header('Content-Type: application/json');
require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mail = new PHPMailer(true);

try {
    
    
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Use environment variables
    $mail->Username = $_ENV["SMTP_USERNAME"];
    $mail->Password = $_ENV["SMTP_PASSWORD"];

    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    // Handle file attachments
    if(trim(!empty($_FILES['filename']['tmp_name']))) {
        $fileTmpName = $_FILES['filename']['tmp_name'];
        $fileName = $_FILES['filename']['name'];
        $mail->addAttachment($fileTmpName, $fileName);

    }

    $mail->setFrom($email, $name);
    $mail->addAddress("zardragos@gmail.com", "Jack");

    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->send();
    $mail->smtpClose();
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $mail->ErrorInfo]);
}
?>
