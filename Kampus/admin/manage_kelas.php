<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/header.php';
include '../config/database.php';

$matkul_result = mysqli_query($conn, "SELECT id_matkul, nama_matkul FROM mata_kuliah");
$kelas_result = mysqli_query($conn, "SELECT kelas_mk.*, mata_kuliah.nama_matkul FROM kelas_mk 
                                     JOIN mata_kuliah ON kelas_mk.id_matkul = mata_kuliah.id_matkul");
?>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-bold mb-4">Manajemen Kelas Mata Kuliah</h2>

    <a href="dashboard.php" class="mb-4 inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Kembali ke Dashboard</a>

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

    <form action="../controllers/kelasController.php" method="POST" class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <h3 class="text-xl font-semibold col-span-1 md:col-span-2">Tambah Kelas Baru</h3>

        <div>
            <label for="id_matkul" class="block text-gray-700">Mata Kuliah</label>
            <select name="id_matkul" id="id_matkul" required class="w-full px-3 py-2 border rounded">
                <option value="">-- Pilih Mata Kuliah --</option>
                <?php while ($row = mysqli_fetch_assoc($matkul_result)): ?>
                    <option value="<?= $row['id_matkul']; ?>"><?= $row['nama_matkul']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div>
            <label for="nama_kelas" class="block text-gray-700">Nama Kelas</label>
            <input type="text" name="nama_kelas" id="nama_kelas" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div>
            <label for="hari" class="block text-gray-700">Hari</label>
            <select name="hari" id="hari" class="w-full px-3 py-2 border rounded" required>
                <option value="">-- Pilih Hari --</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
            </select>
        </div>

        <div>
            <label for="jam_mulai" class="block text-gray-700">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div>
            <label for="jam_selesai" class="block text-gray-700">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div>
            <label for="ruangan" class="block text-gray-700">Ruangan</label>
            <input type="text" name="ruangan" id="ruangan" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="col-span-1 md:col-span-2">
            <button type="submit" name="tambah_kelas" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Tambah Kelas
            </button>
        </div>
    </form>

    <h3 class="text-xl font-semibold mb-4">Daftar Kelas</h3>
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Mata Kuliah</th>
                    <th class="border px-4 py-2">Nama Kelas</th>
                    <th class="border px-4 py-2">Hari</th>
                    <th class="border px-4 py-2">Jam</th>
                    <th class="border px-4 py-2">Ruangan</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($kelas = mysqli_fetch_assoc($kelas_result)): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= htmlspecialchars($kelas['nama_matkul']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($kelas['nama_kelas']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($kelas['hari']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($kelas['jam_mulai']); ?> - <?= htmlspecialchars($kelas['jam_selesai']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($kelas['ruangan']); ?></td>
                        <td class="border px-4 py-2 space-y-1 text-center">
                            <a href="edit_kelas.php?id=<?= $kelas['id_kelas']; ?>" class="block bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded mb-1">Edit</a>
                            <form action="../controllers/kelasController.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                <input type="hidden" name="hapus_kelas" value="<?= $kelas['id_kelas']; ?>">
                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
