<?php
session_start();

// Koneksi ke database
$host = "localhost";
$user = "root";
$password = ""; // Biarkan kosong jika tidak ada password
$database = "produk";

$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah user sudah login
if (!isset($_SESSION['login'])) {
    echo json_encode(['success' => false, 'message' => 'User belum login']);
    exit();
}

// Ambil data item dari request
$data = json_decode(file_get_contents('php://input'), true);
$items = $data['items'];

foreach ($items as $item) {
    $product_id = $item['id'];
    $quantity = $item['quantity'];

    // Tambahkan entri baru dengan INSERT IGNORE
    $sql_insert = "INSERT IGNORE INTO orders (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iii", $_SESSION['user_id'], $product_id, $quantity);
    
    if (!$stmt_insert->execute()) {
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan order: ' . $stmt_insert->error]);
        exit();
    }
}

echo json_encode(['success' => true]);

$conn->close();
?>
