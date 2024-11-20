<?php
session_start();  // Mulai sesi

// Menghapus semua data sesi
session_unset();  // Menghapus semua variabel sesi
session_destroy();  // Menghancurkan sesi yang ada

// Redirect ke halaman login setelah logout
header("Location: login.php");
exit();