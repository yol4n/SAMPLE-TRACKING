<?php
$host = 'localhost'; // Nama host database
$user = 'root';      // Username MySQL
$password = '';      // Password MySQL (kosong jika default XAMPP)
$database = 'sample_tracking'; // Nama database kamu

// Buat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "KONEKSI BERHASIL!";
}
?>
