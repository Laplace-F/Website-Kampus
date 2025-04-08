<?php
session_start();
if (!isset($_SESSION['user_role'])) {
    header('Location: ../login.php');
    exit();
}

$user_role = $_SESSION['user_role'];
$user_name = $_SESSION['user_name'];

include '../includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Dashboard</h2>
        <p class="text-center text-gray-700">Selamat datang, <span class="font-semibold"><?= htmlspecialchars($user_name); ?></span>!</p>
        <p class="text-center text-gray-600">Anda login sebagai <span class="font-semibold text-blue-500"><?= ucfirst($user_role); ?></span>.</p>
        
        <div class="mt-6 flex flex-col space-y-3 text-center">
            <?php if ($user_role === 'admin') { ?>
                <a href="manage_dosen.php" class="block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Kelola Dosen</a>
                <a href="manage_mahasiswa.php" class="block bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Kelola Mahasiswa</a>
                <a href="manage_matkul.php" class="block bg-purple-500 text-white py-2 px-4 rounded hover:bg-purple-600">Kelola Mata Kuliah</a>
                <a href="manage_kelas.php" class="block bg-indigo-500 text-white py-2 px-4 rounded hover:bg-indigo-600">Kelola Kelas</a>

            <?php } elseif ($user_role === 'dosen') { ?>
                <a href="../dosen/jadwal.php" class="block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Lihat Jadwal Mengajar</a>
            <?php } elseif ($user_role === 'mahasiswa') { ?>
                <a href="../mahasiswa/krs.php" class="block bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Isi KRS</a>
                <a href="../mahasiswa/jadwal.php" class="block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Lihat Jadwal Kuliah</a>
            <?php } ?>
            <a href="../public/logout.php" class="block bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Logout</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
