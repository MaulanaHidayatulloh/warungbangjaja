<?php
require_once dirname(__FILE__) . '/pembayaran/midtrans-php-master/Midtrans.php';

\Midtrans\Config::$serverKey = 'SB-Mid-server-FuGqU-ninxDQuUhb_oFW9qpe';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$log_file = 'callback_log.txt';

// Read raw POST data
$raw_post_data = file_get_contents('php://input');
file_put_contents($log_file, "Raw POST Data:\n" . $raw_post_data . "\n", FILE_APPEND);

// Decode JSON data
$post_data = json_decode($raw_post_data, true);

// Log decoded data
file_put_contents($log_file, "Decoded Data:\n" . print_r($post_data, true) . "\n", FILE_APPEND);

// Extract transaction status and order_id
$transaction_status = $post_data['transaction_status'] ?? 'unknown';
$midtrans_order_id = $post_data['order_id'] ?? 'unknown';

file_put_contents($log_file, "Transaction Status: " . $transaction_status . "\nOrder ID: " . $midtrans_order_id . "\n", FILE_APPEND);

$host = "localhost";
$user = "root";
$password = "";
$database = "produk";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$payment_status = 'pending';

if ($transaction_status == 'settlement') {
    $payment_status = 'success';
} else if ($transaction_status == 'pending') {
    $payment_status = 'pending';
} else if ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel') {
    $payment_status = 'failure';
}

file_put_contents($log_file, "Payment Status: " . $payment_status . "\n", FILE_APPEND);

$sql = "UPDATE orders SET payment_status = ? WHERE midtrans_order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $payment_status, $midtrans_order_id);
$stmt->execute();

$stmt->close();
$conn->close();

echo "Payment status updated to: " . $payment_status;
?>
