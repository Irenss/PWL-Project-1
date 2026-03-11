<?php
include 'config.php';

$id = $_GET['id'];

// Ambil data foto untuk dihapus
$sql = "SELECT foto FROM barang WHERE id_barang = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Hapus file foto
if($row['foto'] && file_exists("uploads/".$row['foto'])) {
    unlink("uploads/".$row['foto']);
}

// Hapus data dari database
$sql = "DELETE FROM barang WHERE id_barang = $id";
if(mysqli_query($conn, $sql)) {
    header("Location: index.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>