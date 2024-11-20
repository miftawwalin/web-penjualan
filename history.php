<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mendapatkan nama user yang sedang login
$nama_user = $_SESSION['nama_user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Transaksi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container my-4">
    <h2>History Transaksi</h2>
    <hr>

    <!-- Tabel riwayat transaksi -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan riwayat transaksi dari database
            $sql = "SELECT * FROM transaksi WHERE id_user = '{$_SESSION['id_user']}' ORDER BY tanggal_transaksi DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_transaksi']}</td>
                            <td>{$row['tanggal_transaksi']}</td>
                            <td>Rp. " . number_format($row['total'], 0, ',', '.') . "</td>
                            <td><a href='detail_transaksi.php?id_transaksi={$row['id_transaksi']}' class='btn btn-info btn-sm'>Lihat Detail</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>Tidak ada transaksi</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Kembali ke Halaman Utama</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
