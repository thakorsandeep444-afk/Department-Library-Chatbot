<?php
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

require_once __DIR__ . '/../config/db.php';

function respond($status, $message, $data = null) {
    http_response_code($status);
    echo json_encode(['success' => $status >= 200 && $status < 300, 'message' => $message, 'data' => $data]);
    exit;
}

function inputData() {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function ensureBooksTable($conn) {
    $conn->exec("CREATE TABLE IF NOT EXISTS books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        book_id VARCHAR(50) NULL UNIQUE,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(255) DEFAULT '',
        department VARCHAR(100) DEFAULT '',
        semester VARCHAR(50) DEFAULT '',
        publication_year VARCHAR(20) DEFAULT '',
        quantity INT NOT NULL DEFAULT 1,
        available_quantity INT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

try { ensureBooksTable($conn); } catch (PDOException $e) { respond(500, 'Unable to access books table.'); }

$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        if (isset($_GET['id'])) {
            $stmt = $conn->prepare('SELECT * FROM books WHERE id = ?');
            $stmt->execute([(int)$_GET['id']]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$book) respond(404, 'Book not found.');
            respond(200, 'Book retrieved successfully.', $book);
        }

        $sql = 'SELECT * FROM books';
        $params = [];
        if (!empty($_GET['search'])) {
            $s = '%' . trim($_GET['search']) . '%';
            $sql .= ' WHERE title LIKE ? OR author LIKE ? OR department LIKE ? OR semester LIKE ? OR publication_year LIKE ?';
            $params = [$s, $s, $s, $s, $s];
        }
        $sql .= ' ORDER BY id DESC';
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        respond(200, 'Books retrieved successfully.', $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    if ($method === 'POST') {
        $d = inputData();
        if (empty(trim($d['title'] ?? ''))) respond(400, 'Book title is required.');
        $q = max(1, (int)($d['quantity'] ?? 1));
        $aq = isset($d['available_quantity']) ? (int)$d['available_quantity'] : $q;
        if ($aq < 0 || $aq > $q) respond(400, 'Available quantity must be between 0 and quantity.');
        $stmt = $conn->prepare('INSERT INTO books (book_id,title,author,department,semester,publication_year,quantity,available_quantity) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->execute([
            trim($d['book_id'] ?? '') ?: null, trim($d['title']), trim($d['author'] ?? ''),
            trim($d['department'] ?? ''), trim($d['semester'] ?? ''), trim($d['publication_year'] ?? ''), $q, $aq
        ]);
        $id = $conn->lastInsertId();
        $stmt = $conn->prepare('SELECT * FROM books WHERE id = ?'); $stmt->execute([$id]);
        respond(201, 'Book added successfully.', $stmt->fetch(PDO::FETCH_ASSOC));
    }

    if ($method === 'PUT') {
        $d = inputData();
        $id = (int)($d['id'] ?? 0);
        if ($id <= 0) respond(400, 'Book id is required for update.');
        $stmt = $conn->prepare('SELECT * FROM books WHERE id = ?'); $stmt->execute([$id]);
        $old = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$old) respond(404, 'Book not found.');
        $fields = ['book_id','title','author','department','semester','publication_year','quantity','available_quantity'];
        $v = [];
        foreach ($fields as $f) $v[$f] = array_key_exists($f,$d) ? $d[$f] : $old[$f];
        $v['title'] = trim((string)$v['title']);
        if ($v['title'] === '') respond(400, 'Book title cannot be empty.');
        $v['quantity'] = max(1, (int)$v['quantity']);
        $v['available_quantity'] = (int)$v['available_quantity'];
        if ($v['available_quantity'] < 0 || $v['available_quantity'] > $v['quantity']) respond(400, 'Invalid available quantity.');
        $stmt = $conn->prepare('UPDATE books SET book_id=?, title=?, author=?, department=?, semester=?, publication_year=?, quantity=?, available_quantity=? WHERE id=?');
        $stmt->execute([trim((string)$v['book_id']) ?: null,$v['title'],trim((string)$v['author']),trim((string)$v['department']),trim((string)$v['semester']),trim((string)$v['publication_year']),$v['quantity'],$v['available_quantity'],$id]);
        $stmt = $conn->prepare('SELECT * FROM books WHERE id = ?'); $stmt->execute([$id]);
        respond(200, 'Book updated successfully.', $stmt->fetch(PDO::FETCH_ASSOC));
    }

    if ($method === 'DELETE') {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : (int)(inputData()['id'] ?? 0);
        if ($id <= 0) respond(400, 'Book id is required for deletion.');
        $stmt = $conn->prepare('DELETE FROM books WHERE id = ?'); $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) respond(404, 'Book not found.');
        respond(200, 'Book deleted successfully.');
    }

    respond(405, 'Method not allowed.');
} catch (PDOException $e) {
    if ($e->getCode() === '23000') respond(409, 'Book ID already exists.');
    respond(500, 'Database operation failed.');
}
?>
