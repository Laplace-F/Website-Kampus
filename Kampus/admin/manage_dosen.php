<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Ambil data dosen dari database
$query = "SELECT * FROM dosen";
$result = mysqli_query($conn, $query);

include '../includes/header.php';
?>

<div class="w-full max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md mt-8">
    <h2 class="text-2xl font-bold text-center mb-4">Kelola Dosen</h2>
    <a href="dashboard.php" class="mb-4 inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Kembali ke Dashboard</a>
    
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-300 mt-4 text-sm sm:text-base">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">NIK</th>
                    <th class="border border-gray-300 px-4 py-2">Nama</th>
                    <th class="border border-gray-300 px-4 py-2">Gelar</th>
                    <th class="border border-gray-300 px-4 py-2">Lulusan</th>
                    <th class="border border-gray-300 px-4 py-2">Telepon</th>
                    <th class="border border-gray-300 px-4 py-2">Tanggal Input</th>
                    <th class="border border-gray-300 px-4 py-2">User Input</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($dosen = mysqli_fetch_assoc($result)) { ?>
                    <tr class="text-center">
                        <td class="border border-gray-300 px-4 py-2"><?php echo $dosen['nik']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $dosen['nama']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $dosen['gelar']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $dosen['lulusan']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $dosen['telepon']; ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <?php echo date('d-m-Y H:i', strtotime($dosen['created_at'])); ?>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">admin</td>
                        <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">
                            <a href="edit_dosen.php?id=<?php echo $dosen['id_dosen']; ?>" class="text-blue-500">Edit</a> |
                            <a href="delete_dosen.php?id=<?= $dosen['id_dosen']; ?>" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus dosen ini?');"
                                class="text-red-500 hover:text-red-700">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6 text-center">
        <a href="tambah_dosen.php" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Tambah Dosen</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
