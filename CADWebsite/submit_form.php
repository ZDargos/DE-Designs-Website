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
    if (!empty($_FILES['filename']['name'][0])) {
        for ($i = 0; $i < count($_FILES['filename']['name']); $i++) {
            $fileTmpName = $_FILES['filename']['tmp_name'][$i];
            $fileName = $_FILES['filename']['name'][$i];
            $fileSize = $_FILES['filename']['size'][$i];
            $fileType = $_FILES['filename']['type'][$i];

            if (is_uploaded_file($fileTmpName)) {
                $mail->addAttachment($fileTmpName, $fileName);
            }
        }
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
