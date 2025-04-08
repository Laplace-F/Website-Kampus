<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config/database.php';

// Pastikan ada ID mata kuliah yang dikirim untuk dihapus
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Mata kuliah tidak ditemukan!";
    header("Location: manage_matkul.php");
    exit();
}

$id_matkul = intval($_GET['id']);

// Hapus mata kuliah dari tabel mata_kuliah
$delete_query = "DELETE FROM mata_kuliah WHERE id_matkul = $id_matkul";

if (mysqli_query($conn, $delete_query)) {
    $_SESSION['success'] = "Mata kuliah berhasil dihapus!";
} else {
    $_SESSION['error'] = "Gagal menghapus mata kuliah!";
}

header("Location: manage_matkul.php");
exit();
?>
