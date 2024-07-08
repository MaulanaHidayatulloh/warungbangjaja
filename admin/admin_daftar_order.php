<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["role"] != 'admin') {
    header("location: ../form-login/"); 
    exit();
}

// Koneksi ke database
$host = "localhost";
$user = "root";
$password = ""; 
$database = "produk";

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Update status order jika ada request
if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $sql_update = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
    $stmt->close();
}

// Query untuk mengambil data order dari semua pengguna
$sql = "SELECT orders.*, users.full_name, products.name, products.price, products.id AS product_id
        FROM orders 
        INNER JOIN users ON orders.user_id = users.id 
        INNER JOIN products ON orders.product_id = products.id";

$result = $conn->query($sql);

// Mengelompokkan data berdasarkan order_date (tanpa waktu) dan full_name
$orders = [];
if ($result->num_rows > 0) {
    while ($order = $result->fetch_assoc()) {
        $order_date = date('Y-m-d', strtotime($order['order_date'])); // Mengambil tanggal saja
        $order_time = date('H:i:s', strtotime($order['order_date'])); // Mengambil waktu saja
        $full_name = $order['full_name'];
        $orders[$order_date][$full_name][$order_time][] = $order;
    }
}

// Mengurutkan array berdasarkan tanggal dalam urutan menurun (descending)
krsort($orders);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan User (Admin)</title>
    <link rel="stylesheet" href="admin_daftar_order.css">
</head>
<body>
<!-- Daftar Order Admin Start -->
<div class="daftar-order-admin">
    <h2>Daftar Pesanan User</h2>
    
    <?php
    if (!empty($orders)) {
        // Looping berdasarkan tanggal order
        foreach ($orders as $order_date => $users) {
            echo '<h3>Tanggal Order : ' . $order_date . '</h3>';
            
            // Looping berdasarkan nama pengguna
            foreach ($users as $full_name => $orders_by_time) {
                echo '<h4>Nama: ' . $full_name . '</h4>';
                
                // Looping berdasarkan waktu order (terbaru ke terlama)
                krsort($orders_by_time);
                foreach ($orders_by_time as $order_time => $orders) {
                    echo '<h5>Waktu Order : ' . $order_time . '</h5>';
                    echo '<table>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>ID Produk</th>'; // Menambah kolom ID Produk
                    echo '<th>Nama Produk</th>';
                    echo '<th>Jumlah</th>';
                    echo '<th>Harga</th>';
                    echo '<th>Status</th>';
                    echo '<th>Aksi</th>';
                    '</tr>';
                    '</thead>';
                    echo '<tbody>';

                    // Variable to store total price for current table
                    $total_price = 0;

                    // Looping berdasarkan detail order
                    foreach ($orders as $order) {
                        echo '<tr>';
                        echo '<td data-label="ID Produk">' . $order['product_id'] . '</td>'; // Menampilkan ID Produk
                        echo '<td data-label="Nama Produk">' . $order['name'] . '</td>';
                        echo '<td data-label="Jumlah">' . $order['quantity'] . '</td>';
                        echo '<td data-label="Harga">Rp ' . $order['price'] . '</td>';
                        echo '<td data-label="Status">' . $order['status'] . '</td>';
                        echo '<td data-label="Aksi">';
                        echo '<form method="post" action="">';
                        echo '<input type="hidden" name="order_id" value="' . $order['id'] . '">';
                        echo '<input type="hidden" name="product_id" value="' . $order['product_id'] . '">'; // Menambahkan product_id
                        echo '<select name="status" onchange="this.form.submit()">';
                        echo '<option value="belum" ' . ($order['status'] == 'belum' ? 'selected' : '') . '>Belum</option>';
                        echo '<option value="sudah" ' . ($order['status'] == 'sudah' ? 'selected' : '') . '>Sudah</option>';
                        echo '</select>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';

                        // Menambahkan harga produk (jumlah * harga) ke total harga
                        $total_price += $order['quantity'] * $order['price'];
                    }

                    // Menambahkan biaya ongkir (misalnya Rp 10,000)
                    $ongkir = 10000;
                    $total_price += $ongkir;

                    // Menampilkan total harga di bawah tabel
                    echo '<tr>';
                    echo '<td colspan="3" style="text-align: right;"><strong>Total Harga (Udah sama Ongkir) :</strong></td>';
                    echo '<td><strong>Rp ' . $total_price . '</strong></td>';
                    echo '<td colspan="2"></td>';
                    echo '</tr>';

                    echo '</tbody>';
                    echo '</table>';
                }
            }
        }
    } else {
        echo '<p>Tidak ada order yang ditemukan.</p>';
    }
    ?>
</div>

<?php
// Menutup koneksi
$conn->close();
?>
</body>
</html>
