<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config/database.php';
include '../includes/header.php';

// Cek apakah ada ID dosen yang dikirim untuk diedit
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Dosen tidak ditemukan!";
    header("Location: manage_dosen.php");
    exit();
}

$id_dosen = intval($_GET['id']);
$query = "SELECT * FROM dosen WHERE id_dosen = $id_dosen";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    $_SESSION['error'] = "Dosen tidak ditemukan!";
    header("Location: manage_dosen.php");
    exit();
}

$dosen = mysqli_fetch_assoc($result);
?>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Dosen</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="../controllers/dosenController.php" method="POST">
        <input type="hidden" name="id_dosen" value="<?= $dosen['id_dosen']; ?>">

        <div class="mb-4">
            <label for="nik" class="block text-gray-700">NIK</label>
            <input type="text" name="nik" id="nik" value="<?= htmlspecialchars($dosen['nik']); ?>" 
                class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="nama" class="block text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($dosen['nama']); ?>" 
                class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="gelar" class="block text-gray-700">Gelar</label>
            <input type="text" name="gelar" id="gelar" value="<?= htmlspecialchars($dosen['gelar']); ?>" 
                class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="lulusan" class="block text-gray-700">Lulusan</label>
            <input type="text" name="lulusan" id="lulusan" value="<?= htmlspecialchars($dosen['lulusan']); ?>" 
                class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="telepon" class="block text-gray-700">Telepon</label>
            <input type="text" name="telepon" id="telepon" value="<?= htmlspecialchars($dosen['telepon']); ?>" 
                class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" 
                value="<?= isset($dosen['email']) ? htmlspecialchars($dosen['email']) : ''; ?>" 
                class="w-full px-3 py-2 border rounded" required>
        </div>

        <button type="submit" name="edit_dosen" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            Simpan Perubahan
        </button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
