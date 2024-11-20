<?php
session_start();
include('koneksi.php');  // Menyertakan koneksi database

// Cek apakah sudah login
if (isset($_SESSION['username'])) {
    header("Location: index.php");  // Arahkan ke halaman dashboard jika sudah login
    exit();
}

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mencari data user di database
    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    // Jika user ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Menyimpan session username, akses, dan nama_user
        $_SESSION['username'] = $row['username'];
        $_SESSION['akses'] = $row['akses'];
        $_SESSION['nama_user'] = $row['nama_user'];  // Menyimpan nama_user dalam session
        $_SESSION['id_user'] = $row['id_user'];  // Menyimpan nama_user dalam session
        
        // Arahkan ke dashboard kasir
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}

$conn->close();  // Menutup koneksi database
?>


    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Kasir</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/login.css">  <!-- Menyertakan file CSS eksternal -->
    </head>
    <body>

        <div class="login-container">
            <h2>Login Kasir</h2>

            <?php
            // Menampilkan pesan error jika login gagal
            if (isset($error)) {
                echo "<p>" . $error . "</p>";
            }
            ?>

            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>

            <div class="footer">
                <p>&copy; 2024 Aplikasi Kasir Kelompok 2.</p>
            </div>
        </div>

    </body>
    </html>
