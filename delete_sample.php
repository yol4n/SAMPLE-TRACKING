<?php
include 'db.php';

$id = $_POST['id'];

$sql = "DELETE FROM samples WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil dihapus";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
