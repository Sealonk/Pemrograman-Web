<?php
include 'db.php';

function getBooks($conn) {
    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);
    return $result;
}
?>
