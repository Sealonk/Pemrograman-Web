<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'includes/db.php';

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    
    // Set borrower to NULL to indicate book is returned
    $sql = "UPDATE books SET borrower=NULL WHERE id=$book_id";
    
    if ($conn->query($sql) === TRUE) {
        // Update return_date in borrow_history
        $sql = "UPDATE borrow_history SET return_date=NOW() WHERE book_id=$book_id AND return_date IS NULL";
        $conn->query($sql);
        
        $_SESSION['success_message'] = "Buku berhasil dikembalikan!";
    } else {
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

header('Location: dashboard.php');
?>
