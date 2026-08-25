<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../PHPMailer/Exception.php";
require_once __DIR__ . "/../PHPMailer/PHPMailer.php";
require_once __DIR__ . "/../PHPMailer/SMTP.php";

function getMailer()
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();

    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;

    // Fallback to direct credentials if environment variables aren't set
    $username = getenv("MAIL_USERNAME") ?: "departmentlibrary.ai@gmail.com";
    $password = getenv("MAIL_PASSWORD") ?: "uxobtjrsfqpnqsch"; // Replace with your 16-character App Password

    $mail->Username = $username;
    $mail->Password = $password;

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender email must match the authenticated Gmail username
    $mail->setFrom($username, "Department Library");

    $mail->isHTML(true);

    return $mail;
}