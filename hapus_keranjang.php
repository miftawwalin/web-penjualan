<?php
// Mulai sesi untuk mengambil data keranjang
session_start();

// Cek apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    // Ambil ID item yang ingin dihapus
    $id = $_GET['id'];

    // Pastikan bahwa data keranjang ada dalam sesi
    if (isset($_SESSION['keranjang']) && is_array($_SESSION['keranjang'])) {
        // Cek jika item dengan ID yang sesuai ada di keranjang
        if (isset($_SESSION['keranjang'][$id])) {
            // Hapus item tersebut
            unset($_SESSION['keranjang'][$id]);
            
            // Redirect kembali ke halaman keranjang setelah item dihapus
            header('Location: index.php'); // Ganti 'keranjang.php' dengan nama halaman yang sesuai
            exit();
        } else {
            // Jika item tidak ditemukan, Anda bisa memberikan pesan error atau lainnya
            echo "Item tidak ditemukan dalam keranjang.";
        }
    } else {
        echo "Keranjang kosong.";
    }
} else {
    echo "ID item tidak ditemukan.";
}
?>
