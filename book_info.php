<?php
// book_info.php — return live book info as JSON
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/db.php'; // provides $conn / $mysqli

$bookId    = isset($_GET['book_id']) ? (int)$_GET['book_id'] : 0;
$bookTitle = isset($_GET['book_title']) ? trim($_GET['book_title']) : '';

if ($bookId <= 0 && $bookTitle === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Missing book_id or book_title']);
    exit;
}

try {
    if ($bookId > 0) {
        $stmt = $conn->prepare('SELECT book_id, title, author, year, `condition`, copies, categories FROM book WHERE book_id = ?');
        $stmt->bind_param('i', $bookId);
    } else {
        $stmt = $conn->prepare('SELECT book_id, title, author, year, `condition`, copies, categories FROM book WHERE title = ?');
        $stmt->bind_param('s', $bookTitle);
    }
    $stmt->execute();
    $res  = $stmt->get_result();
    $book = $res->fetch_assoc();
    $stmt->close();

    if (!$book) {
        http_response_code(404);
        echo json_encode(['ok' => false, 'error' => 'Not found']);
        exit;
    }

    echo json_encode(['ok' => true, 'book' => $book]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Server error']);
}
