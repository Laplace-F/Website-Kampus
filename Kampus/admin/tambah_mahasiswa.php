<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/header.php';
?>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Tambah Mahasiswa</h2>

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

    <form action="../controllers/mahasiswaController.php" method="POST">
        <div class="mb-4">
            <label for="nim" class="block text-gray-700">NIM</label>
            <input type="text" name="nim" id="nim" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <div class="mb-4">
            <label for="nama" class="block text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <div class="mb-4">
            <label for="tahun_masuk" class="block text-gray-700">Tahun Masuk</label>
            <input type="number" name="tahun_masuk" id="tahun_masuk" min="2000" max="<?= date('Y'); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <div class="mb-4">
            <label for="alamat" class="block text-gray-700">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div class="mb-4">
            <label for="telepon" class="block text-gray-700">Telepon</label>
            <input type="text" name="telepon" id="telepon" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <!-- Jurusan Dropdown -->
        <div class="mb-4">
            <label for="jurusan" class="block text-gray-700">Jurusan</label>
            <select name="jurusan" id="jurusan" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
                <option value="" disabled selected>Pilih Jurusan</option>
                <option value="Teknik Komputer">Teknik Komputer</option>
                <option value="Informatika">Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
                <option value="Teknik Elektro">Teknik Elektro</option>
                <option value="DKV">DKV</option>
                <!-- Tambahkan jurusan lain di sini jika perlu -->
            </select>
        </div>

        <button type="submit" name="tambah_mahasiswa" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            Tambah Mahasiswa
        </button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
