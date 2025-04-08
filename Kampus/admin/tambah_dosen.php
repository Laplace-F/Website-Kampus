<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/header.php';
?>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Tambah Dosen</h2>

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

    <form action="../controllers/dosenController.php" method="POST">
        <div class="mb-4">
            <label for="nik" class="block text-gray-700">NIK</label>
            <input type="text" name="nik" id="nik" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <div class="mb-4">
            <label for="nama" class="block text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <div class="mb-4">
            <label for="gelar" class="block text-gray-700">Gelar</label>
            <input type="text" name="gelar" id="gelar" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div class="mb-4">
            <label for="lulusan" class="block text-gray-700">Lulusan</label>
            <input type="text" name="lulusan" id="lulusan" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
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



        <button type="submit" name="tambah_dosen" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            Tambah Dosen
        </button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
