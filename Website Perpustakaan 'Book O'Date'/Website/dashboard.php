<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'includes/db.php';

$search = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM books";
}

$result = $conn->query($sql);
?>

<?php include 'includes/header2.php'; ?>
<div class="container">
    <h2>Dashboard</h2>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    <p><a href="logout.php" class="button logout-button">Logout</a></p>

    <?php if (isset($_SESSION['success_message'])): ?>
        <p class="success-msg"><?php echo $_SESSION['success_message']; ?></p>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <p class="error-msg"><?php echo $_SESSION['error_message']; ?></p>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <h3>Menu Peminjaman Buku</h3>
    <p><a href="history.php" class="button history-button">Lihat Riwayat Peminjaman</a></p>

    <form method="post" action="">
        <input type="text" name="search" placeholder="Cari buku..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="button">Cari</button>
    </form>

    <table border="1">
        <tr>
            <th>Judul</th>
            <th>Peminjam</th>
            <th>Aksi</th>
        </tr>
        <?php while ($book = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['borrower']; ?></td>
                <td>
                    <?php if (empty($book['borrower'])): ?>
                        <a href="borrow.php?id=<?php echo $book['id']; ?>" class="button borrow-button">Pinjam</a>
                    <?php elseif ($book['borrower'] == $_SESSION['username']): ?>
                        <a href="return_book.php?id=<?php echo $book['id']; ?>" class="button return-button">Kembalikan</a>
                        <?php else: ?>
                            <span class="dipinjam">Telah dipinjam</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
