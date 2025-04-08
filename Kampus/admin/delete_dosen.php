<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config/database.php';

// Pastikan ada ID dosen yang dikirim untuk dihapus
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Dosen tidak ditemukan!";
    header("Location: manage_dosen.php");
    exit();
}

$id_dosen = intval($_GET['id']);

// Ambil id_user sebelum menghapus dosen
$get_user_query = "SELECT id_user FROM dosen WHERE id_dosen = $id_dosen";
$user_result = mysqli_query($conn, $get_user_query);
$user_data = mysqli_fetch_assoc($user_result);

if (!$user_data) {
    $_SESSION['error'] = "Dosen tidak ditemukan!";
    header("Location: manage_dosen.php");
    exit();
}

$id_user = $user_data['id_user'];

// Hapus dosen dari tabel dosen
$delete_dosen_query = "DELETE FROM dosen WHERE id_dosen = $id_dosen";
$delete_user_query = "DELETE FROM users WHERE id_user = $id_user";

if (mysqli_query($conn, $delete_dosen_query) && mysqli_query($conn, $delete_user_query)) {
    $_SESSION['success'] = "Dosen berhasil dihapus!";
} else {
    $_SESSION['error'] = "Gagal menghapus dosen!";
}

header("Location: manage_dosen.php");
exit();
?>
