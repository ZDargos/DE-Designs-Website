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

$name = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$message = $_POST["message"];
echo $_FILES;
$uploadedFiles = array();
if (!empty($_FILES['filename']) && is_array($_FILES['filename']['tmp_name'])) {
    foreach ($_FILES['filename']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['filename']['name'][$key];
        move_uploaded_file($tmp_name, "uploads/" . $file_name);
    }
} else {
    echo "No valid files uploaded.";
}
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

    $mail->setFrom($email, $name);
    $mail->addAddress("jackceriello@gmail.com", "Jack");

    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->SMTPDebug = 0;
    
    if (!empty($uploadedFiles)) {
        
        foreach ($uploadedFiles as $file) {
            $mail->addAttachment($file['file_path'], $file['file_name']);
        }
    }
    $mail->send();
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $mail->ErrorInfo]);
}

if (!empty($uploadedFiles)) {
    foreach ($uploadedFiles as $file) {
        unlink($file['file_path']);
    }
}
?>
