<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config/database.php';

// Pastikan ada ID mahasiswa yang dikirim untuk dihapus
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Mahasiswa tidak ditemukan!";
    header("Location: manage_mahasiswa.php");
    exit();
}

$id_mahasiswa = intval($_GET['id']);

// Ambil id_user sebelum menghapus mahasiswa
$get_user_query = "SELECT id_user FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
$user_result = mysqli_query($conn, $get_user_query);
$user_data = mysqli_fetch_assoc($user_result);

if (!$user_data) {
    $_SESSION['error'] = "Mahasiswa tidak ditemukan!";
    header("Location: manage_mahasiswa.php");
    exit();
}

$id_user = $user_data['id_user'];

// Hapus mahasiswa dari tabel mahasiswa
$delete_mahasiswa_query = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
$delete_user_query = "DELETE FROM users WHERE id_user = $id_user";

if (mysqli_query($conn, $delete_mahasiswa_query) && mysqli_query($conn, $delete_user_query)) {
    $_SESSION['success'] = "Mahasiswa berhasil dihapus!";
} else {
    $_SESSION['error'] = "Gagal menghapus mahasiswa!";
}

header("Location: manage_mahasiswa.php");
exit();
?>
