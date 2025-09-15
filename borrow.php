<?php
// borrow.php — safe + transactional
header('Content-Type: text/plain; charset=utf-8');

require_once __DIR__ . '/db.php'; // provides $mysqli and $conn (alias)

// Accept either book_id (preferred) or book_title (fallback)
$bookId   = isset($_POST['book_id']) ? (int)$_POST['book_id'] : 0;
$bookTitleIn = isset($_POST['book_title']) ? trim($_POST['book_title']) : '';

if ($bookId <= 0 && $bookTitleIn === '') {
    http_response_code(400);
    exit('Missing book_id or book_title.');
}

try {
    // Start a transaction so we can lock a row and update safely
    $conn->begin_transaction();

    // 1) Lock the target book row
    if ($bookId > 0) {
        $stmt = $conn->prepare('SELECT book_id, title, copies FROM book WHERE book_id = ? FOR UPDATE');
        $stmt->bind_param('i', $bookId);
    } else {
        // If using title, lock the matching row. If you expect duplicates, you should pass book_id instead.
        $stmt = $conn->prepare('SELECT book_id, title, copies FROM book WHERE title = ? FOR UPDATE');
        $stmt->bind_param('s', $bookTitleIn);
    }

    $stmt->execute();
    $res  = $stmt->get_result();
    $book = $res->fetch_assoc();
    $stmt->close();

    if (!$book) {
        // Nothing to borrow
        $conn->rollback();
        http_response_code(404);
        exit('Book not found.');
    }

    if ((int)$book['copies'] <= 0) {
        // Already out of stock
        $conn->rollback();
        http_response_code(409);
        exit('No copies available.');
    }

    // 2) Decrement copies
    $newCopies = (int)$book['copies'] - 1;
    $stmtU = $conn->prepare('UPDATE book SET copies = ? WHERE book_id = ?');
    $stmtU->bind_param('ii', $newCopies, $book['book_id']);
    $stmtU->execute();
    $stmtU->close();

    // 3) Insert borrow record
    $today = date('Y-m-d');
    $stmtI = $conn->prepare('INSERT INTO borrow (book_id, title, borrow_date) VALUES (?, ?, ?)');
    $stmtI->bind_param('iss', $book['book_id'], $book['title'], $today);
    $stmtI->execute();
    $stmtI->close();

    // 4) Commit
    $conn->commit();

    echo 'Book borrowed successfully! Remaining copies: ' . $newCopies;
} catch (Throwable $e) {
    // On any error, rollback and show a clean message
    if ($conn->errno) {
        $conn->rollback();
    }
    http_response_code(500);
    echo 'An error occurred while borrowing the book.';
} finally {
    // Close connection (optional; PHP will close it at the end anyway)
    $conn->close();
}
