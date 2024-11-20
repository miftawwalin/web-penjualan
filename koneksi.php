<?php
$host = "localhost";  // Ganti dengan host database Anda jika diperlukan
$username = "root";   // Ganti dengan username database Anda
$password = "";       // Ganti dengan password database Anda
$dbname = "penjualan";  // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}