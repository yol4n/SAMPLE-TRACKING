<?php
$host = 'localhost'; // Atau IP server database
$user = 'root'; // Username MySQL
$password = ''; // Password MySQL
$database = 'sample_tracking'; // Nama database

$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
