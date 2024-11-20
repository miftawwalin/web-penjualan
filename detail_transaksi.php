<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$nama_user = $_SESSION['nama_user'];

// Mendapatkan ID transaksi dari URL
$id_transaksi = $_GET['id_transaksi'];

// Mendapatkan data transaksi dari database
$sql_transaksi = "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'";
$result_transaksi = $conn->query($sql_transaksi);
$transaksi = $result_transaksi->fetch_assoc();

// Mendapatkan data detail transaksi dari database
$sql_detail = "SELECT * FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'";
$result_detail = $conn->query($sql_detail);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container my-4">
    <h2>Detail Transaksi</h2>
    <hr>

    <div class="mb-3">
        <strong>ID Transaksi:</strong> <?php echo $transaksi['id_transaksi']; ?><br>
        <strong>Tanggal:</strong> <?php echo $transaksi['tanggal_transaksi']; ?><br>
        <strong>Kasir:</strong> <?php echo $nama_user; ?><br>
        <strong>Sub Total:</strong> Rp. <?php echo number_format($transaksi['total'], 0, ',', '.'); ?>
        
    </div>

    <h4>Rincian Barang</h4>
    <table class="table table-bordered">
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
            if ($result_detail->num_rows > 0) {
                while ($row = $result_detail->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nama_produk']}</td>
                            <td>{$row['jumlah']}</td>
                            <td>Rp. " . number_format($row['harga_satuan'], 0, ',', '.') . "</td>
                            <td>Rp. " . number_format($row['total_harga'], 0, ',', '.') . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td> colspan='4' class='text-center'>Tidak ada detail barang</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<div class="text-center">
        <button onclick="window.print()" class="btn btn-primary">Cetak Struk</button>
        <a href="history.php.php" class="btn btn-secondary">Kembali ke History</a>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
