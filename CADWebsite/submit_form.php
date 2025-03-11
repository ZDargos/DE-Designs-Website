<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);
    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "de.designs.autoemail@gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = "de.designs.autoemail@gmail.com";
    $mail->Password = "jackspassword";

    $mail->setFrom($email, $name);
    $mail->addAddress("zardragos@gmail.com", "Zack");

    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();

    header("Location: sent.html");
}