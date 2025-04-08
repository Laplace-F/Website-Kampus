<?php
session_start();
include '../config/database.php';
include '../includes/header.php';

// Cek apakah user adalah admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Cek apakah ada ID mata kuliah yang dikirim untuk diedit
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Mata kuliah tidak ditemukan!";
    header("Location: manage_matkul.php");
    exit();
}

$id_matkul = intval($_GET['id']);

// Ambil data mata kuliah yang akan diedit
$query = "SELECT * FROM mata_kuliah WHERE id_matkul = $id_matkul";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    $_SESSION['error'] = "Mata kuliah tidak ditemukan!";
    header("Location: manage_matkul.php");
    exit();
}

$matkul = mysqli_fetch_assoc($result);

// Ambil data dosen untuk opsi pemilihan dosen pengampu
$dosen_query = "SELECT * FROM dosen ORDER BY nama ASC";
$dosen_result = mysqli_query($conn, $dosen_query);
?>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Mata Kuliah</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="../controllers/matkulController.php" method="POST">
        <input type="hidden" name="id_matkul" value="<?= $matkul['id_matkul']; ?>">

        <div class="mb-4">
            <label for="kode_matkul" class="block text-gray-700">Kode Mata Kuliah</label>
            <input type="text" name="kode_matkul" id="kode_matkul" value="<?= htmlspecialchars($matkul['kode_matkul']); ?>" 
                   class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="nama_matkul" class="block text-gray-700">Nama Mata Kuliah</label>
            <input type="text" name="nama_matkul" id="nama_matkul" value="<?= htmlspecialchars($matkul['nama_matkul']); ?>" 
                   class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="sks" class="block text-gray-700">Jumlah SKS</label>
            <input type="number" name="sks" id="sks" value="<?= htmlspecialchars($matkul['sks']); ?>" 
                   class="w-full px-3 py-2 border rounded" min="1" max="6" required>
        </div>

        <div class="mb-4">
            <label for="semester" class="block text-gray-700">Semester</label>
            <input type="number" name="semester" id="semester" value="<?= htmlspecialchars($matkul['semester']); ?>" 
                   class="w-full px-3 py-2 border rounded" min="1" max="8" required>
        </div>

        <div class="mb-4">
            <label for="id_dosen" class="block text-gray-700">Dosen Pengampu</label>
            <select name="id_dosen" id="id_dosen" class="w-full px-3 py-2 border rounded" required>
                <option value="">-- Pilih Dosen Pengampu --</option>
                <?php while ($dosen = mysqli_fetch_assoc($dosen_result)): ?>
                    <option value="<?= $dosen['id_dosen']; ?>" 
                        <?= $dosen['id_dosen'] == $matkul['id_dosen'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($dosen['nama']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" name="edit_matkul" 
                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Simpan Perubahan</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
