<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal_input = $_POST['tanggal_input'] ?? '';
    $refco = $_POST['refco'] ?? '';
    $tangga = $_POST['tangga'] ?? '';
    $rak = $_POST['rak'] ?? '';
    $kode_rak = $_POST['kode_rak'] ?? '';
    $kode_sampel = $_POST['kode_sampel'] ?? '';
    $nama_sampel = $_POST['nama_sampel'] ?? '';

    // Validasi input
    if ($tanggal_input && $refco && $tangga && $rak && $kode_rak && $kode_sampel && $nama_sampel) {
        $query = "INSERT INTO samples (tanggal_input, refco, tangga, rak, kode_rak, kode_sampel, nama_sampel) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssssss", $tanggal_input, $refco, $tangga, $rak, $kode_rak, $kode_sampel, $nama_sampel);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Error: " . $stmt->error; // Tampilkan error jika gagal
        }
        $stmt->close();
    } else {
        echo "error: Data tidak lengkap.";
    }
}
?>
