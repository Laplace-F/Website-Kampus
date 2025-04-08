<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config/database.php';
include '../includes/header.php';

// Ambil data mata kuliah
$query = "SELECT mata_kuliah.*, dosen.nama AS nama_dosen 
          FROM mata_kuliah 
          LEFT JOIN dosen ON mata_kuliah.id_dosen = dosen.id_dosen";
$result = mysqli_query($conn, $query);
?>

<div class="container mx-auto p-4 sm:p-6">
    <h2 class="text-2xl font-bold mb-4 text-center sm:text-left">Manage Mata Kuliah</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm sm:text-base">
            <?= htmlspecialchars($_SESSION['success']); ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm sm:text-base">
            <?= htmlspecialchars($_SESSION['error']); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto mb-4 border-collapse border border-gray-300 text-sm sm:text-base">
            <thead>
                <tr class="bg-gray-200 text-center">
                    <th class="border px-4 py-2">Kode</th>
                    <th class="border px-4 py-2">Nama Mata Kuliah</th>
                    <th class="border px-4 py-2">SKS</th>
                    <th class="border px-4 py-2">Semester</th>
                    <th class="border px-4 py-2">Dosen Pengampu</th>
                    <th class="border px-4 py-2">Kelas</th>
                    <th class="border px-4 py-2">Tanggal Input</th>
                    <th class="border px-4 py-2">User Input</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                        $id_matkul = $row['id_matkul'];
                        $kelas_query = "SELECT * FROM kelas_mk WHERE id_matkul = $id_matkul";
                        $kelas_result = mysqli_query($conn, $kelas_query);
                        $kelas_list = [];

                        while ($kelas = mysqli_fetch_assoc($kelas_result)) {
                            $kelas_list[] = "{$kelas['nama_kelas']}: {$kelas['hari']} ({$kelas['jam_mulai']} - {$kelas['jam_selesai']}) di {$kelas['ruangan']}";
                        }

                        $kelas_output = !empty($kelas_list) ? implode('<br>', $kelas_list) : '<span class="text-gray-500 italic">Belum ada kelas</span>';
                    ?>
                    <tr class="text-center">
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['kode_matkul']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_matkul']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['sks']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['semester']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_dosen'] ?? 'Belum Diampu'); ?></td>
                        <td class="border px-4 py-2 text-left"><?= $kelas_output; ?></td>
                        <td class="border px-4 py-2"><?= date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
                        <td class="border px-4 py-2">admin</td>
                        <td class="border px-4 py-2">
                            <a href="edit_matkul.php?id=<?= $row['id_matkul']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                            <form action="../controllers/matkulController.php" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus mata kuliah ini?')">
                                <input type="hidden" name="hapus_matkul" value="<?= $row['id_matkul']; ?>">
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="flex flex-col sm:flex-row gap-4">
        <a href="tambah_matkul.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-center">Tambah Mata Kuliah</a>
        <a href="dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-center">Kembali ke Dashboard</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
