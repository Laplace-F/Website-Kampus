<?php
session_start();
include '../config/database.php'; // Koneksi ke database

// Cek apakah user adalah admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Tambah Mahasiswa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_mahasiswa'])) {
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $tahun_masuk = intval($_POST['tahun_masuk']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah NIM atau email sudah ada
    $check_query = "SELECT * FROM mahasiswa WHERE nim = '$nim' OR email = '$email'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "NIM atau Email mahasiswa sudah terdaftar!";
    } else {
        // Tambahkan ke tabel users
        $insert_user = "INSERT INTO users (email, password, role, nama) VALUES ('$email', '$hashed_password', 'mahasiswa', '$nama')";
        if (mysqli_query($conn, $insert_user)) {
            $id_user = mysqli_insert_id($conn);

            if ($id_user == 0) {
                $_SESSION['error'] = "ID user tidak valid setelah insert!";
                header("Location: ../admin/manage_mahasiswa.php");
                exit();
            }

            // Tambahkan ke tabel mahasiswa
            $insert_mahasiswa = "INSERT INTO mahasiswa (id_user, nim, nama, tahun_masuk, alamat, telepon, email, jurusan) 
                                 VALUES ('$id_user', '$nim', '$nama', '$tahun_masuk', '$alamat', '$telepon', '$email', '$jurusan')";

            if (mysqli_query($conn, $insert_mahasiswa)) {
                $_SESSION['success'] = "Mahasiswa berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Gagal menambahkan ke tabel mahasiswa! Error: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error'] = "Gagal menambahkan user ke tabel users! Error: " . mysqli_error($conn);
        }
    }

    header("Location: ../admin/manage_mahasiswa.php");
    exit();
}

// Edit Mahasiswa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_mahasiswa'])) {
    $id_mahasiswa = intval($_POST['id_mahasiswa']);
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $tahun_masuk = intval($_POST['tahun_masuk']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);

    $check_column_query = "SHOW COLUMNS FROM mahasiswa LIKE 'email'";
    $column_result = mysqli_query($conn, $check_column_query);

    if (mysqli_num_rows($column_result) == 0) {
        $_SESSION['error'] = "Kolom email tidak ditemukan di database!";
        header("Location: ../admin/manage_mahasiswa.php");
        exit();
    }

    $get_user_query = "SELECT id_user FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
    $user_result = mysqli_query($conn, $get_user_query);
    $user_data = mysqli_fetch_assoc($user_result);
    $id_user = $user_data['id_user'];

    $update_query = "UPDATE mahasiswa SET 
                        nim = '$nim', 
                        nama = '$nama', 
                        tahun_masuk = '$tahun_masuk', 
                        alamat = '$alamat', 
                        telepon = '$telepon', 
                        email = '$email',
                        jurusan = '$jurusan'
                    WHERE id_mahasiswa = $id_mahasiswa";

    $update_user_query = "UPDATE users SET 
                        email = '$email', 
                        nama = '$nama' 
                    WHERE id_user = $id_user";

    if (mysqli_query($conn, $update_query) && mysqli_query($conn, $update_user_query)) {
        $_SESSION['success'] = "Data mahasiswa berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "Gagal memperbarui data mahasiswa!";
    }
    header("Location: ../admin/manage_mahasiswa.php");
    exit();
}

// Hapus Mahasiswa
if (isset($_GET['hapus_mahasiswa'])) {
    $id_mahasiswa = intval($_GET['hapus_mahasiswa']);

    $get_user_query = "SELECT id_user FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
    $user_result = mysqli_query($conn, $get_user_query);
    $user_data = mysqli_fetch_assoc($user_result);
    $id_user = $user_data['id_user'];

    $delete_mahasiswa_query = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
    $delete_user_query = "DELETE FROM users WHERE id_user = $id_user";

    if (mysqli_query($conn, $delete_mahasiswa_query) && mysqli_query($conn, $delete_user_query)) {
        $_SESSION['success'] = "Mahasiswa berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus mahasiswa!";
    }

    header("Location: ../admin/manage_mahasiswa.php");
    exit();
}
?>
