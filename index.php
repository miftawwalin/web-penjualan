<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mendapatkan tanggal dan jam saat ini
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d H:i:s');
$jam = date('H:i:s');

// Menampilkan nama user yang sedang login
$nama_user = $_SESSION['nama_user'];

// Menyimpan transaksi saat tombol "Cetak Transaksi" ditekan
if (isset($_POST['cetak_transaksi'])) {
    // Debugging untuk melihat data yang diterima
    var_dump($_POST);

    // Menghitung total transaksi dari keranjang belanja
    $total_transaksi = 0;
    foreach ($_SESSION['keranjang'] as $item) {
        $total_transaksi += $item['total_harga'];
    }
    
    // Mendapatkan ID user yang sedang login
    $id_user = $_SESSION['id_user'];

    // Membuat ID transaksi dengan format tanggal dan nomor urut
    $id_transaksi = date('YmdHis');  // ID transaksi menggunakan format tanggal dan jam
    
    // Menyimpan data transaksi ke tabel transaksi
    $sql_transaksi = "INSERT INTO transaksi (id_transaksi, id_user, tanggal_transaksi, total) 
                      VALUES ('$id_transaksi', '$id_user', '$tanggal', '$total_transaksi')";
    if ($conn->query($sql_transaksi) === TRUE) {
        // Menyimpan detail transaksi ke tabel detail_transaksi
        foreach ($_SESSION['keranjang'] as $barang_item) {
            $sql_detail = "INSERT INTO detail_transaksi (id_transaksi, nama_produk, jumlah, harga_satuan, total_harga) 
                           VALUES ('$id_transaksi', '{$barang_item['nama_produk']}', '{$barang_item['jumlah']}', 
                                   '{$barang_item['harga_satuan']}', '{$barang_item['total_harga']}')";
            $conn->query($sql_detail);
        }

        // Mengosongkan keranjang setelah transaksi disimpan
        unset($_SESSION['keranjang']);

        // Redirect ke struk.php dengan ID transaksi
        header("Location: struk.php?id_transaksi=$id_transaksi");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $conn->error . "<br>";
    }
}

// Cek jika tombol 'Tambah ke Keranjang' diklik
if (isset($_POST['tambah_keranjang'])) {
    // Mendapatkan data barang yang dipilih
    $id_barang = $_POST['id_barang'];
    $nama_produk = $_POST['nama_produk'];
    $harga_satuan = $_POST['harga_satuan'];
    $jumlah = $_POST['jumlah'];

    // Menghitung total harga untuk item yang dibeli
    $total_harga = $harga_satuan * $jumlah;

    // Menambahkan barang ke dalam keranjang
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];  // Inisialisasi keranjang jika belum ada
    }

    // Menambahkan item ke keranjang
    $keranjang = $_SESSION['keranjang'];
    $keranjang[] = [
        'id_barang' => $id_barang,
        'nama_produk' => $nama_produk,
        'harga_satuan' => $harga_satuan,
        'jumlah' => $jumlah,
        'total_harga' => $total_harga
    ];

    // Menyimpan keranjang kembali ke session
    $_SESSION['keranjang'] = $keranjang;
}

// Menampilkan barang yang telah ditambahkan ke keranjang
$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
$total_transaksi = 0;
foreach ($keranjang as $item) {
    $total_transaksi += $item['total_harga'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cari barang
            $('#cari_barang').click(function() {
                $('#popupBarang').modal('show');
            });

            // Pilih barang dari popup
            $('.pilih-barang').click(function() {
                var id_barang = $(this).data('id');
                var nama_produk = $(this).data('nama');
                var harga_satuan = $(this).data('harga');
                $('#id_barang').val(id_barang);
                $('#nama_produk').val(nama_produk);
                $('#harga_satuan').val(harga_satuan);
                $('#popupBarang').modal('hide');
            });
        });
    </script>
</head>
<body>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Aplikasi Kasir</h2>
        <div class="d-flex align-items-center">
            <span class="me-3">Hello, <?php echo $nama_user; ?></span>
            <a href="history.php" class="btn btn-info">Lihat History Transaksi</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <hr>

    <form action="index.php" method="post">
        <!-- Form Barang -->
        <div class="mb-3">
            <label for="id_barang" class="form-label">ID Barang</label>
            <div class="input-group">
                <input type="text" class="form-control" id="id_barang" name="id_barang" readonly>
                <button type="button" id="cari_barang" class="btn btn-info">Cari Barang</button>
            </div>
        </div>

        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" readonly>
        </div>

        <div class="mb-3">
            <label for="harga_satuan" class="form-label">Harga Satuan</label>
            <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" readonly>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary" name="tambah_keranjang">Tambah ke Keranjang</button>
        </div>
    </form>

    <hr>

    <!-- Keranjang Belanja -->
    <h4>Keranjang Belanja</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($keranjang as $key => $item) {
                echo "<tr>
                        <td>{$item['nama_produk']}</td>
                        <td>{$item['jumlah']}</td>
                        <td>Rp. " . number_format($item['harga_satuan'], 0, ',', '.') . "</td>
                        <td>Rp. " . number_format($item['total_harga'], 0, ',', '.') . "</td>
                        <td>
                            <a href='hapus_keranjang.php?id=$key' class='btn btn-danger btn-sm'>Hapus</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

    <h4 class="text-end">Total: Rp. <?php echo number_format($total_transaksi, 0, ',', '.'); ?></h4>
    <form method="post">
    <div class="text-center">
        <button type="submit" name="cetak_transaksi" class="btn btn-success">Cetak Transaksi</button>
    </div>
    </form>
</div>

<!-- Popup Cari Barang -->
<div class="modal fade" id="popupBarang" tabindex="-1" aria-labelledby="popupBarangLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupBarangLabel">Cari Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Produk</th>
                            <th>Harga Satuan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_barang = "SELECT * FROM barang";
                        $result_barang = $conn->query($sql_barang);
                        if ($result_barang->num_rows > 0) {
                            while ($barang = $result_barang->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$barang['id_barang']}</td>
                                        <td>{$barang['nama_produk']}</td>
                                        <td>Rp. " . number_format($barang['harga_satuan'], 0, ',', '.') . "</td>
                                        <td><button class='btn btn-primary pilih-barang' 
                                            data-id='{$barang['id_barang']}'
                                            data-nama='{$barang['nama_produk']}'
                                            data-harga='{$barang['harga_satuan']}'>Pilih</button></td>
                                      </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

            <div class="footer">
                <p>&copy; 2024 Aplikasi Kasir Kelompok 2.</p>
            </div>
</body>
</html>
