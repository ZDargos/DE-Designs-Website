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

if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['file']['name']));
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
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
    if (isset($uploadfile)) {
        $mail->addAttachment($uploadfile, $_FILES['file']['name']);
    }
    $mail->send();
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $mail->ErrorInfo]);
}
?>
