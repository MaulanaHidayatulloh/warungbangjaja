<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["role"] != 'user') {
  header("location: form-login/");
  exit;
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

// Query untuk mengambil data produk dari database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Warung Bang JaJa</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Father Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Bootstrap Icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />

    <!-- Icon Logo Jaja -->
    <link rel="icon" href="img/jaja-logo.png" />

    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- My Style -->
    <link rel="stylesheet" href="style.css" />

    <!-- Midtrans -->
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="SB-Mid-client-5owSJyfdgSAZ7_Ar"></script>
  </head>

  <body>
    <!-- Navbar Start -->
    <nav class="navbar">
      <a href="#" class="navbar-logo"
        >Warung<span>BangJaJa </span><span><i class="bi bi-shop"></i></span>
      </a>

      <div class="navbar-nav">
        <h1 id="openclose"><span id="status"></span></h1>
        <a href="#home">Home</a>
        <a href="#about">Tentang Kami</a>
        <a href="#menu">Menu</a>
        <a href="#product">Penawaran Spesial</a>
        <a href="#contact">Kontak Kami</a>
      </div>

      <div class="navbar-extra">
        <a href="#" id="search-button"><i data-feather="search"></i></a>
        <a href="#" id="shopping-cart-button"><i data-feather="shopping-cart"></i><span class="keranjang-belanja">Keranjang</span></a>
        <a href="http://localhost/warung-bangjaja/form-login/logout.php"
        id="logout"><i data-feather="log-out"></i><span class="logout-text">Logout</span></a>
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>

       <!-- Search Form Start -->
       <div class="search-form">
        <input type="search" id="search-box" placeholder="Mau Cari Apa ?" />
        <label for="search-box"><i data-feather="search"></i></label>
      </div>
      <!-- Search Form End -->

      <!-- Shopping Cart Start -->
      <div class="shopping-cart">
    <div class="title-shopping-cart">
        <h2>Pesanan Anda</h2>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userId = $_SESSION['user_id']; // Anda bisa mendapatkan user_id dari session setelah login
        $items = json_decode($_POST['items'], true);

        // Query untuk menyimpan order ke database
        $sql = "INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            foreach ($items as $item) {
                $productId = $item['id'];
                $quantity = $item['quantity'];
                $totalPrice = $item['quantity'] * $item['price'];
                $stmt->bind_param("iiii", $userId, $productId, $quantity, $totalPrice);
                $stmt->execute();
            }
            $stmt->close();
        }

        $conn->close();

        // Redirect ke halaman daftar order
        // header("Location: daftar_order.php");
        // exit();
    }
    ?>

    <form action="" method="post">
        <div class="container">
            <?php
            // Periksa apakah ada data produk yang ditemukan
            if ($result->num_rows > 0) {
                // Loop untuk setiap baris data produk
                while ($row = $result->fetch_assoc()) {
                    // Menampilkan data produk dalam elemen HTML
                    echo '<div class="cart-item-1" id="cart-item-' . $row["id"] . '">';
                    echo '<img src="' . $row["image"] . '" alt="' . $row["name"] . '"/>';
                    echo '<div class="item-detail">';
                    echo '<h3>' . $row["name"] . '</h3>';
                    echo '<div class="item-price" id="harga_' . $row["id"] . '" value="' . $row["price"] . '">Rp ' . $row["price"] . '</div>';
                    echo '<div class="stok" id="stock_' . $row["id"] . '" value="' . $row["stock"] .'">Stok Barang : ' .$row["stock"] . '</div>';
                    echo '<div>Jumlah Pembelian : ';
                    echo '<input type="number" id="jumlah_' . $row["id"] . '" value="0" min="0" max="' .$row["stock"] . '" class="jumlah" onchange="updateTotal()" />';
                    echo '</div>';
                    echo '</div>';
                    echo '<a href="#" id="remove-item-' . $row["id"] . '" class="remove-item"><i class="bi bi-trash"></i></a>';
                    echo '</div>';
                }
            } else {
                echo "Tidak ada produk yang ditemukan.";
            }
            $conn->close();
            ?>
        </div>

        <div class="total-harga">
            <h2 style="display : flex">Total Harga<p style="font-size : 0.9rem; padding-top : 1rem; padding-right : 0.5rem">+ 10.000</p> : <span>Rp</span></h2>
            <input type="text" class="totalharga" id="total_harga" value="0" readonly />
        </div>

        <div style="display:flex; justify-content: center;">
            <button class="checkout_button" id="checkout_button" type="submit" style="font-size: 1rem; background-color: #4CAF50; padding: 1rem 12rem; cursor:pointer; bottom: -4rem; position: relative; border-radius: 1rem; font-weight:700"><span>Bayar Sekarang</span></button>
        </div>
    </form>
