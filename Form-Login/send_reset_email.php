<?php
session_start();

// Memuat autoload.php dari direktori lokal
require __DIR__ . '/vendor/autoload.php';

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

    // Query untuk memeriksa apakah email terdaftar di database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Kirim email reset password jika email terdaftar
        $token = bin2hex(random_bytes(32)); // Generate token acak
        $_SESSION['reset_email'] = $email; // Simpan email untuk digunakan nanti
        $_SESSION['reset_token'] = $token; // Simpan token untuk digunakan nanti

        // Pengaturan SMTP
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername('farmfamily1504@gmail.com')
            ->setPassword('odij pche uqly ynno');

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Kirim email
        $reset_link = "http://localhost/warung-bangjaja/form-login/reset_password_form.php?email=$email&token=$token";
        $to = $email;
        $subject = "Reset Password";
        $message = "Silakan klik tautan berikut untuk mereset password Anda: $reset_link";

        $email_message = (new Swift_Message($subject))
            ->setFrom(['farmfamily1504@gmail.com' => 'Reset Password WarungBangJaja'])
            ->setTo($to)
            ->setBody($message);

        // Send the message
        $result = $mailer->send($email_message);

        if ($result) {
            echo '<script type ="text/JavaScript">';  
            echo 'alert("Link Atau Tautan Reset Password Telah Terkirim Ke Email Anda (Silakan Cek Email Anda)")';  
            echo '</script>';
            echo "<meta http-equiv='refresh' content='0;url=lupa_password.php'>";  
        } else {
            echo '<script type ="text/JavaScript">';  
            echo 'alert("Gagal Mengirim Link Atau Tautan Reset Password Ke Email Anda")';  
            echo '</script>';
            echo "<meta http-equiv='refresh' content='0;url=lupa_password.php'>";  
        }
    } else {
        // Jika email tidak terdaftar, berikan pesan bahwa email tidak terdaftar
        echo '<script type ="text/JavaScript">';  
        echo 'alert("Email Tidak Terdaftar")';  
        echo '</script>';
        echo "<meta http-equiv='refresh' content='0;url=lupa_password.php'>";  
    }

    $conn->close();
} else {
    header("Location: lupa_password.php"); // Redirect jika akses langsung
}
?>
