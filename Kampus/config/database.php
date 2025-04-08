<?php

$host = 'localhost';
$dbname = 'kampusdb';
$username = 'root'; // Ganti sesuai dengan username database Anda
$password = ''; // Ganti sesuai dengan password database Anda

// Koneksi ke database menggunakan MySQLi
$conn = mysqli_connect($host, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
} else {
    echo "";
}

?>