<?php
session_start();
include '../config/database.php'; // Koneksi ke database

// **LOGIN HANDLER**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek apakah user ada di database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password (harus dalam bentuk hash jika menggunakan enkripsi)
        if (password_verify($password, $user['password'])) {
            // Simpan data ke session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['nama'];

            // Redirect berdasarkan role
            switch ($user['role']) {
                case 'admin':
                    header("Location: ../admin/dashboard.php");
                    break;
                case 'dosen':
                    header("Location: ../dosen/dashboard.php");
                    break;
                case 'mahasiswa':
                    header("Location: ../mahasiswa/dashboard.php");
                    break;
                default:
                    header("../public/login.php");
                    break;
            }
            exit();
        } else {
            $_SESSION['error'] = "Password salah!";
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan!";
    }
    header("../public/login.php");
    exit();
}

// **LOGOUT HANDLER**
if (isset($_GET['logout'])) {
    session_destroy();
    header("../public/login.php");
    exit();
}
?>
