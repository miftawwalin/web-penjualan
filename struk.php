<?php
session_start();  // Mulai session
include 'koneksi.php';  // Menyertakan koneksi.php

// Cek apakah ID transaksi ada di URL
if (!isset($_GET['id_transaksi'])) {
    echo "ID Transaksi tidak ditemukan.";
    exit();
}
$nama_user = $_SESSION['nama_user'];

// Ambil ID transaksi dari URL
$id_transaksi = $_GET['id_transaksi'];

// Ambil data transaksi dari database
$sql_transaksi = "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'";
$result_transaksi = $conn->query($sql_transaksi);
$transaksi = $result_transaksi->fetch_assoc();

// Ambil detail transaksi
$sql_detail = "SELECT * FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'";
$result_detail = $conn->query($sql_detail);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>

<div class="container my-4">
    <h3 class="text-center">Struk Transaksi</h3>
    <hr>
    <p><strong>ID Transaksi:</strong> <?php echo $transaksi['id_transaksi']; ?></p>
    <p><strong>Tanggal:</strong> <?php echo $transaksi['tanggal_transaksi']; ?></p>
    <p><strong>Kasir:</strong> <?php echo $nama_user; ?></p>
    
    <h4>Detail Barang</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($item = $result_detail->fetch_assoc()) {
                echo "<tr>
                        <td>{$item['nama_produk']}</td>
                        <td>{$item['jumlah']}</td>
                        <td>Rp. " . number_format($item['harga_satuan'], 0, ',', '.') . "</td>
                        <td>Rp. " . number_format($item['total_harga'], 0, ',', '.') . "</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    
    <h4 class="text-end">Total: Rp. <?php echo number_format($transaksi['total'], 0, ',', '.'); ?></h4>
    
</div>
<div class="text-center">
        <button onclick="window.print()" class="btn btn-primary">Cetak Struk</button>
        <a href="index.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</body>
</html>
