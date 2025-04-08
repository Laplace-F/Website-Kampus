<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config/database.php';
include '../includes/header.php';

// Cek apakah ada ID mahasiswa yang dikirim untuk diedit
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Mahasiswa tidak ditemukan!";
    header("Location: manage_mahasiswa.php");
    exit();
}

$id_mahasiswa = intval($_GET['id']);
$query = "SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    $_SESSION['error'] = "Mahasiswa tidak ditemukan!";
    header("Location: manage_mahasiswa.php");
    exit();
}

$mahasiswa = mysqli_fetch_assoc($result);

// Daftar jurusan yang bisa dipilih
$daftar_jurusan = ['Teknik Komputer', 'Informatika', 'Sistem Informasi', 'Desain Komunikasi Visual'];
?>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Mahasiswa</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="../controllers/mahasiswaController.php" method="POST">
        <input type="hidden" name="id_mahasiswa" value="<?= $mahasiswa['id_mahasiswa']; ?>">

        <div class="mb-4">
            <label for="nim" class="block text-gray-700">NIM</label>
            <input type="text" name="nim" id="nim" value="<?= htmlspecialchars($mahasiswa['nim']); ?>" 
                class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="nama" class="block text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($mahasiswa['nama']); ?>" 
                class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="tahun_masuk" class="block text-gray-700">Tahun Masuk</label>
            <input type="number" name="tahun_masuk" id="tahun_masuk" value="<?= htmlspecialchars($mahasiswa['tahun_masuk']); ?>" 
                class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="jurusan" class="block text-gray-700">Jurusan</label>
            <select name="jurusan" id="jurusan" class="w-full px-3 py-2 border rounded" required>
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach ($daftar_jurusan as $jurusan): ?>
                    <option value="<?= $jurusan; ?>" <?= ($mahasiswa['jurusan'] === $jurusan) ? 'selected' : ''; ?>>
                        <?= $jurusan; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="alamat" class="block text-gray-700">Alamat</label>
            <input type="text" name="alamat" id="alamat" value="<?= htmlspecialchars($mahasiswa['alamat']); ?>" 
                class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="telepon" class="block text-gray-700">Telepon</label>
            <input type="text" name="telepon" id="telepon" value="<?= htmlspecialchars($mahasiswa['telepon']); ?>" 
                class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" 
                value="<?= isset($mahasiswa['email']) ? htmlspecialchars($mahasiswa['email']) : ''; ?>" 
                class="w-full px-3 py-2 border rounded" required>
        </div>
        
        <button type="submit" name="edit_mahasiswa" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            Simpan Perubahan
        </button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
