<?php
header('Content-Type: application/json');
include 'db.php';

// Pastikan parameter "action" ada di URL
if (!isset($_GET['action'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

$action = $_GET['action'];

switch ($action) {
    case 'get': // Ambil data
        $result = $conn->query("SELECT * FROM samples ORDER BY id DESC");
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    case 'add': // Tambah data
        $tanggal = $_POST['tanggal_input'];
        $refco = $_POST['refco'];
        $tangga = $_POST['tangga'];
        $rak = $_POST['rak'];
        $kode_rak = $_POST['kode_rak'];
        $kode_sampel = $_POST['kode_sampel'];
        $nama_sample = $_POST['nama_sample'];

        $stmt = $conn->prepare("INSERT INTO samples (tanggal_input, refco, tangga, rak, kode_rak, kode_sampel, nama_sampel) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssisss", $tanggal, $refco, $tangga, $rak, $kode_rak, $kode_sampel, $nama_sample);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Data berhasil ditambahkan"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menambahkan data"]);
        }
        break;

    case 'delete': // Hapus data
        $id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM samples WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Data berhasil dihapus"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menghapus data"]);
        }
        break;

    case 'update': // Update data
        $id = $_POST['id'];
        $tanggal = $_POST['tanggal_input'];
        $refco = $_POST['refco'];
        $tangga = $_POST['tangga'];
        $rak = $_POST['rak'];
        $kode_rak = $_POST['kode_rak'];
        $kode_sampel = $_POST['kode_sampel'];
        $nama_sample = $_POST['nama_sample'];

        $stmt = $conn->prepare("UPDATE samples SET tanggal_input = ?, refco = ?, tangga = ?, rak = ?, kode_rak = ?, kode_sampel = ?, nama_sampel = ? WHERE id = ?");
        $stmt->bind_param("sssisssi", $tanggal, $refco, $tangga, $rak, $kode_rak, $kode_sampel, $nama_sample, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Data berhasil diperbarui"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal memperbarui data"]);
        }
        break;

    case 'search': // Cari data
        $keyword = $_GET['keyword'];
        $stmt = $conn->prepare("SELECT * FROM samples WHERE nama_sampel LIKE CONCAT('%', ?, '%')");
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Aksi tidak valid"]);
        break;
}

$conn->close();
?>
