<?php
session_start();
include '../config/database.php';
include '../includes/navbar.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Ambil semua mata kuliah dari database
$query = "SELECT mata_kuliah.*, dosen.nama AS nama_dosen 
          FROM mata_kuliah 
          LEFT JOIN dosen ON mata_kuliah.id_dosen = dosen.id_dosen";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mata Kuliah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <div class="w-full max-w-6xl bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Daftar Mata Kuliah</h2>

        <div class="mb-4 text-center">
            <a href="tambah_matkul.php" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Tambah Mata Kuliah</a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">Kode Mata Kuliah</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Mata Kuliah</th>
                    <th class="border border-gray-300 px-4 py-2">SKS</th>
                    <th class="border border-gray-300 px-4 py-2">Dosen Pengampu</th>
                    <th class="border border-gray-300 px-4 py-2">Semester</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr class="text-center">
                        <td class="border border-gray-300 px-4 py-2"><?php echo $row['kode_matkul']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $row['nama_matkul']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $row['sks']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $row['nama_dosen'] ? $row['nama_dosen'] : 'Belum Diatur'; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $row['semester']; ?></td>
                        <td class="border border-gray-300 px-4 py-2 space-x-2">
                            <a href="edit_matkul.php?id_matkul=<?php echo $row['id_matkul']; ?>" class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-600">Edit</a>
                          
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <div class="mt-6 text-center">
            <a href="dashboard.php" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
