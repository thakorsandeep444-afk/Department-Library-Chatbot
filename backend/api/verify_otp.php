<?php
session_start();

header("Content-Type: application/json");

// Support both FormData ($_POST) and JSON payload input
$rawInput = file_get_contents("php://input");
$jsonData = json_decode($rawInput, true);

$email = trim($_POST['email'] ?? $jsonData['email'] ?? '');
$otp   = trim($_POST['otp'] ?? $jsonData['otp'] ?? '');

if (empty($email) || empty($otp)) {
    echo json_encode([
        "success" => false,
        "message" => "Email and OTP are required."
    ]);
    exit;
}

if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_email'])) {
    echo json_encode([
        "success" => false,
        "message" => "No OTP session found. Please request a new OTP first."
    ]);
    exit;
}

// Enforce 5-minute (300 seconds) expiration window
if (isset($_SESSION['otp_time']) && (time() - $_SESSION['otp_time'] > 300)) {
    unset($_SESSION['otp'], $_SESSION['otp_email'], $_SESSION['otp_time']);
    echo json_encode([
        "success" => false,
        "message" => "OTP has expired. Please request a new one."
    ]);
    exit;
}

if ($_SESSION['otp_email'] !== $email) {
    echo json_encode([
        "success" => false,
        "message" => "Email address does not match the active OTP session."
    ]);
    exit;
}

if ($_SESSION['otp'] != $otp) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid OTP code."
    ]);
    exit;
}

// Clear OTP session variables upon successful verification
unset($_SESSION['otp'], $_SESSION['otp_email'], $_SESSION['otp_time']);

echo json_encode([
    "success" => true,
    "message" => "OTP verified successfully."
]);