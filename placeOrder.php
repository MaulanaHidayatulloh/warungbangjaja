<?php
session_start();

require_once dirname(__FILE__) . '/pembayaran/midtrans-php-master/Midtrans.php';

// Fungsi untuk mengambil total harga dari POST request
function getTotalHarga() {
    $data = json_decode(file_get_contents('php://input'), true);
    return isset($data['total_harga']) ? $data['total_harga'] : 0;
}

$total_harga = getTotalHarga();

// Fungsi untuk mengambil data pelanggan dari database berdasarkan user ID
function getCustomerDataFromDatabase($user_id) {
    // Koneksi ke database
    $host = "localhost";
    $user = "root";
    $password = ""; // Biarkan kosong jika tidak ada password
    $database = "produk";

    $conn = new mysqli($host, $user, $password, $database);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query untuk mengambil informasi pelanggan
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Ambil data pelanggan dari hasil query
    $customer_data = $result->fetch_assoc();

    // Tutup koneksi
    $stmt->close();
    $conn->close();

    return $customer_data;
}

// Ambil data pelanggan dari database berdasarkan user ID
$customer_data = getCustomerDataFromDatabase($_SESSION['user_id']);

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-FuGqU-ninxDQuUhb_oFW9qpe';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

// Data pelanggan dari database
$customer_details = array(
    'first_name' => $customer_data['full_name'], // Menggunakan full_name dari tabel users
    'email' => $customer_data['email'], // Jika ada kolom email dalam tabel users
    'phone' => $customer_data['phone_number'], // Jika ada kolom phone dalam tabel users
);

// Menggunakan total harga dari JavaScript
$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => $total_harga, // Menggunakan total harga dari JavaScript
    ),
    'customer_details' => $customer_details,
);

try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    echo json_encode(['success' => true, 'snapToken' => $snapToken]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
