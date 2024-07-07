<?php
$host = "localhost";
$user = "root";
$password = ""; // Biarkan kosong jika tidak ada password
$database = "produk";

$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query untuk menghapus data produk
    $sql = "DELETE FROM products WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Data produk berhasil dihapus.";
        echo "<meta http-equiv='refresh' content='2;url=view_database.php'>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
