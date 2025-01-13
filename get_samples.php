<?php
include 'db.php';

$sql = "SELECT id, tanggal_input, refco, tangga, rak, kode_rak, kode_sampel, nama_sampel FROM samples";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>
