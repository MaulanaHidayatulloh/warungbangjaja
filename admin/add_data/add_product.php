<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = ""; // Biarkan kosong jika tidak ada password
$database = "produk";

$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menambahkan data produk ke dalam database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];

    // Periksa apakah ID sudah ada dalam database
    $check_query = "SELECT id FROM products WHERE id = $id";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        // Jika ID sudah ada dalam database, kirim respons bahwa ID sudah ada
        echo "ID sudah ada";
    } else {
        // Jika ID belum ada dalam database, tambahkan data produk
        $sql = "INSERT INTO products (id, name, stock, price) VALUES ($id, '$name', $stock, $price)";

        if ($conn->query($sql) === TRUE) {
            echo "Produk berhasil ditambahkan";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
