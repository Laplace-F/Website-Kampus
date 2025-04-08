<?php
session_start();
include '../config/database.php';

// Cek apakah user adalah admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// ==================== TAMBAH MATA KULIAH ====================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_matkul'])) {
    $kode_matkul = mysqli_real_escape_string($conn, $_POST['kode_matkul']);
    $nama_matkul = mysqli_real_escape_string($conn, $_POST['nama_matkul']);
    $id_dosen = intval($_POST['id_dosen']);
    $sks = intval($_POST['sks']);
    $semester = intval($_POST['semester']);

    // Cek apakah kode mata kuliah sudah ada
    $check_query = "SELECT * FROM mata_kuliah WHERE kode_matkul = '$kode_matkul'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "Kode mata kuliah sudah terdaftar!";
    } else {
        $insert_query = "INSERT INTO mata_kuliah (kode_matkul, nama_matkul, sks, semester, id_dosen) 
                         VALUES ('$kode_matkul', '$nama_matkul', '$sks', '$semester', '$id_dosen')";
        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['success'] = "Mata kuliah berhasil ditambahkan!";
        } else {
            $_SESSION['error'] = "Gagal menambahkan mata kuliah!";
        }
    }

    header("Location: ../admin/manage_matkul.php");
    exit();
}

// ==================== EDIT MATA KULIAH ====================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_matkul'])) {
    $id_matkul = intval($_POST['id_matkul']);
    $kode_matkul = mysqli_real_escape_string($conn, $_POST['kode_matkul']);
    $nama_matkul = mysqli_real_escape_string($conn, $_POST['nama_matkul']);
    $sks = intval($_POST['sks']);
    $semester = intval($_POST['semester']);
    $id_dosen = intval($_POST['id_dosen']);

    $update_query = "UPDATE mata_kuliah SET 
                        kode_matkul = '$kode_matkul', 
                        nama_matkul = '$nama_matkul', 
                        sks = '$sks', 
                        semester = '$semester',
                        id_dosen = '$id_dosen'
                    WHERE id_matkul = $id_matkul";

    if (mysqli_query($conn, $update_query)) {
        $_SESSION['success'] = "Data mata kuliah berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "Gagal memperbarui data mata kuliah!";
    }

    header("Location: ../admin/manage_matkul.php");
    exit();
}

// ==================== HAPUS MATA KULIAH (PAKAI POST) ====================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hapus_matkul'])) {
    $id_matkul = intval($_POST['hapus_matkul']);

    // Pertama hapus kelas terkait (jika ada foreign key constraint)
    $delete_kelas = "DELETE FROM kelas_mk WHERE id_matkul = $id_matkul";
    mysqli_query($conn, $delete_kelas); // Hapus kelas terlebih dahulu

    $delete_query = "DELETE FROM mata_kuliah WHERE id_matkul = $id_matkul";
    if (mysqli_query($conn, $delete_query)) {
        $_SESSION['success'] = "Mata kuliah berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus mata kuliah. Pastikan tidak ada data yang terkait.";
    }

    header("Location: ../admin/manage_matkul.php");
    exit();
}
