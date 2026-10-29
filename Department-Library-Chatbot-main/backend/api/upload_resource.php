<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed."]);
    exit;
}

// 1. Role Verification
$userRole = $_POST['user_role'] ?? '';
$userEmail = $_POST['uploaded_by'] ?? '';

if ($userRole !== 'faculty') {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Access denied. Only faculty members can upload resources."]);
    exit;
}

// 2. Validate Text Fields
$title = trim($_POST['title'] ?? '');
$category = trim($_POST['category'] ?? '');
$subject = trim($_POST['subject'] ?? '');

$allowedCategories = ['book', 'paper', 'ebook'];
if (empty($title) || empty($subject) || !in_array($category, $allowedCategories)) {
    echo json_encode(["success" => false, "message" => "Please fill in all required fields properly."]);
    exit;
}

// 3. File Upload Validation
if (!isset($_FILES['resource_file']) || $_FILES['resource_file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["success" => false, "message" => "No file uploaded or upload error occurred."]);
    exit;
}

$file = $_FILES['resource_file'];
$maxSize = 25 * 1024 * 1024; // 25 MB Limit

if ($file['size'] > $maxSize) {
    echo json_encode(["success" => false, "message" => "File exceeds maximum size limit of 25MB."]);
    exit;
}

$allowedExtensions = ['pdf', 'epub', 'docx', 'doc'];
$fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($fileExt, $allowedExtensions)) {
    echo json_encode(["success" => false, "message" => "Invalid file format. Allowed formats: PDF, EPUB, DOCX, DOC."]);
    exit;
}

// 4. Save File securely
$uploadDir = "../uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$uniqueName = uniqid("res_", true) . '.' . $fileExt;
$targetFilePath = $uploadDir . $uniqueName;
$dbFilePath = "backend/uploads/" . $uniqueName;

if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
    try {
        $stmt = $conn->prepare("
            INSERT INTO resources (title, category, subject, file_name, file_path, file_size, uploaded_by) 
            VALUES (:title, :category, :subject, :file_name, :file_path, :file_size, :uploaded_by)
        ");

        $stmt->execute([
            ':title'       => $title,
            ':category'    => $category,
            ':subject'     => $subject,
            ':file_name'   => $file['name'],
            ':file_path'   => $dbFilePath,
            ':file_size'   => $file['size'],
            ':uploaded_by' => $userEmail
        ]);

        echo json_encode(["success" => true, "message" => "Resource uploaded successfully!"]);
    } catch (PDOException $e) {
        if (file_exists($targetFilePath)) unlink($targetFilePath);
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Failed to move uploaded file."]);
}
?>