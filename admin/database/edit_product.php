<?php
$host = "localhost";
$user = "root";
$password = ""; // Biarkan kosong jika tidak ada password
$database = "produk";

$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query untuk mendapatkan data produk berdasarkan ID
    $sql = "SELECT * FROM products WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $stock = $row['stock'];
        $price = $row['price'];
        $image = $row['image'];
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    // Query untuk mengupdate data produk
    $sql = "UPDATE products SET name='$name', stock='$stock', price='$price', image='$image' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        // Setelah pembaruan data berhasil, kembalikan data produk untuk ditampilkan kembali di formulir
        $sql = "SELECT * FROM products WHERE id = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $stock = $row['stock'];
            $price = $row['price'];
            $image = $row['image'];
        }
        
        echo "<h1><span>Data produk berhasil diperbarui</span></h1>";
        echo "<meta http-equiv='refresh' content='3;url=view_database.php'>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../styles.css" />
</head>
<body>
    <h1>Edit Produk</h1>
    <div class="container">
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="name">Nama Produk:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>
        <label for="stock">Stok:</label><br>
        <input type="number" id="stock" name="stock" value="<?php echo $stock; ?>" required><br>
        <label for="price">Harga:</label><br>
        <input type="number" id="price" name="price" value="<?php echo $price; ?>" required><br>
        <label for="image">Gambar:</label><br>
        <input type="text" id="image" name="image" value="<?php echo $image; ?>" required><br><br>
        <button type="submit">Update Produk</button>
    </form>
</div>
</body>
</html>
