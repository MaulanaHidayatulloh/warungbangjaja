<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION["login"]) || $_SESSION["role"] != 'user') {
    header("Location: Form-Login/");
    exit();
}

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

// Query untuk mengambil data order user, diurutkan berdasarkan order_date
$sql = "SELECT orders.*, products.name, products.price, users.full_name 
        FROM orders 
        INNER JOIN products ON orders.product_id = products.id 
        INNER JOIN users ON orders.user_id = users.id 
        WHERE user_id = ? 
        ORDER BY orders.order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Order</title>
    <link rel="stylesheet" href="daftar_order.css">
</head>
<body>
<!-- Daftar Order User Start -->
<div class="daftar-order-user">
    <h2>Daftar Pesanan Anda</h2>

    <?php
    if ($result->num_rows > 0) {
        $current_order_date = null;
        $total_harga = 0;

        while ($order = $result->fetch_assoc()) {
            // Jika ada perubahan order_date, tampilkan total harga untuk order_date sebelumnya
            if ($current_order_date !== $order['order_date']) {
                if ($current_order_date !== null) {
                    echo '</tbody>';
                    echo '<tfoot>';
                    echo '<tr>';
                    echo '<td colspan="4" class="text-right">Total Harga</td>';
                    echo '<td>Rp ' . $total_harga . '</td>';
                    echo '</tr>';
                    echo '</tfoot>';
                    echo '</table>';
                    echo '</div>';
                }

                // Reset total harga dan buka tabel baru untuk order_date baru
                $current_order_date = $order['order_date'];
                $total_harga = 0;

                echo '<div class="order-section">';
                echo '<h3>Tanggal Order: ' . date('Y-m-d', strtotime($current_order_date)) . '</h3>';
                echo '<h4>Waktu Order: ' . date('H:i:s', strtotime($current_order_date)) . '</h4>';
                echo '<table class="order-list">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Nama Produk</th>';
                echo '<th>Jumlah</th>';
                echo '<th>Harga</th>';
                echo '<th>Total Harga</th>';
                echo '<th>Tanggal Order</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
            }

            // Tampilkan detail barang yang dibeli
            echo '<tr>';
            echo '<td>' . $order['name'] . '</td>';
            echo '<td>' . $order['quantity'] . '</td>';
            echo '<td>Rp ' . $order['price'] . '</td>';
            echo '<td>Rp ' . ($order['quantity'] * $order['price']) . '</td>';
            echo '<td>' . date('Y-m-d H:i:s', strtotime($order['order_date'])) . '</td>';
            echo '</tr>';

            // Akumulasi total harga
            $total_harga += $order['quantity'] * $order['price'];
        }

        // Tampilkan total harga untuk order_date terakhir
        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr>';
        echo '<td colspan="4" class="text-right">Total Harga</td>';
        echo '<td>Rp ' . $total_harga . '</td>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';
        echo '</div>';

    } else {
        echo '<p>Tidak ada order yang ditemukan.</p>';
    }
    ?>

</div>
<!-- Daftar Order User End -->

<?php
$conn->close();
?>

</body>
</html>
