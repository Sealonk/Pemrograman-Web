<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'includes/db.php';

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $username = $_SESSION['username'];
    
    // Set borrower to current user to indicate book is borrowed
    $sql = "UPDATE books SET borrower='$username' WHERE id=$book_id";
    
    if ($conn->query($sql) === TRUE) {
        // Insert into borrow_history
        $sql = "INSERT INTO borrow_history (book_id, username) VALUES ($book_id, '$username')";
        $conn->query($sql);
        
        $_SESSION['success_message'] = "Buku berhasil dipinjam!";
    } else {
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

header('Location: dashboard.php');
?>
