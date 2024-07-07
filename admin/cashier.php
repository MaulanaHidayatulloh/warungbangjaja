<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["role"] != 'admin') {
    header("location: ../form-login/"); 
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kasir</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <h1>Program Kasir</h1>
    <div class="container">
      <form id="kasirForm">
        <label for="product_id">ID Produk:</label><br />
        <input
          type="text"
          id="product_id"
          name="product_id"
          required
        /><br /><br />

        <label for="product_qty">Jumlah:</label><br />
        <input
          type="number"
          id="product_qty"
          name="product_qty"
          required
        /><br /><br />

        <button type="button" onclick="addProduct()">Tambahkan Produk</button>
      </form>
      <div id="selectedProducts"></div>
      <button onclick="checkout()">Checkout</button>
      <div id="receipt" style="display: none"></div>
    </div>

    <script src="script.js"></script>
  </body>
</html>
