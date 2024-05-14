<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include konfigurasi database
    $host = "localhost";
    $user = "root";
    $password = ""; // Biarkan kosong jika tidak ada password
    $database = "produk";

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];

    if ($password != $confirm_password) {
        echo '<script type ="text/JavaScript">';  
        echo 'alert("Password dan konfirmasi password tidak cocok")';  
        echo '</script>';
        echo "<meta http-equiv='refresh' content='0;url=reset_password_form.php?email=$email&token=$token'>";  
        exit();
    }

    // Query untuk menyimpan password baru ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password='$hashed_password' WHERE email='$email'";
    
    if ($conn->query($sql) === TRUE) {
        // Hapus token dari sesi setelah password diubah
        unset($_SESSION['reset_email']);
        unset($_SESSION['reset_token']);
        echo '<script type ="text/JavaScript">';  
        echo 'alert("Password telah direset dan tersimpan")';  
        echo '</script>';
        echo "<meta http-equiv='refresh' content='0;url=index.php'>";  
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: lupa_password.php"); // Redirect jika akses langsung
}
?>
