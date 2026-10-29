
<?php
header('Content-Type: text/plain; charset=utf-8');

require_once __DIR__ . '/db.php';

try {
    $stmt = $conn->query("SELECT DATABASE()");
    echo "Database connection successful!\n";
    echo "Connected database: " . $stmt->fetchColumn();
} catch (Throwable $e) {
    http_response_code(500);
    echo "Database test failed.";
    error_log($e->getMessage());
}

