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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Penambahan produk</title>
    <link rel="stylesheet" href="../styles.css" />
  </head>
  <body>
    <h1>Penambahan Produk</h1>
    <div class="container">
      <form id="addProductForm" onsubmit="submitForm(event)">
        <label for="id">ID Produk:</label><br />
        <input type="number" id="id" name="id" required /><br />
        <label for="name">Nama Produk:</label><br />
        <input type="text" id="name" name="name" required /><br />
        <label for="stock">Stok:</label><br />
        <input type="number" id="stock" name="stock" required /><br />
        <label for="price">Harga:</label><br />
        <input
          type="number"
          id="price"
          name="price"
          step="0.01"
          required
        /><br />
        <button type="submit">Add Product</button>
      </form>
    </div>

    <script src="add_product.js"></script>
  </body>
</html>
