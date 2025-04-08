<?php
session_start();
include '../config/database.php'; // Koneksi ke database

// **Cek apakah user adalah admin**
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// **Tambah Mata Kuliah**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_matkul'])) {
    $kode_matkul = mysqli_real_escape_string($conn, $_POST['kode_matkul']);
    $nama_matkul = mysqli_real_escape_string($conn, $_POST['nama_matkul']);
    $sks = intval($_POST['sks']);
    $semester = intval($_POST['semester']);

    // Cek apakah kode mata kuliah sudah ada
    $check_query = "SELECT * FROM mata_kuliah WHERE kode_matkul = '$kode_matkul'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "Kode mata kuliah sudah terdaftar!";
    } else {
        $insert_query = "INSERT INTO mata_kuliah (kode_matkul, nama_matkul, sks, semester) 
                         VALUES ('$kode_matkul', '$nama_matkul', '$sks', '$semester')";

        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['success'] = "Mata kuliah berhasil ditambahkan!";
        } else {
            $_SESSION['error'] = "Gagal menambahkan mata kuliah!";
        }
    }
    header("Location: ../admin/tambah_matkul.php");
    exit();
}
?>
