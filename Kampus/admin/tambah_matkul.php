<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config/database.php';
include '../includes/header.php';

// Ambil data dosen untuk pilihan dosen
$dosenQuery = "SELECT * FROM dosen";
$dosenResult = mysqli_query($conn, $dosenQuery);
?>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Tambah Mata Kuliah</h2>
    <form action="../controllers/matkulController.php" method="POST">

        <div class="mb-4">
            <label for="kode_matkul" class="block text-gray-700">Kode Mata Kuliah</label>
            <input type="text" name="kode_matkul" id="kode_matkul" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="nama_matkul" class="block text-gray-700">Nama Mata Kuliah</label>
            <input type="text" name="nama_matkul" id="nama_matkul" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="id_dosen" class="block text-gray-700">Dosen</label>
            <select name="id_dosen" id="id_dosen" class="w-full px-3 py-2 border rounded" required>
                <?php while ($dosen = mysqli_fetch_assoc($dosenResult)): ?>
                    <option value="<?= $dosen['id_dosen']; ?>"><?= $dosen['nama']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="sks" class="block text-gray-700">Jumlah SKS</label>
            <input type="number" name="sks" id="sks" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="semester" class="block text-gray-700">Semester</label>
            <input type="number" name="semester" id="semester" class="w-full px-3 py-2 border rounded" required>
        </div>

 

        <button type="submit" name="tambah_matkul" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            Tambahkan Mata Kuliah
        </button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
