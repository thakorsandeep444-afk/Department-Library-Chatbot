<?php
session_start();

header("Content-Type: application/json");

require_once __DIR__ . "/../config/mail.php";

$response = [
    "success" => false,
    "message" => ""
];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $response["message"] = "Invalid request method.";
    echo json_encode($response);
    exit;
}

// Support both FormData ($_POST) and JSON payload input
$rawInput = file_get_contents("php://input");
$jsonData = json_decode($rawInput, true);
$email = trim($_POST["email"] ?? $jsonData["email"] ?? "");

if (empty($email)) {
    $response["message"] = "Email is required.";
    echo json_encode($response);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response["message"] = "Invalid email address.";
    echo json_encode($response);
    exit;
}

$otp = rand(100000, 999999);

$_SESSION["otp"] = $otp;
$_SESSION["otp_email"] = $email;
$_SESSION["otp_time"] = time();

try {
    $mail = getMailer();
    $mail->addAddress($email);
    $mail->Subject = "Department Library OTP Verification";
    $mail->Body = "
    <h2>Department Library</h2>
    <p>Your One-Time Password is:</p>
    <h1 style='letter-spacing:5px;'>$otp</h1>
    <p>This OTP will expire in 5 minutes.</p>
    <p>Do not share this OTP with anyone.</p>
    ";

    $mail->send();
    $response["success"] = true;
    $response["message"] = "OTP sent successfully to $email.";
} catch (Exception $e) {
    $response["message"] = "Mail error: " . $e->getMessage();
}

echo json_encode($response);