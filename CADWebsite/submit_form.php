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
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    // Handle file attachments
    $files = $_POST["filename", "tmp_name"];
    echo $files;
    if (!empty($_FILES['filename']['name'][0])) {
        for ($i = 0; $i < count($_FILES['filename']['name']); $i++) {
            if (is_uploaded_file($_FILES['filename']['tmp_name'][$i])) {
                $mail->addAttachment($_FILES['filename']['tmp_name'][$i], $_FILES['filename']['name'][$i]);
            }
        }
    }
    $mail->addAttachment('images/logo/logo-light-gray.png');
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Use environment variables
    $mail->Username = $_ENV["SMTP_USERNAME"];
    $mail->Password = $_ENV["SMTP_PASSWORD"];

    $mail->setFrom($email, $name);
    $mail->addAddress("jackceriello@gmail.com", "Jack");

    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->send();
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $mail->ErrorInfo]);
}
?>
