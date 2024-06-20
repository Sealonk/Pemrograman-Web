<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'includes/db.php';

$username = $_SESSION['username'];
$sql = "SELECT bh.id, b.title, bh.borrow_date, bh.return_date
        FROM borrow_history bh
        JOIN books b ON bh.book_id = b.id
        WHERE bh.username='$username'
        ORDER BY bh.borrow_date DESC";
$result = $conn->query($sql);
?>

<?php include 'includes/header2.php'; ?>
<div class="container">
    <h2>Riwayat Peminjaman</h2>
    <p>Welcome, <?php echo $username; ?>!</p>
    <p><a href="dashboard.php" class="button dashboard-button">Dashboard</a> | <a href="logout.php" class="button logout-button">Logout</a></p>

    <h3>Riwayat Peminjaman Buku</h3>
    <?php if ($result->num_rows > 0) { ?>
        <table border="1">
            <tr>
                <th>Judul</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['borrow_date']; ?></td>
                    <td><?php echo $row['return_date'] ? $row['return_date'] : 'Belum dikembalikan'; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>Tidak ada riwayat peminjaman.</p>
    <?php } ?>
</div>
<?php include 'includes/footer.php'; ?>
