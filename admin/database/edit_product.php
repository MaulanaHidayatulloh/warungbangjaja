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
        $purchase_price = $row['purchase_price']; 
        $nodiscount = $row['nodiscount']; 
        $special = $row['special']; 
        $image = $row['image'];
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $additional_stock = $_POST['stock'];
    $price = $_POST['price'];
    $purchase_price = $_POST['purchase_price']; 
    $nodiscount = $_POST['nodiscount']; 
    $special = $_POST['special']; 
    $image = $_POST['image'];

    // Query untuk mendapatkan stok saat ini
    $sql = "SELECT stock FROM products WHERE id = '$id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $current_stock = $row['stock'];
        $new_stock = $current_stock + $additional_stock; 

        // Query untuk mengupdate data produk termasuk harga beli, nodiscount, dan special
        $sql = "UPDATE products SET name='$name', stock='$new_stock', price='$price', purchase_price='$purchase_price', nodiscount='$nodiscount', special='$special', image='$image' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "<h1><span>Data produk berhasil diperbarui</span></h1>";
            echo "<meta http-equiv='refresh' content='3;url=view_database.php'>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Produk tidak ditemukan.";
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
        <label for="name">Nama Produk :</label><br>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>
        <label for="stock">Tambahkan Stok :</label><br>
        <input type="number" id="stock" name="stock" min="0" value="0" required><br>
        <label for="price">Harga :</label><br>
        <input type="number" id="price" name="price" value="<?php echo $price; ?>" required><br>
        <label for="purchase_price">Harga Beli :</label><br>
        <input type="number" id="purchase_price" name="purchase_price" value="<?php echo $purchase_price; ?>" required><br>
        <label for="nodiscount">Harga Tanpa Diskon :</label><br>
        <input type="number" id="nodiscount" name="nodiscount" value="<?php echo $nodiscount; ?>" required><br>
        <label for="special">Spesial (0/1) :</label><br>
        <input type="number" id="special" name="special" min="0" max="1" value="<?php echo $special; ?>" required><br>
        <label for="image">Gambar :</label><br>
        <input type="text" id="image" name="image" value="<?php echo $image; ?>" required><br><br>
        <button type="submit">Update Produk</button>
    </form>
</div>
</body>
</html>
