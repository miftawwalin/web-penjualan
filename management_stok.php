<?php
// Menyertakan koneksi.php untuk koneksi ke database
include('koneksi.php');

// Inisialisasi variabel
$id_barang = '';
$nama_barang = '';
$harga_satuan = '';
$stok = '';
$modal_message = ''; // Variabel untuk pesan modal

// Proses pencarian barang berdasarkan id_barang atau nama_barang
if (isset($_POST['search_barang'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang']; // Menambahkan nama barang untuk pencarian

    // Periksa apakah ID Barang diisi
    if ($id_barang) {
        $sql = "SELECT id_barang, nama_produk, harga_satuan, stok FROM barang WHERE id_barang = ?";
        $stmt = $conn->prepare($sql); // Siapkan query
        $stmt->bind_param("i", $id_barang); // Binding parameter untuk ID
    }
    // Periksa apakah Nama Barang diisi
    elseif ($nama_barang) {
        $sql = "SELECT id_barang, nama_produk, harga_satuan, stok FROM barang WHERE nama_produk LIKE ?";
        $stmt = $conn->prepare($sql); // Siapkan query
        $nama_barang = "%" . $nama_barang . "%"; // Untuk pencarian menggunakan LIKE
        $stmt->bind_param("s", $nama_barang); // Binding parameter untuk Nama barang
    }

    if (isset($stmt)) {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_barang = $row['id_barang'];
            $nama_barang = $row['nama_produk'];
            $harga_satuan = $row['harga_satuan'];
            $stok = $row['stok'];
            $modal_message = "Data barang ditemukan!"; // Menampilkan pesan pada modal
        } else {
            $modal_message = "Barang dengan ID atau Nama tersebut tidak ditemukan."; // Pesan jika barang tidak ditemukan
        }
    }
}

// Proses update stok
if (isset($_POST['update_stok'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga_satuan = $_POST['harga_satuan'];
    $stok = $_POST['stok'];

    // Update barang di database
    $update_sql = "UPDATE barang SET nama_produk = ?, harga_satuan = ?, stok = ? WHERE id_barang = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sdii", $nama_barang, $harga_satuan, $stok, $id_barang);

    if ($stmt->execute()) {
        echo "<p>Data barang berhasil diperbarui.</p>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Proses hapus barang
if (isset($_POST['delete_barang'])) {
    $id_barang = $_POST['id_barang'];

    // Hapus barang dari database
    $delete_sql = "DELETE FROM barang WHERE id_barang = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id_barang);

    if ($stmt->execute()) {
        echo "<p>Barang berhasil dihapus.</p>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Stok Barang</title>
    <style>
        /* CSS sama seperti sebelumnya */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #4CAF50;
        }

        /* Form Style */
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-container button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 48%;
            margin-right: 4%;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        .form-container button:active {
            transform: scale(0.98);
        }

        .form-container .delete-btn {
            background-color: #f44336;
        }

        .form-container .delete-btn:hover {
            background-color: #e53935;
        }

        .form-container .btn-group {
            display: flex;
            justify-content: space-between;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-ok {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-ok:hover {
            background-color: #45a049;
        }

        /* Table Style */
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table button {
            padding: 8px 12px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table button:hover {
            background-color: #0b79d0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
                width: 90%;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <h2>Manajemen Stok Barang</h2>

    <!-- Form Pencarian dan Edit Barang -->
    <div class="form-container">
        <form method="post" action="">
            <label for="id_barang">ID Barang: </label>
            <input type="number" name="id_barang" value="<?php echo htmlspecialchars($id_barang); ?>" placeholder="Masukkan ID Barang">

           <!-- <label for="nama_barang">Nama Barang: </label>
            <input type="text" name="nama_barang" value="<?php echo htmlspecialchars($nama_barang); ?>" placeholder="Masukkan Nama Barang"> -->

            <button type="submit" name="search_barang">Search</button><br><br>

            <label for="nama_barang">Nama Barang: </label>
            <input type="text" name="nama_barang" value="<?php echo htmlspecialchars($nama_barang); ?>">

            <label for="harga_satuan">Harga Satuan: </label>
            <input type="number" step="0.01" name="harga_satuan" value="<?php echo htmlspecialchars($harga_satuan); ?>">

            <label for="stok">Stok: </label>
            <input type="number" name="stok" value="<?php echo htmlspecialchars($stok); ?>"><br><br>

            <div class="btn-group">
                <button type="submit" name="update_stok">Update</button>
                <button type="submit" name="delete_barang" class="delete-btn">Delete</button>
            </div>
        </form>
    </div>

    <!-- Modal untuk Menampilkan Data Barang -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p><?php echo $modal_message; ?></p>
            <?php if ($modal_message === "Data barang ditemukan!") { ?>
                <table>
                    <tr><th>ID Barang</th><td><?php echo htmlspecialchars($id_barang); ?></td></tr>
                    <tr><th>Nama Barang</th><td><?php echo htmlspecialchars($nama_barang); ?></td></tr>
                    <tr><th>Harga Satuan</th><td><?php echo htmlspecialchars($harga_satuan); ?></td></tr>
                    <tr><th>Stok</th><td><?php echo htmlspecialchars($stok); ?></td></tr>
                </table>
            <?php } ?>
            <button class="btn-ok" onclick="closeModal()">OK</button>
        </div>
    </div>

    <script>
        // Menampilkan modal
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];
        
        // Menampilkan modal jika ada data barang yang ditemukan
        <?php if ($modal_message) { ?>
            modal.style.display = "block";
        <?php } ?>

        // Menutup modal ketika klik pada tombol close atau OK
        span.onclick = function() {
            modal.style.display = "none";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        // Menutup modal jika klik di luar modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
