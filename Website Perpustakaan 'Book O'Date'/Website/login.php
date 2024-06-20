<?php
session_start();

include 'includes/db.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error_message = "Username atau password salah!";
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Login</h2>
    <?php if ($error_message != '') { ?>
        <p class="error-msg"><?php echo $error_message; ?></p>
    <?php } ?>
    <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
</div>
<?php include 'includes/footer.php'; ?>
