<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config/database.php';
include '../includes/header.php';

// Ambil ID Kelas dari parameter GET
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ID kelas tidak ditemukan.";
    header("Location: manage_kelas.php");
    exit();
}

$id_kelas = $_GET['id'];

// Ambil data kelas berdasarkan ID
$query = "SELECT * FROM kelas_mk WHERE id_kelas = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id_kelas);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$kelas = mysqli_fetch_assoc($result);

if (!$kelas) {
    $_SESSION['error'] = "Kelas tidak ditemukan.";
    header("Location: manage_kelas.php");
    exit();
}

// Ambil data semua mata kuliah untuk dropdown
$matkul_result = mysqli_query($conn, "SELECT id_matkul, nama_matkul FROM mata_kuliah");
?>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Kelas</h2>

    <form action="../controllers/kelasController.php" method="POST" class="bg-white p-6 rounded shadow-md">
        <input type="hidden" name="id_kelas" value="<?= $kelas['id_kelas']; ?>">

        <div class="mb-4">
            <label for="id_matkul" class="block text-gray-700">Mata Kuliah</label>
            <select name="id_matkul" id="id_matkul" required class="w-full px-3 py-2 border rounded">
                <?php while ($row = mysqli_fetch_assoc($matkul_result)): ?>
                    <option value="<?= $row['id_matkul']; ?>" <?= $row['id_matkul'] == $kelas['id_matkul'] ? 'selected' : ''; ?>>
                        <?= $row['nama_matkul']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="nama_kelas" class="block text-gray-700">Nama Kelas</label>
            <input type="text" name="nama_kelas" id="nama_kelas" value="<?= $kelas['nama_kelas']; ?>" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="hari" class="block text-gray-700">Hari</label>
            <select name="hari" id="hari" class="w-full px-3 py-2 border rounded" required>
                <?php
                $hari_list = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"];
                foreach ($hari_list as $hari) {
                    $selected = $hari == $kelas['hari'] ? 'selected' : '';
                    echo "<option value=\"$hari\" $selected>$hari</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="jam_mulai" class="block text-gray-700">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" value="<?= $kelas['jam_mulai']; ?>" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="jam_selesai" class="block text-gray-700">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" value="<?= $kelas['jam_selesai']; ?>" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="ruangan" class="block text-gray-700">Ruangan</label>
            <input type="text" name="ruangan" id="ruangan" value="<?= $kelas['ruangan']; ?>" class="w-full px-3 py-2 border rounded" required>
        </div>

        <button type="submit" name="update_kelas" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Simpan Perubahan
        </button>
        <a href="manage_kelas.php" class="ml-2 text-gray-600 hover:text-gray-800">Batal</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
