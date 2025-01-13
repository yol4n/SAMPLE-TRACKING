<?php
include 'db.php';

$id = $_POST['id'];
$tanggal_input = $_POST['tanggal_input'];
$refco = $_POST['refco'];
$tangga = $_POST['tangga'];
$rak = $_POST['rak'];
$kode_rak = $_POST['kode_rak'];
$kode_sampel = $_POST['kode_sampel'];
$nama_sampel = $_POST['nama_sampel'];

$sql = "UPDATE samples SET 
        tanggal_input='$tanggal_input', 
        refco='$refco', 
        tangga='$tangga', 
        rak='$rak', 
        kode_rak='$kode_rak', 
        kode_sampel='$kode_sampel', 
        nama_sampel='$nama_sampel' 
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil diperbarui";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
