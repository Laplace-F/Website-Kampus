-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 08, 2025 at 12:28 PM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u629342613_kampusdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `id_user`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `gelar` varchar(50) DEFAULT NULL,
  `lulusan` varchar(100) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `id_user`, `nik`, `nama`, `gelar`, `lulusan`, `telepon`, `email`, `created_at`) VALUES
(1, 2, '00000101', 'Arya Wicaksana', 'PhD', 'Universitas Multimedia Nusantara', '081234567899', 'arya@dosen.kampus.ac.id', '2025-03-18 13:33:14'),
(2, 3, '00000102', 'Sugeng', 'M.Sc', 'Universitas Indonesia', '08987654321', 'sugeng@dosen.kampus.ac.id', '2025-03-18 13:33:14'),
(3, 4, '00000103', 'Wirawan', 'S.T', 'Universitas Multimedia Nusantara', '08199887766', 'wirawan@dosen.kampus.ac.id', '2025-03-18 13:33:14'),
(11, 21, '00000104', 'Monica Pratiwi', 'S.pd', 'Universitas Multimedia Nusantara', '08822228281', 'dennis@dosen.kampus.ac.id', '2025-03-19 03:06:31'),
(13, 26, '00000105', 'Samuel', 'Phd', 'Universitas Multimedia Nusantara', '08228838444', 'samuel@dosen.kampus.ac.id', '2025-04-06 10:01:36'),
(15, 40, '00000106', 'Joko', 'Phd', 'Universitas Trisakti', '083223232', 'joko@dosen.kampus.ac.id', '2025-04-06 15:39:18'),
(16, 58, '00000107', 'anwar nasution', 'M.T', 'Pradita University', '01234567894', 'anwar@dosen.kampus.ac.id', '2025-04-07 09:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `kelas_mk`
--

CREATE TABLE `kelas_mk` (
  `id_kelas` int(11) NOT NULL,
  `id_matkul` int(11) DEFAULT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `hari` varchar(10) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `ruangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas_mk`
--

INSERT INTO `kelas_mk` (`id_kelas`, `id_matkul`, `nama_kelas`, `hari`, `jam_mulai`, `jam_selesai`, `ruangan`) VALUES
(5, 12, 'Kelas B', 'Rabu', '12:00:00', '13:00:00', 'D213'),
(6, 10, 'Kelas A', 'Senin', '14:00:00', '16:00:00', 'C121'),
(9, 16, 'Kelas D', 'Jumat', '15:00:00', '17:00:00', 'D323'),
(10, 13, 'Kelas A-LEN', 'Kamis', '15:00:00', '17:00:00', 'D454'),
(11, 17, 'Kelas E', 'Senin', '13:00:00', '15:00:00', 'D901'),
(12, 10, 'Kelas F', 'Selasa', '15:00:00', '17:00:00', 'C303'),
(13, 17, 'Kelas A', 'Selasa', '20:00:00', '22:00:00', 'D902'),
(14, 18, 'Kelas A', 'Rabu', '10:00:00', '12:00:00', 'C505'),
(15, 19, 'Kelas C', 'Jumat', '08:00:00', '10:00:00', 'D323'),
(16, 20, 'Kelas E', 'Selasa', '14:00:00', '16:00:00', 'D212'),
(17, 21, 'Kelas E', 'Rabu', '12:00:00', '15:00:00', 'C122'),
(18, 22, 'Kelas A-LEN', 'Kamis', '14:00:00', '17:00:00', 'B512'),
(19, 23, 'Kelas A', 'Selasa', '08:00:00', '11:00:00', 'B612'),
(20, 24, 'Kelas A', 'Jumat', '23:00:00', '14:00:00', 'B612');

-- --------------------------------------------------------

--
-- Table structure for table `krs`
--

CREATE TABLE `krs` (
  `id_krs` int(11) NOT NULL,
  `id_mahasiswa` int(11) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `krs`
--

INSERT INTO `krs` (`id_krs`, `id_mahasiswa`, `id_kelas`, `created_at`) VALUES
(4, 1, 5, '2025-04-05 17:05:49'),
(5, 1, 6, '2025-04-05 17:09:47'),
(6, 3, 9, '2025-04-05 18:25:14'),
(7, 3, 6, '2025-04-05 18:25:21'),
(8, 3, 5, '2025-04-05 18:25:22'),
(9, 1, 9, '2025-04-05 18:32:28'),
(10, 12, 6, '2025-04-06 05:43:46'),
(11, 12, 5, '2025-04-06 05:43:57'),
(12, 12, 13, '2025-04-06 10:16:17'),
(13, 12, 10, '2025-04-06 10:16:22'),
(14, 24, 5, '2025-04-06 16:18:35'),
(15, 24, 6, '2025-04-06 16:18:36'),
(16, 24, 16, '2025-04-06 16:18:38'),
(17, 24, 14, '2025-04-06 16:18:40'),
(18, 24, 18, '2025-04-06 16:18:45'),
(19, 24, 9, '2025-04-06 16:18:55'),
(20, 1, 16, '2025-04-07 09:28:29'),
(21, 1, 18, '2025-04-07 09:28:37'),
(22, 1, 15, '2025-04-07 15:44:49'),
(23, 1, 13, '2025-04-07 15:44:59'),
(24, 1, 14, '2025-04-07 15:45:00'),
(25, 1, 19, '2025-04-07 15:45:08'),
(26, 1, 20, '2025-04-07 15:50:48');

-- --------------------------------------------------------

--
-- Table structure for table `krs_backup`
--

CREATE TABLE `krs_backup` (
  `id_krs` int(11) NOT NULL DEFAULT 0,
  `id_mahasiswa` int(11) NOT NULL,
  `id_matkul` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `ruangan` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `krs_backup`
--

INSERT INTO `krs_backup` (`id_krs`, `id_mahasiswa`, `id_matkul`, `id_dosen`, `hari`, `ruangan`, `created_at`) VALUES
(22, 1, 10, 2, 'Senin', NULL, '2025-03-28 08:36:38'),
(23, 2, 10, 2, 'Senin', NULL, '2025-03-28 08:36:38'),
(24, 3, 10, 2, 'Senin', NULL, '2025-03-28 08:36:38'),
(25, 9, 10, 2, 'Senin', NULL, '2025-03-28 08:36:38'),
(26, 10, 10, 2, 'Senin', NULL, '2025-03-28 08:36:38'),
(28, 2, 11, 3, 'Senin', NULL, '2025-03-28 08:37:02'),
(29, 3, 11, 3, 'Senin', NULL, '2025-03-28 08:37:02'),
(30, 9, 11, 3, 'Senin', NULL, '2025-03-28 08:37:02'),
(31, 10, 11, 3, 'Senin', NULL, '2025-03-28 08:37:02'),
(32, 1, 11, 3, 'Senin', NULL, '2025-03-28 08:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_jadwal`
--

CREATE TABLE `laporan_jadwal` (
  `id_laporan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `role` enum('dosen','mahasiswa') NOT NULL,
  `jadwal` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_jadwal`
--

INSERT INTO `laporan_jadwal` (`id_laporan`, `id_user`, `role`, `jadwal`, `created_at`) VALUES
(1, 2, 'dosen', '{\"mata_kuliah\": \"Pemrograman Web\", \"hari\": \"Senin\", \"ruangan\": \"R101\"}', '2025-03-18 13:35:46'),
(2, 5, 'mahasiswa', '{\"mata_kuliah\": \"Jaringan Komputer\", \"hari\": \"Selasa\", \"ruangan\": \"R102\"}', '2025-03-18 13:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `aktivitas` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `id_user`, `aktivitas`, `timestamp`) VALUES
(1, 1, 'Login ke sistem', '2025-03-18 13:35:48'),
(2, 2, 'Melihat jadwal kuliah', '2025-03-18 13:35:48'),
(3, 5, 'Mengisi KRS', '2025-03-18 13:35:48');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `tahun_masuk` year(4) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `id_user`, `nim`, `nama`, `jurusan`, `tahun_masuk`, `alamat`, `telepon`, `email`, `created_at`) VALUES
(1, 5, '2201010003', 'Adam Lincoln', 'Teknik Komputer', '2022', 'Jl Kp Dukuh', '08123456701', 'adam@student.kampus.ac.id', '2025-03-18 13:33:14'),
(2, 6, '2201010004', 'Harun', 'Teknik Komputer', '2023', 'Jl. Kampus No.2', '08123456702', 'harun@student.kampus.ac.id', '2025-03-18 13:33:14'),
(3, 7, '2201010005', 'Andi', 'Sistem Informasi', '2022', 'Jl. Kampus No.3', '08123456703', 'andi@student.kampus.ac.id', '2025-03-18 13:33:14'),
(9, 19, '2201010006', 'Beta', 'Teknik Komputer', '2025', 'Jalan Diponegoro', '08222819981', 'beta@student.kampus.ac.id', '2025-03-18 15:57:03'),
(10, 22, '2201010007', 'Atta Halilintar', 'Informatika', '2021', 'Jalan Jalan', '083374426767', 'atta@student.kampus.ac.id', '2025-03-20 03:31:43'),
(12, 25, '2201010008', 'Agung', 'Teknik Komputer', '2023', 'Jalan Boulvard', '0822733328', 'agung@student.kampus.ac.id', '2025-04-06 05:41:48'),
(13, 28, '2201010001', 'Aditya Pratama', 'Sistem Informasi', '2022', '	Jl. Melati No. 10', '081234567801', 'aditya.pratama@email.com', '2025-04-06 13:20:28'),
(14, 29, '2201010002', '	Bella Anindya	', 'Sistem Informasi', '2023', 'Jl. Kenanga No. 15', '081234564545', 'bella.anindya@email.com', '2025-04-06 13:21:12'),
(15, 30, '2201010009', 'Intan Permatasari', 'Teknik Elektro', '2023', 'Jl. Teratai No. 9', '081234567809', 'intan.p@email.com', '2025-04-06 13:24:45'),
(16, 31, '2201010010', '	Joko Santoso', 'Teknik Elektro', '2023', 'Jl. Kamboja No. 4', '081234567810', 'joko.s@email.com', '2025-04-06 13:27:48'),
(17, 32, '2201010011', 'Karina Putri', 'Informatika', '2020', 'Jl. Nusa Indah No. 18', '081234567811', 'karina.p@email.com', '2025-04-06 13:28:21'),
(18, 33, '2201010012', '	Lukman Hakim', 'DKV', '2022', '	Jl. Merpati No. 2', '081234567812', 'lukman.hakim@student.kampus.ac.id', '2025-04-06 13:29:49'),
(19, 34, '2201010013', '	Maya Puspita', 'DKV', '2021', 'Jl. Rajawali No. 17', '081234567813', 'maya.puspita@student.kampus.ac.id', '2025-04-06 13:30:52'),
(20, 35, '2201010014', 'Nugroho Prasetyo', 'Teknik Komputer', '2020', 'Jl. Garuda No. 13', '081234567814', 'nugroho.prasetyo@student.kampus.ac.id', '2025-04-06 13:31:30'),
(21, 36, '2201010015', 'Olivia Kartik', 'Sistem Informasi', '2023', 'Jl. Kenari No. 25', '081234567815', 'olivia.kartika@student.kampus.ac.id', '2025-04-06 13:32:17'),
(22, 39, ' 	2201010016', 'Yasona Laoli', 'Teknik Elektro', '2023', 'Jl. Garuda No. 13', '081234567809', 'yasona@student.kampus.ac.id', '2025-04-06 15:35:49'),
(23, 41, '2201010017', 'Dimas Prasetyo', 'Sistem Informasi', '2022', 'Jl. Mawar No. 17', '081234567017', 'dimas.prasetyo@student.kampus.ac.id', '2025-04-06 15:55:40'),
(24, 42, '2201010018', 'Ignatius Rayden Indigo Regantha', 'Teknik Komputer', '2023', 'Jalan Boulvard', '082273316767', 'ignatius.rayden@student.kampus.ac.id', '2025-04-06 15:56:47'),
(25, 43, '2201010019', 'Aldi Saputra', 'DKV', '2022', 'Jl. Kenanga No. 19', '081234567019', 'aldi.saputra@student.kampus.ac.id', '2025-04-06 15:57:29'),
(26, 44, '2201010020', '	Siska Ayu', 'Teknik Kimia', '2022', 'Jl. Anggrek No. 20', '081234567020', 'siska.ayu@student.kampus.ac.id', '2025-04-06 16:01:40'),
(27, 45, '2201010021', '	Rizky Fadilah', 'Sistem Informasi', '2022', 'Jl. Dahlia No. 21', '081234567021', 'rizky.f@student.kampus.ac.id', '2025-04-06 16:02:25'),
(28, 46, '2201010022', '	Nanda Febrian', 'Teknik Elektro', '2022', 'Jl. Cemara No. 22', '081234567022', 'nanda.f@student.kampus.ac.id', '2025-04-06 16:03:03'),
(29, 47, '2201010023', 'Wulan Ramadhani', 'Teknik Elektro', '2022', 'Jl. Merpati No. 23', '081234567023', 'wulan.r@student.kampus.ac.id', '2025-04-06 16:03:38'),
(30, 48, '2201010024', 'Budi Santoso', 'Sistem Informasi', '2022', 'Jl. Rajawali No. 24', '081234567024', 'budi.s@student.kampus.ac.id', '2025-04-06 16:04:19'),
(31, 49, '2201010025', '	Siti Aisyah', 'Informatika', '2022', 'Jl. Nangka No. 25', '081234567025', 'siti.aisyah@student.kampus.ac.id', '2025-04-06 16:04:57'),
(32, 50, '2201010026	', '	Andi Kurniawan', 'Informatika', '2022', 'Jl. Durian No. 26', '081234567026', 'andi.k@student.kampus.ac.id', '2025-04-06 16:05:33'),
(33, 51, '2201010027', '	Lilis Suryani', 'DKV', '2022', 'Jl. Jeruk No. 27', '081234567027', 'lilis.s@student.kampus.ac.id', '2025-04-06 16:06:04'),
(34, 52, '2201010028', 'Fajar Nugroho', 'DKV', '2022', '	Jl. Mangga No. 28', '081234567028', 'fajar.n@student.kampus.ac.id', '2025-04-06 16:06:37'),
(35, 53, '2201010029', 'Dewi Sartika', 'Teknik Kimia', '2022', '	Jl. Pepaya No. 29', '081234567029', 'dewi.s@student.kampus.ac.id', '2025-04-06 16:07:11'),
(36, 54, '2201010030', 'Riko Setiawan', 'Informatika', '2022', 'Jl. Apel No. 30', '081234567030', 'riko.setiawan@student.kampus.ac.id', '2025-04-06 16:07:53');

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id_matkul` int(11) NOT NULL,
  `kode_matkul` varchar(20) NOT NULL,
  `nama_matkul` varchar(255) NOT NULL,
  `sks` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_kelas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id_matkul`, `kode_matkul`, `nama_matkul`, `sks`, `id_dosen`, `semester`, `created_at`, `id_kelas`) VALUES
(10, 'CM211', 'Civic', 2, 2, 2, '2025-03-28 08:17:40', 1),
(12, 'UM123', 'Religion', 2, 15, 3, '2025-04-03 12:59:19', 3),
(13, 'CM2112', 'Arsikom', 3, 11, 5, '2025-04-03 13:02:59', 4),
(16, 'IF4322', 'Database System', 2, 1, 3, '2025-04-05 17:41:08', NULL),
(17, 'CNM123', 'Computer Network Management', 2, 13, 3, '2025-04-06 10:00:50', NULL),
(18, 'IF330', 'Web Programming', 3, 3, 4, '2025-04-06 15:37:31', NULL),
(19, 'IF100', 'Programming Fundamental', 2, 1, 1, '2025-04-06 15:40:34', NULL),
(20, 'UM212', 'English 2', 2, 2, 3, '2025-04-06 15:41:18', NULL),
(21, 'UM213', 'English 3', 2, 15, 4, '2025-04-06 15:41:49', NULL),
(22, 'IF555', 'OOP', 3, 3, 3, '2025-04-06 15:42:23', NULL),
(23, 'CE 631', 'Interaktif AI', 3, 16, 6, '2025-04-07 09:16:25', NULL),
(24, 'CE 661', 'Desain Data', 2, 11, 5, '2025-04-07 15:46:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dosen','mahasiswa') NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `role`, `nama`, `created_at`) VALUES
(1, 'admin@admin.kampus.ac.id', 'admin123', 'admin', 'admin', '2025-03-18 13:33:14'),
(2, 'arya@dosen.kampus.ac.id', 'rahasiadunia123', 'dosen', 'Arya Wicaksana', '2025-03-18 13:33:14'),
(3, 'sugeng@dosen.kampus.ac.id', 'hashedpassword', 'dosen', 'Sugeng', '2025-03-18 13:33:14'),
(4, 'wirawan@dosen.kampus.ac.id', 'hashedpassword', 'dosen', 'Wirawan', '2025-03-18 13:33:14'),
(5, 'adam@student.kampus.ac.id', 'adamlovenovi123', 'mahasiswa', 'Adam Lincoln', '2025-03-18 13:33:14'),
(6, 'harun@student.kampus.ac.id', 'hashedpassword', 'mahasiswa', 'Harun', '2025-03-18 13:33:14'),
(7, 'andi@student.kampus.ac.id', 'hashedpassword', 'mahasiswa', 'Andi', '2025-03-18 13:33:14'),
(19, 'beta@student.kampus.ac.id', 'hashedpassword', 'mahasiswa', 'Beta', '2025-03-18 15:57:03'),
(21, 'dennis@dosen.kampus.ac.id', 'hashedpassword\r\n', 'dosen', 'Monica Pratiwi', '2025-03-19 03:06:31'),
(22, 'atta@student.kampus.ac.id', 'hashedpassword', 'mahasiswa', 'Atta Halilintar', '2025-03-20 03:31:43'),
(25, 'agung@student.kampus.ac.id', 'agung', 'mahasiswa', 'Agung', '2025-04-06 05:41:48'),
(26, 'samuel@dosen.kampus.ac.id', 'samuel123', 'dosen', 'Samuel', '2025-04-06 10:01:36'),
(28, 'aditya.pratama@email.com', 'hashedpassword', 'mahasiswa', 'Aditya Pratama', '2025-04-06 13:20:28'),
(29, 'bella.anindya@email.com', 'hashedpassword', 'mahasiswa', '	Bella Anindya	', '2025-04-06 13:21:12'),
(30, 'intan.p@email.com', 'hashedpassword', 'mahasiswa', 'Intan Permatasari', '2025-04-06 13:24:45'),
(31, 'joko.s@email.com', 'hashedpassword', 'mahasiswa', '	Joko Santoso', '2025-04-06 13:27:48'),
(32, 'karina.p@email.com', 'hashedpassword', 'mahasiswa', 'Karina Putri', '2025-04-06 13:28:21'),
(33, 'lukman.hakim@student.kampus.ac.id', 'hashedpassword', 'mahasiswa', '	Lukman Hakim', '2025-04-06 13:29:49'),
(34, 'maya.puspita@student.kampus.ac.id', 'password123', 'mahasiswa', '	Maya Puspita', '2025-04-06 13:30:52'),
(35, 'nugroho.prasetyo@student.kampus.ac.id', 'hashedpassword', 'mahasiswa', 'Nugroho Prasetyo', '2025-04-06 13:31:30'),
(36, 'olivia.kartika@student.kampus.ac.id', 'hashedpassword', 'mahasiswa', 'Olivia Kartik', '2025-04-06 13:32:17'),
(39, 'yasona@student.kampus.ac.id', 'qwerty123', 'mahasiswa', 'Yasona Laoli', '2025-04-06 15:35:49'),
(40, 'joko@dosen.kampus.ac.id', 'rahasia456', 'dosen', 'Joko', '2025-04-06 15:39:18'),
(41, 'dimas.prasetyo@student.kampus.ac.id', 'qwerty123', 'mahasiswa', 'Dimas Prasetyo', '2025-04-06 15:55:40'),
(42, 'ignatius.rayden@student.kampus.ac.id', 'rahasia456', 'mahasiswa', 'Ignatius Rayden Indigo Regantha', '2025-04-06 15:56:47'),
(43, 'aldi.saputra@student.kampus.ac.id', 'rahasia456', 'mahasiswa', 'Aldi Saputra', '2025-04-06 15:57:29'),
(44, 'siska.ayu@student.kampus.ac.id', 'qwerty123', 'mahasiswa', '	Siska Ayu', '2025-04-06 16:01:40'),
(45, 'rizky.f@student.kampus.ac.id', 'qwerty123', 'mahasiswa', '	Rizky Fadilah', '2025-04-06 16:02:25'),
(46, 'nanda.f@student.kampus.ac.id', 'qwerty123', 'mahasiswa', '	Nanda Febrian', '2025-04-06 16:03:03'),
(47, 'wulan.r@student.kampus.ac.id', 'password123', 'mahasiswa', 'Wulan Ramadhani', '2025-04-06 16:03:38'),
(48, 'budi.s@student.kampus.ac.id', 'qwerty123', 'mahasiswa', 'Budi Santoso', '2025-04-06 16:04:19'),
(49, 'siti.aisyah@student.kampus.ac.id', 'password123', 'mahasiswa', '	Siti Aisyah', '2025-04-06 16:04:57'),
(50, 'andi.k@student.kampus.ac.id', 'qwerty123', 'mahasiswa', '	Andi Kurniawan', '2025-04-06 16:05:33'),
(51, 'lilis.s@student.kampus.ac.id', 'password123', 'mahasiswa', '	Lilis Suryani', '2025-04-06 16:06:04'),
(52, 'fajar.n@student.kampus.ac.id', 'rahasia456', 'mahasiswa', 'Fajar Nugroho', '2025-04-06 16:06:37'),
(53, 'dewi.s@student.kampus.ac.id', 'qwerty123', 'mahasiswa', 'Dewi Sartika', '2025-04-06 16:07:11'),
(54, 'riko.setiawan@student.kampus.ac.id', 'rahasia456', 'mahasiswa', 'Riko Setiawan', '2025-04-06 16:07:53'),
(58, 'anwar@dosen.kampus.ac.id', '$2y$10$fTBiSqYH48jau1VXbsv76.yf.KNDLLp8FwxxbGUnzQuffd26wCc0S', 'dosen', 'anwar nasution', '2025-04-07 09:13:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `kelas_mk`
--
ALTER TABLE `kelas_mk`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_matkul` (`id_matkul`);

--
-- Indexes for table `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`id_krs`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `laporan_jadwal`
--
ALTER TABLE `laporan_jadwal`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id_matkul`),
  ADD UNIQUE KEY `kode_matkul` (`kode_matkul`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kelas_mk`
--
ALTER TABLE `kelas_mk`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `krs`
--
ALTER TABLE `krs`
  MODIFY `id_krs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `laporan_jadwal`
--
ALTER TABLE `laporan_jadwal`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `id_matkul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `kelas_mk`
--
ALTER TABLE `kelas_mk`
  ADD CONSTRAINT `kelas_mk_ibfk_1` FOREIGN KEY (`id_matkul`) REFERENCES `mata_kuliah` (`id_matkul`);

--
-- Constraints for table `krs`
--
ALTER TABLE `krs`
  ADD CONSTRAINT `krs_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`),
  ADD CONSTRAINT `krs_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas_mk` (`id_kelas`);

--
-- Constraints for table `laporan_jadwal`
--
ALTER TABLE `laporan_jadwal`
  ADD CONSTRAINT `laporan_jadwal_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
