<?php
session_start();

// Cek apakah user sudah login
if (isset($_SESSION['user_role'])) {
    // Redirect berdasarkan role
    switch ($_SESSION['user_role']) {
        case 'admin':
            header('Location: admin/dashboard.php');
            break;
        case 'dosen':
            header('Location: dosen/dashboard.php');
            break;
        case 'mahasiswa':
            header('Location: mahasiswa/dashboard.php');
            break;
        default:
            session_destroy();
            header('Location: login.php');
            exit();
    }
} else {
    // Jika belum login, arahkan ke halaman login
    header('Location: login.php');
    exit();
}
?>
