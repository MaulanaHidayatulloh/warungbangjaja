<?php

// Fungsi untuk menghitung jarak antara dua titik koordinat dalam kilometer menggunakan formula Haversine
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    // Radius bumi dalam kilometer
    $radius = 6371;

    // Konversi koordinat lintang dan bujur ke radian
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    // Perbedaan antara koordinat lintang dan bujur
    $dLat = $lat2 - $lat1;
    $dLon = $lon2 - $lon1;

    // Rumus Haversine
    $a = sin($dLat / 2) * sin($dLat / 2) + cos($lat1) * cos($lat2) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $radius * $c;

    return $distance;
}

?>
