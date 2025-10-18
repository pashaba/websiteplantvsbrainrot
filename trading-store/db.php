<?php
$host = "sql12.freesqldatabase.com";  // Host database kamu
$user = "sql12803555";                // Username database kamu
$pass = "vIXe77n1sq";                 // Password database kamu
$dbname = "sql12803555";              // Nama database kamu
$port = 3306;                         // Port default MySQL

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Mengecek koneksi
if ($conn->connect_error) {
    die("❌ Koneksi ke database gagal: " . $conn->connect_error);
} else {
    // echo "✅ Koneksi ke database berhasil!"; // Aktifkan jika ingin test koneksi
}
?>
