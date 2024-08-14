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
$midtrans_order_id = uniqid(); // Menghasilkan order_id yang unik menggunakan uniqid()

// Menambahkan entri baru dengan INSERT
$sql_insert = "INSERT INTO orders (user_id, product_id, quantity, order_date, payment_status, midtrans_order_id) VALUES (?, ?, ?, NOW(), 'pending', ?)";
$stmt_insert = $conn->prepare($sql_insert);

if ($stmt_insert === false) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit();
}

foreach ($items as $item) {
    $product_id = $item['id'];
    $quantity = $item['quantity'];
    
    // Bind parameter dan execute query
    $stmt_insert->bind_param("iiis", $_SESSION['user_id'], $product_id, $quantity, $midtrans_order_id);
    
    if (!$stmt_insert->execute()) {
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan order: ' . $stmt_insert->error]);
        exit();
    }
}

// Tutup statement dan koneksi
$stmt_insert->close();
$conn->close();

// Kirim respons JSON dengan midtrans_order_id yang baru dibuat
echo json_encode(['success' => true, 'midtrans_order_id' => $midtrans_order_id]);
?>
