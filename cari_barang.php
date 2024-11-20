<?php
include 'koneksi.php';  // Menyertakan koneksi.php

if (isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];
    
    // Cari barang berdasarkan ID
    $sql = "SELECT * FROM barang WHERE id_barang LIKE '%$id_barang%'";
    $result = $conn->query($sql);
    
    $barang = [];
    while ($row = $result->fetch_assoc()) {
        $barang[] = $row;
    }
    
    echo json_encode($barang);
}
