<?php
session_start();

include 'includes/db.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username already exists
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error_message = "Username telah digunakan!";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            $success_message = "Pendaftaran berhasil!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Register</h2>
    <?php if ($error_message != '') { ?>
        <p class="error-msg"><?php echo $error_message; ?></p>
    <?php } ?>
    <?php if ($success_message != '') { ?>
        <p class="success-msg"><?php echo $success_message; ?></p>
    <?php } ?>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Daftar">
    </form>
</div>
<?php include 'includes/footer.php'; ?>
