<?php

// Fungsi untuk mendapatkan alamat IP pengguna
function getUserIpAddress() {
    $ipAddress = file_get_contents("https://api.ipify.org/");
    return $ipAddress;
}

// Fungsi untuk mendapatkan lokasi pengguna berdasarkan alamat IP
function getUserLocation($ipAddress) {
    // Mengambil alamat IP pengguna dari parameter
    // Kemudian menggunakan alamat IP tersebut untuk mendapatkan informasi lokasi pengguna dari layanan geolocation
    // Menggunakan layanan seperti ip-api.com untuk mendapatkan informasi lokasi berdasarkan alamat IP
    $response = file_get_contents("http://ip-api.com/json/{$ipAddress}");
    $data = json_decode($response, true);
    
    // Periksa apakah data yang diterima sesuai dengan yang diharapkan
    if(isset($data['lat']) && isset($data['lon'])) {
        return array("lat" => $data['lat'], "lon" => $data['lon']); // Mengembalikan koordinat lintang dan bujur pengguna
    } else {
        throw new Exception("Tidak dapat mendapatkan lokasi pengguna.");
    }
}

// Dapatkan alamat IP pengguna
$userIpAddress = getUserIpAddress();

// Dapatkan informasi lokasi pengguna berdasarkan alamat IP
try {
    $userLocation = getUserLocation($userIpAddress);
} catch (Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}

?>
