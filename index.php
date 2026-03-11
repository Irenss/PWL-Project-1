<?php
include 'koneksi.php';

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Inventaris</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
            margin: 2px;
            display: inline-block;
            font-size: 14px;
        }
        .btn-tambah {
            background-color: #4CAF50;
            padding: 10px 20px;
            margin-bottom: 20px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-tambah:hover {
            background-color: #45a049;
        }
        .btn-edit {
            background-color: #FFC107;
        }
        .btn-edit:hover {
            background-color: #e0a800;
        }
        .btn-hapus {
            background-color: #F44336;
        }
        .btn-hapus:hover {
            background-color: #da190b;
        }
        img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 4px;
        }
        .alert {
            padding: 15px;
            background-color: #f44336;
            color: white;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sistem Manajemen Inventaris</h1>
        
        <a href="tambah.php" class="btn btn-tambah">+ Tambah Barang Baru</a>
        
        <?php
        // Query untuk mengambil data
        $sql = "SELECT * FROM barang ORDER BY id_barang DESC";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Jumlah</th>
                <th>Tanggal Masuk</th>
                <th>Keterangan</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
            
            <?php
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['id_barang']."</td>";
                echo "<td>".$row['kode_barang']."</td>";
                echo "<td>".$row['nama_barang']."</td>";
                echo "<td>".$row['satuan']."</td>";
                echo "<td>Rp ".number_format($row['harga_beli'], 0, ',', '.')."</td>";
                echo "<td>Rp ".number_format($row['harga_jual'], 0, ',', '.')."</td>";
                echo "<td>".$row['jumlah']."</td>";
                echo "<td>".date('d-m-Y', strtotime($row['tanggal_masuk']))."</td>";
                echo "<td>".$row['keterangan']."</td>";
                echo "<td>";
                if($row['foto'] && file_exists("uploads/".$row['foto'])) {
                    echo "<img src='uploads/".$row['foto']."' alt='Foto'>";
                } else {
                    echo "Tidak ada foto";
                }
                echo "</td>";
                echo "<td>
                        <a href='edit.php?id=".$row['id_barang']."' class='btn btn-edit'>Edit</a>
                        <a href='hapus.php?id=".$row['id_barang']."' class='btn btn-hapus' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
        <?php 
        } else {
            echo "<p>Belum ada data barang. Silakan tambah data baru.</p>";
        }
        
        // Tutup koneksi
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>