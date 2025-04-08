<?php
session_start();
include '../config/database.php';

// Tambah kelas baru
if (isset($_POST['tambah_kelas'])) {
    $id_matkul   = $_POST['id_matkul'];
    $nama_kelas  = $_POST['nama_kelas'];
    $hari        = $_POST['hari'];
    $jam_mulai   = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $ruangan     = $_POST['ruangan'];

    $stmt = $conn->prepare("INSERT INTO kelas_mk (id_matkul, nama_kelas, hari, jam_mulai, jam_selesai, ruangan) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $id_matkul, $nama_kelas, $hari, $jam_mulai, $jam_selesai, $ruangan);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Kelas berhasil ditambahkan.";
    } else {
        $_SESSION['error'] = "Gagal menambahkan kelas.";
    }

    $stmt->close();
    header("Location: ../admin/manage_kelas.php");
    exit();
}

// Update kelas
if (isset($_POST['update_kelas'])) {
    $id_kelas    = $_POST['id_kelas'];
    $id_matkul   = $_POST['id_matkul'];
    $nama_kelas  = $_POST['nama_kelas'];
    $hari        = $_POST['hari'];
    $jam_mulai   = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $ruangan     = $_POST['ruangan'];

    $stmt = $conn->prepare("UPDATE kelas_mk SET id_matkul = ?, nama_kelas = ?, hari = ?, jam_mulai = ?, jam_selesai = ?, ruangan = ? WHERE id_kelas = ?");
    $stmt->bind_param("isssssi", $id_matkul, $nama_kelas, $hari, $jam_mulai, $jam_selesai, $ruangan, $id_kelas);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Kelas berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui kelas.";
    }

    $stmt->close();
    header("Location: ../admin/manage_kelas.php");
    exit();
}

// Hapus kelas
if (isset($_POST['hapus_kelas'])) {
    $id_kelas = $_POST['hapus_kelas'];

    $stmt = $conn->prepare("DELETE FROM kelas_mk WHERE id_kelas = ?");
    $stmt->bind_param("i", $id_kelas);

    try {
        if ($stmt->execute()) {
            $_SESSION['success'] = "Kelas berhasil dihapus.";
        } else {
            $_SESSION['error'] = "Gagal menghapus kelas.";
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['error'] = "Tidak dapat menghapus kelas karena masih digunakan oleh mahasiswa di KRS.";
    }

    $stmt->close();
    header("Location: ../admin/manage_kelas.php");
    exit();
}
