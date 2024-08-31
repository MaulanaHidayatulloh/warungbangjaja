<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["role"] != 'admin') {
    header("location: ../../form-login/");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Produk</title>
    <link rel="stylesheet" href="../styles.css" />
</head>
<body>
    <h1>Database Produk</h1>
    <div class="container">
    <form method="GET">
        <label for="search">Pencarian Produk :</label>
        <input type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Cari Produk</button>
    </form>
    <br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Stok</th>
                <th>Harga (Jual/Diskon)</th>
                <th>Harga Beli</th>
                <th>Harga Tanpa Diskon</th>
                <th>Gambar</th>
                <th>Spesial</th>
                <th>Edit/Delete</th>
            </tr>
        </thead>
        <tbody>
    </div>
            <?php
            $host = "localhost";
            $user = "root";
            $password = ""; 
            $database = "produk";

            $conn = new mysqli($host, $user, $password, $database);

            // Periksa koneksi
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Membuat kata kunci pencarian yang aman dari serangan SQL Injection
            $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

            // Kueri SQL untuk mencari data produk berdasarkan nama produk
            $sql = "SELECT * FROM products";
            if (!empty($search)) {
                $sql .= " WHERE name LIKE '%$search%'";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Tampilkan data dalam bentuk tabel
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["stock"] . "</td>";
                    echo "<td>Rp " . $row["price"] . "</td>";
                    echo "<td>Rp " . $row["purchase_price"] . "</td>";
                    echo "<td>Rp " . $row["nodiscount"] . "</td>";
                    echo "<td>" . $row["image"] . "</td>";
                    echo "<td>" . $row["special"] . "</td>";
                    echo "<td>";
                    echo "<a href='edit_product.php?id=" . $row["id"] . "'>Edit</a> | ";
                    echo "<a href='delete_product.php?id=" . $row["id"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus produk ini?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Tidak ada data produk.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
