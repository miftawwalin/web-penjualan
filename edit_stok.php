<?php
// Menyertakan koneksi.php untuk koneksi ke database
include('koneksi.php');

// Proses update stok
if (isset($_POST['update_stok'])) {
    $id_barang = $_POST['id_barang'];
    $stok_update = $_POST['stok_update'];

    // Update stok di database
    $update_sql = "UPDATE barang SET stok = $stok_update WHERE id_barang = $id_barang";
    if ($conn->query($update_sql) === TRUE) {
        echo "<p>Stok berhasil diperbarui.</p>";
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stok Barang</title>
</head>
<body>
    <h2>Edit Stok Barang</h2>

    <!-- Menampilkan daftar barang -->
    <h3>Daftar Barang</h3>
    <?php
    // Query untuk mengambil data barang
    $sql = "SELECT id_barang, nama_produk, harga_satuan, stok FROM barang";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID Barang</th>
                    <th>Nama Produk</th>
                    <th>Harga Satuan</th>
                    <th>Stok</th>
                    <th>Edit Stok</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row['id_barang']."</td>
                    <td>".$row['nama_produk']."</td>
                    <td>".$row['harga_satuan']."</td>
                    <td>".$row['stok']."</td>
                    <td>
                        <a href='edit_stok.php?id_barang=".$row['id_barang']."'>Edit Stok</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Tidak ada data barang.</p>";
    }
    ?>

    <!-- Form untuk update stok (apabila id_barang ada di URL) -->
    <?php
    if (isset($_GET['id_barang'])) {
        $id_barang = $_GET['id_barang'];

        // Ambil data barang berdasarkan ID
        $sql = "SELECT id_barang, nama_produk, harga_satuan, stok FROM barang WHERE id_barang = $id_barang";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <h3>Update Stok untuk Barang: <?php echo $row['nama_produk']; ?></h3>
            <form method="post" action="edit_stok.php">
                <input type="hidden" name="id_barang" value="<?php echo $row['id_barang']; ?>">
                <label>Nama Produk: </label>
                <input type="text" name="nama_produk" value="<?php echo $row['nama_produk']; ?>" disabled><br>
                <label>Harga Satuan: </label>
                <input type="text" name="harga_satuan" value="<?php echo $row['harga_satuan']; ?>" disabled><br>
                <label>Stok Saat Ini: </label>
                <input type="number" name="stok" value="<?php echo $row['stok']; ?>" disabled><br>
                <label>Stok Baru: </label>
                <input type="number" name="stok_update" required><br>
                <button type="submit" name="update_stok">Perbarui Stok</button>
            </form>
            <?php
        } else {
            echo "<p>Barang tidak ditemukan.</p>";
        }
    }
    ?>

</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
