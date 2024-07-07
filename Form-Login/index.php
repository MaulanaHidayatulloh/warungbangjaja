<?php

// Alamat IP pengguna
$userIpAddress = $_SERVER['REMOTE_ADDR'];

// Include file yang berisi fungsi getUserLocation
require_once '../getUserLocation.php';

try {
    // Panggil fungsi untuk mendapatkan lokasi pengguna berdasarkan alamat IP
    $userLocation = getUserLocation($userIpAddress);

    // Koordinat server
    $serverLatitude = -6.159234;
    $serverLongitude =  106.704820;

    // surabaya
    // $serverLatitude = -7.299572;
    // $serverLongitude =  112.737242;

    // Include file yang berisi fungsi calculateDistance
    require_once '../calculateDistance.php';
    // Hitung jarak antara pengguna dan server
    $distance = calculateDistance($userLocation['lat'], $userLocation['lon'], $serverLatitude, $serverLongitude);

    // Batas jarak yang diizinkan (misalnya, 20 kilometer)
    $allowedDistance = 20;

    // Periksa apakah jarak melebihi batas yang diizinkan
    if ($distance > $allowedDistance) {
      echo '<script type ="text/JavaScript">';  
      echo 'alert("Mohon Maaf, website ini tidak dapat diakses dari lokasi Anda.")';  
      echo '</script>';
      echo "<meta http-equiv='refresh' content='0;url=reject.html'>";  
    } else {
      echo "";
    }
} catch (Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}

?>



<?php
session_start();

// set session 
if(isset($_SESSION["login"])) {
    header("location: ../index.php");
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

// Fungsi untuk membuat user baru
function create_user($full_name, $phone_number, $email, $address, $password) {
  global $conn;
  $password_hash = password_hash($password, PASSWORD_DEFAULT); 
  $stmt = $conn->prepare("INSERT INTO users (full_name, phone_number, email, address, password) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $full_name, $phone_number, $email, $address, $password_hash); 
  $stmt->execute();
  $stmt->close();
}

// Fungsi untuk mengautentikasi user atau admin
function authenticate_user($email, $password) {
  global $conn;

  // Cek di tabel users
  $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows == 1) {
      $user = $result->fetch_assoc();
      if (password_verify($password, $user['password'])) {
          return array_merge($user, ['role' => 'user']);
      }
  }

  // Cek di tabel admin
  $stmt = $conn->prepare("SELECT * FROM admin WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows == 1) {
      $admin = $result->fetch_assoc();
      if ($password === $admin['password']) {
          return array_merge($admin, ['role' => 'admin']);
      }
  }

  return null;
}
// Proses sign up
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
  $full_name = $_POST['full_name'];
  $phone_number = $_POST['phone_number'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $password = $_POST['password'];

  // Periksa apakah email sudah terdaftar
  $stmt_check_email = $conn->prepare("SELECT * FROM users WHERE email=?");
  $stmt_check_email->bind_param("s", $email);
  $stmt_check_email->execute();
  $result_check_email = $stmt_check_email->get_result();
  if ($result_check_email->num_rows > 0) {
      echo '<script type="text/JavaScript">';  
      echo 'alert("Email Sudah Terdaftar, Silakan Gunakan Email Lain.")';  
      echo '</script>';
      echo "<meta http-equiv='refresh' content='0;url=index.php'>";  
      exit();
  }

  // Jika email belum terdaftar, buat user baru
  create_user($full_name, $phone_number, $email, $address, $password);
  echo '<script type ="text/JavaScript">';  
  echo 'alert("Akun Telah Berhasil dibuat")';  
  echo '</script>';
  echo "<meta http-equiv='refresh' content='0;url=index.php'>";   
}


// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = authenticate_user($email, $password);
    if ($user) {
          // set session
          $_SESSION["login"] = true;
          $_SESSION["user_id"] = $user['id'];
          $_SESSION["username"] = $user['full_name'];
          $_SESSION["role"] = $user['role'];  // Menyimpan role user ke dalam sesi

          if ($user['role'] == 'admin') {
            header("Location: ../admin/admin.php");
          } else {
            header("Location: ../index.php");
          }
          exit();

    } else {
        echo '<script type ="text/JavaScript">';  
        echo 'alert("Email atau Password Salah")';  
        echo '</script>';
        echo "<meta http-equiv='refresh' content='0;url=index.php'>";  
    }
}

$conn->close();

?>

<!-- HTML -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login WarungBangJaJa</title>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="logins.css" />
  </head>
  <body>
    <div class="section">
      <div class="container">
        <div class="row full-height justify-content-center">
          <div class="col-12 text-center align-self-center py-5">
            <div class="section pb-5 pt-5 pt-sm-2 text-center">
              <h6 class="mb-0 pb-3"><span>Login </span><span>Sign Up</span></h6>
              <input
                class="checkbox"
                type="checkbox"
                id="reg-log"
                name="reg-log"
              />
              <label for="reg-log"></label>
              <div class="card-3d-wrap mx-auto">
                <div class="card-3d-wrapper">
                  <div class="card-front">
                    <div class="center-wrap">
                      <div class="section text-center">
                        <h4 class="mb-4 pb-3">Login</h4>
                        <form method="post" action="index.php">
                          <div class="form-group">
                            <input
                              type="email"
                              name="email"
                              class="form-style"
                              placeholder="Email"
                              required
                            />
                            <i class="input-icon uil uil-at"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input
                              type="password"
                              name="password"
                              class="form-style"
                              placeholder="Password"
                              required
                            />
                            <i class="input-icon uil uil-lock-alt"></i>
                          </div>
                          <button type="submit" class="btn mt-4" name="login">
                            Login
                          </button>
                        </form>
                        <p class="mb-0 mt-4 text-center">
                          <a href="http://localhost/warung-bangjaja/form-login/lupa_password.php" class="link">Forgot your password?</a>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="card-back">
                    <div class="center-wrap">
                      <div class="section text-center">
                        <h4 class="mb-3 pb-3">Sign Up</h4>
                        <form method="post" action="index.php">
                          <div class="form-group">
                            <input
                              type="text"
                              name="full_name"
                              class="form-style"
                              placeholder="Full Name"
                              required
                            />
                            <i class="input-icon uil uil-user"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input
                              type="tel"
                              name="phone_number"
                              class="form-style"
                              placeholder="Phone Number"
                              required
                            />
                            <i class="input-icon uil uil-phone"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input
                              type="email"
                              name="email"
                              class="form-style"
                              placeholder="Email"
                              required
                            />
                            <i class="input-icon uil uil-at"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input
                              type="text"
                              name="address"
                              class="form-style"
                              placeholder="Address"
                              required
                            />
                            <i class="input-icon uil uil-location-point"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input
                              type="password"
                              name="password"
                              class="form-style"
                              placeholder="Password"
                              required
                            />
                            <i class="input-icon uil uil-lock-alt"></i>
                          </div>
                          <button type="submit" class="btn mt-4" name="signup">
                            Register
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

