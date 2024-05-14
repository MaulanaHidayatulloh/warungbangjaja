<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['login'])) {
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

// Query untuk mengambil data order user
$sql = "SELECT orders.*, products.name, products.price, users.full_name 
        FROM orders 
        INNER JOIN products ON orders.product_id = products.id 
        INNER JOIN users ON orders.user_id = users.id 
        WHERE user_id = ? 
        ORDER BY user_id, orders.id";
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
    <link rel="stylesheet" href="order.css">
</head>
<body>
<!-- Daftar Order User Start -->
<div class="daftar-order-user">
    <h2>Daftar Order</h2>

    <?php
    if ($result->num_rows > 0) {
        $current_user_id = null;
        $current_order_id = null;
        $total_harga = 0;

        while ($order = $result->fetch_assoc()) {
            // Jika ada perubahan user_id, tampilkan total harga untuk user sebelumnya
            if ($current_user_id !== $order['user_id']) {
                if ($current_user_id !== null) {
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

                // Reset total harga dan buka tabel baru untuk user baru
                $current_user_id = $order['user_id'];
                $current_order_id = null;
                $total_harga = 0;

                echo '<div class="user-section">';
                echo '<h3>User ID: ' . $current_user_id . ' - ' . $order['full_name'] . '</h3>';
            }

            // Jika ada perubahan order_id, buka tabel baru
            if ($current_order_id !== $order['id']) {
                if ($current_order_id !== null) {
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

                // Reset total harga dan buka tabel baru untuk order baru
                $current_order_id = $order['id'];
                $total_harga = 0;

                echo '<div class="order-section">';
                echo '<h4>Order ID: ' . $current_order_id . '</h4>';
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
            echo '<td>' . $order['order_date'] . '</td>';
            echo '</tr>';

            // Akumulasi total harga
            $total_harga += $order['quantity'] * $order['price'];
        }

        // Tampilkan total harga untuk order terakhir dan user terakhir
        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr>';
        echo '<td colspan="4" class="text-right">Total Harga</td>';
        echo '<td>Rp ' . $total_harga . '</td>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';
        echo '</div>';
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

