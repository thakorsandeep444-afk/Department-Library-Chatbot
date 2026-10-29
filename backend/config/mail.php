
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../PHPMailer/Exception.php";
require_once __DIR__ . "/../PHPMailer/PHPMailer.php";
require_once __DIR__ . "/../PHPMailer/SMTP.php";

function getMailer()
{
    $mail = new PHPMailer(true);

    // Gmail SMTP settings
    $mail->isSMTP();
    $mail->Host       = "smtp.gmail.com";
    $mail->SMTPAuth   = true;

    // Read credentials from Windows environment variables
    $username = getenv("MAIL_USERNAME");
    $password = getenv("MAIL_PASSWORD");

    // Stop if credentials are missing
    if (!$username || !$password) {
        throw new RuntimeException(
            "Mail configuration is missing. Set MAIL_USERNAME and MAIL_PASSWORD."
        );
    }

    $mail->Username   = $username;
    $mail->Password   = $password;

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom($username, "Department Library");

    // Email format
    $mail->isHTML(true);
    $mail->CharSet = "UTF-8";

    return $mail;
}
