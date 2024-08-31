<?php
session_start();

// Periksa apakah pengguna sudah login dan apakah pengguna adalah admin
if (!isset($_SESSION["login"]) || $_SESSION["role"] != 'admin') {
    header("location: ../form-login/"); 
    exit();
}

// Logout admin
if (isset($_GET['logout'])) {
    // Hapus semua data session
    session_unset();
    // Hancurkan session
    session_destroy();
    // Redirect ke halaman login
    header("location: ../form-login/");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 260px;
      height: 100vh;
      background-color: #343a40;
      color: #fff;
      padding-top: 20px;
      transition: transform 0.3s ease-in-out;
      transform: translateX(-260px); 
    }

    .sidebar.show {
      transform: translateX(0); 
    }

    .sidebar ul.nav flex-column {
      padding-left: 0;
    }

    .sidebar ul.nav flex-column .nav-link {
      color: #ccc;
      padding: 10px 20px;
      transition: all 0.3s ease;
    }

    .sidebar ul.nav flex-column .nav-link:hover {
      background-color: #495057;
      color: #fff;
    }

    .sidebar h1 {
        text-align: center;
        font-weight: bold;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    .main-content {
      margin-left: 260px; 
      padding: 20px;
      transition: margin-left 0.3s;
    }

    .toggle-btn {
      position: absolute;
      left: 10px;
      top: 10px;
      cursor: pointer;
      display: block;
      z-index: 999; 
    }

    @media (min-width: 992px) {
      .sidebar {
        transform: translateX(0); 
      }
      .toggle-btn {
        display: none; 
      }
    }
  </style>
</head>
<body>
  <!-- Hamburger Menu -->
  <div class="toggle-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars fa-2x"></i>
  </div>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <ul class="nav flex-column">
      <h1>Warung BangJaja</h1>
      <li class="nav-item">
        <a class="nav-link active" href="#"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cashier.php"><i class="fas fa-cash-register me-2"></i> Cashier Program</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_daftar_order.php"><i class="fas fa-list-alt me-2"></i> User Orders</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="database/view_database.php"><i class="fas fa-database me-2"></i> Product Database</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="add_data/add_product_form.php"><i class="fas fa-plus-circle me-2"></i> Add Product</a>
      </li>
      <li class="nav-item mt-auto">
        <a class="nav-link text-danger" href="?logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
      </li>
    </ul>
  </div>
<!-- Main content -->
<div class="main-content" id="main-content">
  <div class="container-fluid">
    <h1 class="mt-4"><strong>Admin Dashboard</strong></h1>
    <div class="row mt-4">
      <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100">
          <div class="card-body">
            <h5 class="card-title"><strong>Cashier Program</strong></h5>
            <p class="card-text">Untuk menglola transaksi order user dengan mudah menggunakan fitur ini.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card bg-info text-white h-100">
          <div class="card-body">
            <h5 class="card-title">User Orders</h5>
            <p class="card-text">Untuk melihat dan kelola pesanan dari pengguna di sini.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100">
          <div class="card-body">
            <h5 class="card-title">Product Database</h5>
            <p class="card-text">Untuk mengelola informasi produk dengan database yang lengkap.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card bg-warning text-dark h-100">
          <div class="card-body">
            <h5 class="card-title">Add Product</h5>
            <p class="card-text">Untuk menambahkan produk baru ke dalam database dengan mudah di sini.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



  <!-- Bootstrap JS and Font Awesome JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('main-content');

      sidebar.classList.toggle('show'); 
      if (sidebar.classList.contains('show')) {
        mainContent.style.marginLeft = '260px'; 
      } else {
        mainContent.style.marginLeft = '0'; 
      }
    }
  </script>
</body>
</html>


