<?php
session_start();
include '../config/database.php';

// Cek apakah user adalah mahasiswa
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

$id_mahasiswa = $_SESSION['user_id'];

// Tambah Mata Kuliah ke KRS
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ambil_matkul'])) {
    $id_matkul = intval($_POST['id_matkul']);

    // Cek apakah mata kuliah sudah pernah diambil sebelumnya oleh mahasiswa ini
    $cek_query = "SELECT * FROM krs WHERE id_mahasiswa = $id_mahasiswa AND id_matkul = $id_matkul";
    $cek_result = mysqli_query($conn, $cek_query);

    if (mysqli_num_rows($cek_result) > 0) {
        $_SESSION['error'] = "Mata kuliah ini sudah diambil sebelumnya!";
        header("Location: ../mahasiswa/krs.php");
        exit();
    }

    // Cek jadwal bentrok
    $cek_bentrok_query = "SELECT mk.*
                          FROM krs k
                          JOIN mata_kuliah mk ON k.id_matkul = mk.id_matkul
                          WHERE k.id_mahasiswa = $id_mahasiswa
                          AND mk.hari = (SELECT hari FROM mata_kuliah WHERE id_matkul = $id_matkul)
                          AND (
                              (mk.jam_mulai <= (SELECT jam_mulai FROM mata_kuliah WHERE id_matkul = $id_matkul) 
                               AND mk.jam_selesai > (SELECT jam_mulai FROM mata_kuliah WHERE id_matkul = $id_matkul))
                              OR
                              (mk.jam_mulai < (SELECT jam_selesai FROM mata_kuliah WHERE id_matkul = $id_matkul) 
                               AND mk.jam_selesai >= (SELECT jam_selesai FROM mata_kuliah WHERE id_matkul = $id_matkul))
                          )";
    
    $cek_bentrok_result = mysqli_query($conn, $cek_bentrok_query);

    if (mysqli_num_rows($cek_bentrok_result) > 0) {
        $_SESSION['error'] = "Mata kuliah ini bentrok dengan jadwal yang sudah diambil!";
        header("Location: ../mahasiswa/krs.php");
        exit();
    }

    // Insert KRS jika tidak ada masalah
    $insert_query = "INSERT INTO krs (id_mahasiswa, id_matkul) VALUES ($id_mahasiswa, $id_matkul)";
    if (mysqli_query($conn, $insert_query)) {
        $_SESSION['success'] = "Mata kuliah berhasil diambil!";
    } else {
        $_SESSION['error'] = "Gagal mengambil mata kuliah!";
    }
    header("Location: ../mahasiswa/krs.php");
    exit();
}

// Hapus Mata Kuliah dari KRS
if (isset($_GET['hapus_krs'])) {
    $id_krs = intval($_GET['hapus_krs']);

    $delete_query = "DELETE FROM krs WHERE id_krs = $id_krs AND id_mahasiswa = $id_mahasiswa";
    if (mysqli_query($conn, $delete_query)) {
        $_SESSION['success'] = "Mata kuliah berhasil dihapus dari KRS!";
    } else {
        $_SESSION['error'] = "Gagal menghapus mata kuliah dari KRS!";
    }
    header("Location: ../mahasiswa/krs.php");
    exit();
}
