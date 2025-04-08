<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config/database.php';
include '../includes/header.php';

// Ambil data KRS dari database
$query = "SELECT 
            krs.id_krs,
            mahasiswa.nama AS nama_mahasiswa,
            mahasiswa.nim,
            mata_kuliah.nama_matkul,
            mata_kuliah.kode_matkul,
            dosen.nama AS nama_dosen,
            mata_kuliah.hari,
            mata_kuliah.jam,
            mata_kuliah.ruangan
          FROM krs
          JOIN mahasiswa ON krs.id_mahasiswa = mahasiswa.id_mahasiswa
          JOIN mata_kuliah ON krs.id_matkul = mata_kuliah.id_matkul
          JOIN dosen ON mata_kuliah.id_dosen = dosen.id_dosen
          ORDER BY krs.id_krs DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Manage KRS (Seluruh Data)</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['success']); ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <table class="table-auto w-full mb-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">ID KRS</th>
                <th class="border px-4 py-2">Nama Mahasiswa</th>
                <th class="border px-4 py-2">NIM</th>
                <th class="border px-4 py-2">Kode Mata Kuliah</th>
                <th class="border px-4 py-2">Nama Mata Kuliah</th>
                <th class="border px-4 py-2">Dosen Pengampu</th>
                <th class="border px-4 py-2">Hari</th>
                <th class="border px-4 py-2">Jam</th>
                <th class="border px-4 py-2">Ruangan</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['id_krs']); ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_mahasiswa']); ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['nim']); ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['kode_matkul']); ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_matkul']); ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_dosen']); ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['hari']); ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['jam']); ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($row['ruangan']); ?></td>
                    <td class="border px-4 py-2">
                        <a href="edit_krs.php?id=<?= $row['id_krs']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                        <a href="../controllers/krsController.php?hapus_krs=<?= $row['id_krs']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus data KRS ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
