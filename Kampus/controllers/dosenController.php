<?php
session_start();
include '../config/database.php'; // Koneksi ke database

// **Cek apakah user adalah admin**
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// **Tambah Dosen**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_dosen'])) {
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $gelar = mysqli_real_escape_string($conn, $_POST['gelar']);
    $lulusan = mysqli_real_escape_string($conn, $_POST['lulusan']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash password sebelum disimpan

    // Cek apakah email atau NIK sudah ada di database
    $check_query = "SELECT * FROM dosen WHERE nik = '$nik' OR email = '$email'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "NIK atau Email dosen sudah terdaftar!";
    } else {
        // **1. Tambahkan user ke tabel users terlebih dahulu**
        $insert_user = "INSERT INTO users (email, password, role, nama) VALUES ('$email', '$hashed_password', 'dosen', '$nama')";
        if (mysqli_query($conn, $insert_user)) {
            $id_user = mysqli_insert_id($conn); // Ambil ID user yang baru saja dibuat

            // **2. Tambahkan dosen ke tabel dosen dengan id_user yang baru dibuat**
            $insert_dosen = "INSERT INTO dosen (id_user, nik, nama, gelar, lulusan, telepon, email) 
                             VALUES ('$id_user', '$nik', '$nama', '$gelar', '$lulusan', '$telepon', '$email')";

            if (mysqli_query($conn, $insert_dosen)) {
                $_SESSION['success'] = "Dosen berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Gagal menambahkan dosen ke tabel dosen!";
            }
        } else {
            $_SESSION['error'] = "Gagal menambahkan user ke tabel users!";
        }
    }
    header("Location: ../admin/manage_dosen.php");
    exit();
}

// **Edit Dosen**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_dosen'])) {
    $id_dosen = intval($_POST['id_dosen']);
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $gelar = mysqli_real_escape_string($conn, $_POST['gelar']);
    $lulusan = mysqli_real_escape_string($conn, $_POST['lulusan']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Ambil id_user yang terkait dengan dosen ini
    $get_user_query = "SELECT id_user FROM dosen WHERE id_dosen = $id_dosen";
    $user_result = mysqli_query($conn, $get_user_query);
    $user_data = mysqli_fetch_assoc($user_result);
    $id_user = $user_data['id_user'];

    // Update data dosen
    $update_query = "UPDATE dosen SET 
                        nik = '$nik', 
                        nama = '$nama', 
                        gelar = '$gelar', 
                        lulusan = '$lulusan', 
                        telepon = '$telepon', 
                        email = '$email' 
                    WHERE id_dosen = $id_dosen";

    // Update juga di tabel users
    $update_user_query = "UPDATE users SET 
                        email = '$email', 
                        nama = '$nama' 
                    WHERE id_user = $id_user";

    if (mysqli_query($conn, $update_query) && mysqli_query($conn, $update_user_query)) {
        $_SESSION['success'] = "Data dosen berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "Gagal memperbarui data dosen!";
    }
    header("Location: ../admin/manage_dosen.php");
    exit();
}

// **Hapus Dosen**
if (isset($_GET['hapus_dosen'])) {
    $id_dosen = intval($_GET['hapus_dosen']);

    // Ambil id_user sebelum menghapus dosen
    $get_user_query = "SELECT id_user FROM dosen WHERE id_dosen = $id_dosen";
    $user_result = mysqli_query($conn, $get_user_query);
    $user_data = mysqli_fetch_assoc($user_result);
    $id_user = $user_data['id_user'];

    // Hapus dosen dari tabel dosen
    $delete_dosen_query = "DELETE FROM dosen WHERE id_dosen = $id_dosen";
    $delete_user_query = "DELETE FROM users WHERE id_user = $id_user";

    if (mysqli_query($conn, $delete_dosen_query) && mysqli_query($conn, $delete_user_query)) {
        $_SESSION['success'] = "Dosen berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus dosen!";
    }
    header("Location: ../admin/manage_dosen.php");
    exit();
}
?>
