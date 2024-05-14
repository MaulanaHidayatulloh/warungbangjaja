<?php
session_start();

if (!isset($_GET['email']) || !isset($_GET['token'])) {
    // Pesan peringatan jika tautan tidak valid
    header("Location: lupa_password.php");
    exit();
}

$email = $_GET['email'];
$token = $_GET['token'];

if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_token']) || $_SESSION['reset_email'] != $email || $_SESSION['reset_token'] != $token) {
    // Pesan peringatan jika tautan tidak cocok dengan sesi yang tersimpan
    echo "Tautan reset password tidak valid.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="reset_password.php" method="post"> <!-- Perbaiki aksi form -->
        <label for="password">Password Baru:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="confirm_password">Konfirmasi Password Baru:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>"> <!-- Pastikan nilai email aman -->
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>"> <!-- Pastikan nilai token aman -->
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
