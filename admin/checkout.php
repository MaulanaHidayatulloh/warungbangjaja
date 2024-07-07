<?php
date_default_timezone_set('Asia/Jakarta'); // Mengatur zona waktu ke Asia/Jakarta

$host = "localhost";
$user = "root";
$password = ""; // Biarkan kosong jika tidak ada password
$database = "produk";

$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data produk dari database berdasarkan ID yang dipilih
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Baca data yang dikirimkan dari frontend
    $data = json_decode(file_get_contents("php://input"));

    // Inisialisasi total harga
    $total_price = 0;

    // Inisialisasi struk belanjaan
    $receipt = "
        <div style='text-align: center; font-size: 16px;'>
            <h2>Struk Belanja</h2>
            <p>Tanggal: " . date("d/m/Y H:i:s") . "</p>
            <hr>
        </div>
        <div style='display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; font-size: 22px; margin-top: 20px;'>
            <div><strong>Nama Produk</strong></div>
            <div><strong>Harga</strong></div>
            <div><strong>Jumlah</strong></div>
            <div><strong>Subtotal</strong></div>
            <hr style='grid-column: span 4;'>
    ";

    // Loop through each selected product
    foreach ($data as $product) {
        // Hindari SQL Injection dengan menggunakan prepared statement
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product->id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika produk ditemukan, kurangi stok dan tambahkan detail produk ke struk belanjaan
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $qty = min($product->qty, $row['stock']); 
            $price = $row['price'] * $qty; 
            $total_price += $price; // Add to total price
            $receipt .= "
                <div>" . $row['name'] . "</div>
                <div>Rp " . number_format($row['price'], 0, ',', '.') . "</div>
                <div>" . $qty . "</div>
                <div>Rp " . number_format($price, 0, ',', '.') . "</div>
                <hr style='grid-column: span 4;'>
            ";
            
            // Update stock in database
            $newStock = $row['stock'] - $qty;
            $updateSql = "UPDATE products SET stock = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ii", $newStock, $row['id']);
            $updateStmt->execute();
        }
    }

    // Tambahkan total harga ke struk belanjaan
    $receipt .= "
        </div>
        <hr>
        <div style='text-align: center; margin-top: 10px; font-size: 22px;'>
            <p>Total Harga: Rp " . number_format($total_price, 0, ',', '.') . "</p>
        </div>
    ";

    // Kembalikan struk belanjaan sebagai respons
    echo $receipt;
}

$conn->close();
?>
