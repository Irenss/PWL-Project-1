<?php
include 'koneksi.php';

$id = $_GET['id'];
$sql = "SELECT * FROM barang WHERE id_barang = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['submit'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $satuan = $_POST['satuan'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $jumlah = $_POST['jumlah'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $keterangan = $_POST['keterangan'];
    
    // Cek apakah upload foto baru
    if($_FILES['foto']['name'] != "") {
        $foto = $_FILES['foto']['name'];
        $tmp_foto = $_FILES['foto']['tmp_name'];
        $path = "uploads/".$foto;
        
        // Hapus foto lama
        if($row['foto'] && file_exists("uploads/".$row['foto'])) {
            unlink("uploads/".$row['foto']);
        }
        
        move_uploaded_file($tmp_foto, $path);
        
        $sql = "UPDATE barang SET 
                kode_barang='$kode_barang',
                nama_barang='$nama_barang',
                satuan='$satuan',
                harga_beli='$harga_beli',
                harga_jual='$harga_jual',
                jumlah='$jumlah',
                tanggal_masuk='$tanggal_masuk',
                keterangan='$keterangan',
                foto='$foto'
                WHERE id_barang=$id";
    } else {
        $sql = "UPDATE barang SET 
                kode_barang='$kode_barang',
                nama_barang='$nama_barang',
                satuan='$satuan',
                harga_beli='$harga_beli',
                harga_jual='$harga_jual',
                jumlah='$jumlah',
                tanggal_masuk='$tanggal_masuk',
                keterangan='$keterangan'
                WHERE id_barang=$id";
    }
    
    if(mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
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
        img {
            max-width: 200px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Edit Barang</h1>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Kode Barang:</label>
            <input type="text" name="kode_barang" value="<?php echo $row['kode_barang']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Nama Barang:</label>
            <input type="text" name="nama_barang" value="<?php echo $row['nama_barang']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Satuan:</label>
            <input type="text" name="satuan" value="<?php echo $row['satuan']; ?>">
        </div>
        
        <div class="form-group">
            <label>Harga Beli:</label>
            <input type="number" name="harga_beli" value="<?php echo $row['harga_beli']; ?>" step="0.01">
        </div>
        
        <div class="form-group">
            <label>Harga Jual:</label>
            <input type="number" name="harga_jual" value="<?php echo $row['harga_jual']; ?>" step="0.01">
        </div>
        
        <div class="form-group">
            <label>Jumlah:</label>
            <input type="number" name="jumlah" value="<?php echo $row['jumlah']; ?>">
        </div>
        
        <div class="form-group">
            <label>Tanggal Masuk:</label>
            <input type="date" name="tanggal_masuk" value="<?php echo $row['tanggal_masuk']; ?>">
        </div>
        
        <div class="form-group">
            <label>Keterangan:</label>
            <textarea name="keterangan" rows="4"><?php echo $row['keterangan']; ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Foto Saat Ini:</label><br>
            <?php if($row['foto']) { ?>
                <img src="uploads/<?php echo $row['foto']; ?>" alt="Foto"><br>
            <?php } ?>
            <label>Upload Foto Baru (kosongkan jika tidak ingin mengganti):</label>
            <input type="file" name="foto" accept="image/*">
        </div>
        
        <input type="submit" name="submit" value="Update">
        <a href="index.php">Kembali</a>
    </form>
</body>
</html>