</div>



      
      <!-- Shopping Cart End -->
    </nav>
    <!-- Navbar End -->

    <!-- Hero Section start -->
    <section class="hero" id="home">
      <main class="content">
        <h1>Mari Belanja di <span>WarungBangJaJa</span></h1>
        <p>WarungBangJaJa lengkap menjual segala kebutuhan pokok</p>
        <a href="daftar_order.php" class="cta">Lihat Pesanan Anda Disini!</a>
      </main>
    </section>
    <!-- Hero Section end -->

    <!-- About Section Start -->
    <section
      id="about"
      class="about"
      data-aos="fade-down"
      data-aos-duration="1000"
    >
      <h2><span>Tentang</span> Kami</h2>

      <div class="row">
        <div class="about-img">
          <img src="img/tentang-kami.jpg" alt="Tentang Kami" />
        </div>
        <div class="content">
          <h3>Kenapa Anda Harus Memilih Toko Kami?</h3>
          <p>
            Toko kami, solusi lengkap untuk kebutuhan anda. Segala kebutuhan
            anda ada di toko kami. Toko kami merupakan tempat terpercaya untuk
            memenuhi kebutuhan sehari-hari anda.
          </p>
          <p>
            Barang-barang yang dijual di toko kami berkualitas tinggi dengan
            harga terjangkau. Toko kami hadir untuk memenuhi kebutuhan Anda
            dengan pilihan yang lengkap. Temukan kebutuhan anda terbaik dan
            terlengkap hanya di toko kami.
          </p>
        </div>
      </div>
    </section>
    <!-- About Section end -->

    <!-- Menu Section Start -->
    <section
      id="menu"
      class="menu"
      data-aos="fade-down"
      data-aos-duration="1000"
    >
      <h2><span>Menu</span> Kami</h2>
      <p>Berikut produk Yang Toko Kami Jual :</p>
      <p>(Silakan Anda Melihat terlebih Dahulu Dan Dipilih Terlebih Dahulu)</p>

      <?php
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

      // Query untuk mengambil data produk dari database
      $sql = "SELECT * FROM products WHERE special = 0";
      $result = $conn->query($sql);     
      ?>

      <div class="row">
        <?php
            // Periksa apakah ada data produk yang ditemukan
            if ($result->num_rows > 0) {
                // Loop untuk setiap baris data produk
                while ($row = $result->fetch_assoc()) {
                    // Menampilkan data produk dalam elemen HTML
                    echo '<div class="menu-card">';
                    echo '<img src="' . $row["image"] . '" alt="' . $row["name"] . '" class="menu-card-img" />';
                    echo '<h3 class="menu-card-title">' . $row["name"] . '</h3>';
                    echo '<h5 class="menu-card-price">Harga : Rp ' . number_format($row["price"], 0, ",", ".") . '</h5>';
                    echo '<a href="#" id="card-belanja-' . $row["id"] . '" class="menu-card-belanja">Belanja</a>';
                    echo '<div class="informasi" id="informasi-' . $row["id"] . '">';
                    echo '<i class="bi bi-info-circle"></i>';
                    echo '<span><strong>Item Ini!</strong> Sudah Masuk Ke keranjang</span>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "Tidak ada produk yang ditemukan.";
            }
            $conn->close();
            ?>

      </div>
    </section>
    <!-- Menu Section end -->

    <!-- Penawaran Section Start -->
    <section
      class="product"
      id="product"
      data-aos="fade-down"
      data-aos-duration="1000"
    >
      <h2><span>Penawaran</span> Spesial</h2>
      <p>Berikut Penawaran Spesial Untuk Anda Di Toko Kami :</p>
      <p>(Silakan Anda Melihat terlebih Dahulu Dan Dipilih Terlebih Dahulu)</p>
      
      <?php
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

      // Query untuk mengambil data produk dari database
      $sql = "SELECT * FROM products WHERE special = 1";
      $result = $conn->query($sql);     
      ?>

      <div class="row">
      <?php
        // Periksa apakah ada data produk yang ditemukan
        if ($result->num_rows > 0) {
          // Loop untuk setiap baris data produk
          while ($row = $result->fetch_assoc()) {
            // Menampilkan data produk dalam elemen HTML
            // echo '<div class="row">';
            echo '<div class="product-card">';
            echo '<div class="product-icons">';
            echo '<a href="#" class="cancel" id="cancel-' . $row["id"] . '"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/></svg></a>';
            echo '<a href="#" id="keranjang-belanja-' . $row["id"] . '"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/></svg></a>';
            echo '<a href="#" class="item-detail-button-' . $row["id"] . '"><i data-feather="eye"></i></a>';
            echo '</div>';
            echo '<div class="product-image">';
            echo '<img src="' . $row["image"] . '" alt="' . $row["name"] . '"/>';
            echo '</div>';
            echo '<div class="product-content">';
            echo '<h3>' . $row["name"] . '</h3>';
            echo '<div class="product-star">';
            echo '<i class="bi bi-star-fill"></i>';
            echo '<i class="bi bi-star-fill"></i>';
            echo '<i class="bi bi-star-fill"></i>';
            echo '<i class="bi bi-star-fill"></i>';
            echo '<i class="bi bi-star-fill"></i>';
            echo '</div>';
            echo '<div class="product-price">Harga : Rp  ' . number_format($row["price"], 0, ",", ".") . ' <span>Rp ' . number_format($row["nodiscount"], 0, ",", ".") . '</span></div>';
            echo '</div>';
            echo '</div>';
          }
        } else {
            echo "Tidak ada produk yang ditemukan.";
        }
        $conn->close();
      ?>

      </div>
    </section>
    <!-- Penawaran Section End -->

    <!-- Contact Section Start -->
    <section
      id="contact"
      class="contact"
      data-aos="fade-down"
      data-aos-duration="1000"
    >
      <h2><span>Kontak</span> Kami</h2>
      <p>
        Tinggalkan pesan atau hubungi kami untuk mendapatkan informasi lebih
        lanjut tentang produk dan layanan kami
      </p>
      <p>
        (Kami telah menambahkan alamat toko kami, jika anda ingin membeli produk
        secara langsung)
      </p>

      <div class="row">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d312.3957489756764!2d106.70462109177844!3d-6.159430578786205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f815dcec4e59%3A0xcf6752eb8443babf!2sToko.%20Jaja!5e0!3m2!1sid!2sid!4v1685219699170!5m2!1sid!2sid"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          class="map"
        ></iframe>

        <form action="" name="warungbangjaja-contact-form">
          <div class="alert">
            <i class="bi bi-info-circle"></i
            ><span>
              <strong>Terima Kasih!</strong> Pesan anda sudah kami terima </span
            ><a href="#" class="close"><i data-feather="x-circle"></i></a>
          </div>
          <div class="input-group">
            <i data-feather="user"></i>
            <input type="text" placeholder="Nama" name="nama" />
          </div>
          <div class="input-group">
            <i data-feather="mail"></i>
            <input type="email" placeholder="Email" name="email" />
          </div>
          <div class="input-group">
            <i data-feather="phone"></i>
            <input
              type="text"
              placeholder="No Handphone"
              name="nomor-handphone"
            />
          </div>
          <div class="input-group-pesan">
            <i data-feather="help-circle"></i>
            <input type="text" placeholder="Pesan" name="pesan" />
          </div>
          <div>
            <button type="submit" class="btn">Kirim Pesan</button>
            <div class="loader"></div>
          </div>
        </form>
      </div>
    </section>
    <!-- Contact Section End -->

    <!-- Footer Start -->
    <footer>
      <div class="socials">
        <a href="https://instagram.com/maulana__x3?igshid=MzNlNGNkZWQ4Mg=="
          ><i data-feather="instagram"></i
        ></a>
        <a href="https://www.facebook.com/"><i data-feather="facebook"></i></a>
        <a href="https://twitter.com/"><i data-feather="twitter"></i></a>
        <a href="https://www.youtube.com/"><i data-feather="youtube"></i></a>
      </div>

      <div class="links">
        <a href="#home">Home</a>
        <a href="#about">Tentang Kami</a>
        <a href="#menu">Menu</a>
        <a href="#product">Penawaran Spesial</a>
        <a href="#contact">Kontak Kami</a>
      </div>

      <div class="credit">
        <p>
          Created by
          <a href="https://instagram.com/maulana__x3?igshid=MzNlNGNkZWQ4Mg=="
            >Maulana Hidayatulloh Mujanah</a
          >
          | &copy; 2023.
        </p>
      </div>
    </footer>
    <!-- Footer End -->

    <!-- Modal Box Item Detail Start -->
    <div class="modal-1" id="item-detail-modal-1">
      <div class="modal-container">
        <a href="#" class="close-icon"><i data-feather="x"></i></a>
        <div class="modal-content">
          <img src="img/product/mild16.png" alt="mild16" />
          <div class="product-content">
            <h3>Mild 16</h3>
            <p>
              Rokok Mild, pilihan yang tepat untuk Anda yang mencari sensasi
              merokok yang lebih ringan dan santai. Nikmati kelezatan rokok Mild
              dengan rasa yang lembut dan tidak terlalu kuat.
            </p>
            <div class="product-star">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
            </div>
            <div class="product-price">
              Harga : Rp 25.000/Bungkus <span>Rp 30.000/Bungkus</span>
            </div>
            <a href="#"
              ><i data-feather="shopping-cart"></i> <span>Belanja</span></a
            >
          </div>
        </div>
      </div>
    </div>

    <div class="modal-2" id="item-detail-modal-2">
      <div class="modal-container">
        <a href="#" class="close-icon"><i data-feather="x"></i></a>
        <div class="modal-content">
          <img src="img/product/gudanggaram.png" alt="filter" />
          <div class="product-content">
            <h3>Gudang Garam Filter</h3>
            <p>
              Gudang Garam Filter, kelezatan tembakau Indonesia dengan teknologi
              filter yang sempurna. Nikmati sensasi rokok Gudang Garam Filter
              dengan rasa tembakau pilihan dan filtrasi yang optimal.
            </p>
            <div class="product-star">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
            </div>
            <div class="product-price">
              Harga : Rp 24.500/Bungkus <span>Rp 28.000/Bungkus</span>
            </div>
            <a href="#"
              ><i data-feather="shopping-cart"></i> <span>Belanja</span></a
            >
          </div>
        </div>
      </div>
    </div>

    <div class="modal-3" id="item-detail-modal-3">
      <div class="modal-container">
        <a href="#" class="close-icon"><i data-feather="x"></i></a>
        <div class="modal-content">
          <img src="img/product/super.jpg" alt="super" />
          <div class="product-content">
            <h3>Djarum Super</h3>
            <p>
              Rokok Djarum Super, kenikmatan tanpa kompromi untuk para pecinta
              sensasi rokok yang intens. Nikmati keaslian dan kekuatan rokok
              Djarum Super dalam setiap hisapan.
            </p>
            <div class="product-star">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
            </div>
            <div class="product-price">
              Harga : Rp 24.000/Bungkus <span>Rp 29.000/Bungkus</span>
            </div>
            <a href="#"
              ><i data-feather="shopping-cart"></i> <span>Belanja</span></a
            >
          </div>
        </div>
      </div>
    </div>

    <div class="modal-4" id="item-detail-modal-4">
      <div class="modal-container">
        <a href="#" class="close-icon"><i data-feather="x"></i></a>
        <div class="modal-content">
          <img src="img/product/djisamsoe.jpg" alt="super" />
          <div class="product-content">
            <h3>Dji Sam Soe</h3>
            <p>
              Rokok Dji Sam Soe, kesempurnaan dalam setiap hirupan dengan aroma
              yang mendalam. Nikmati kualitas unggul dan cita rasa khas dari
              rokok Dji Sam Soe.
            </p>
            <div class="product-star">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
            </div>
            <div class="product-price">
              Harga : Rp 20.000/Bungkus <span>Rp 24.000/Bungkus</span>
            </div>
            <a href="#"
              ><i data-feather="shopping-cart"></i> <span>Belanja</span></a
            >
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Box Item Detail End -->

    <!-- AOS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>

    <!-- Father Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My Javascript -->
    <script src="script.js"></script>

    <!-- Kirim Pesan Lewat Google Sheets -->
    <script>
      const scriptURL =
        "https://script.google.com/macros/s/AKfycbyscZwU_CUXb4iPARqUUycrcIwy8EFM-GFjl3cDq8-i6thHXmRugfLu5e5AnkxMxDZR/exec";
      const form = document.forms["warungbangjaja-contact-form"];
      const btnKirim = document.querySelector(".btn");
      const Loading = document.querySelector(".loader");
      const Alert = document.querySelector(".alert");

      form.addEventListener("submit", (e) => {
        e.preventDefault();
        // ketika tombol submit diklik
        // tampilkan loading, hilangkan tombol kirim
        btnKirim.classList.toggle("active");
        Loading.classList.toggle("active");
        fetch(scriptURL, { method: "POST", body: new FormData(form) })
          .then((response) => {
            // tampilkan tombol kirim, hilangkan loading
            Loading.classList.toggle("active");
            btnKirim.classList.toggle("active");
            // tampilkan alert
            Alert.classList.toggle("active");
            // reset form
            form.reset();
            console.log("Success!", response);
          })
          .catch((error) => console.error("Error!", error.message));
      });
    </script>
  </body>
</html>

