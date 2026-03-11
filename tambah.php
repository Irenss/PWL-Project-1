<?php
include 'koneksi.php';

if(isset($_POST['submit'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $satuan = $_POST['satuan'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $jumlah = $_POST['jumlah'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $keterangan = $_POST['keterangan'];
    
    // Upload foto
    $foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];
    $path = "uploads/".$foto;
    
    if(move_uploaded_file($tmp_foto, $path)) {
        $sql = "INSERT INTO barang (kode_barang, nama_barang, satuan, harga_beli, harga_jual, jumlah, tanggal_masuk, keterangan, foto) 
                VALUES ('$kode_barang', '$nama_barang', '$satuan', '$harga_beli', '$harga_jual', '$jumlah', '$tanggal_masuk', '$keterangan', '$foto')";
        
        if(mysqli_query($conn, $sql)) {
            header("Location: index.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal upload foto";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <style>
        form {
            width: 50%;
            margin: 0 auto;
        }
        input[type=text], input[type=number], input[type=date], textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Tambah Barang</h1>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Kode Barang:</label>
            <input type="text" name="kode_barang" required>
        </div>
        
        <div class="form-group">
            <label>Nama Barang:</label>
            <input type="text" name="nama_barang" required>
        </div>
        
        <div class="form-group">
            <label>Satuan:</label>
            <input type="text" name="satuan">
        </div>
        
        <div class="form-group">
            <label>Harga Beli:</label>
            <input type="number" name="harga_beli" step="0.01">
        </div>
        
        <div class="form-group">
            <label>Harga Jual:</label>
            <input type="number" name="harga_jual" step="0.01">
        </div>
        
        <div class="form-group">
            <label>Jumlah:</label>
            <input type="number" name="jumlah">
        </div>
        
        <div class="form-group">
            <label>Tanggal Masuk:</label>
            <input type="date" name="tanggal_masuk">
        </div>
        
        <div class="form-group">
            <label>Keterangan:</label>
            <textarea name="keterangan" rows="4"></textarea>
        </div>
        
        <div class="form-group">
            <label>Foto:</label>
            <input type="file" name="foto" accept="image/*" required>
        </div>
        
        <input type="submit" name="submit" value="Simpan">
        <a href="index.php">Kembali</a>
    </form>
</body>
</html>