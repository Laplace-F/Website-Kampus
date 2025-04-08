<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'mahasiswa') {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
?>

<?php include '../includes/header.php'; ?>

<div class="flex justify-center items-center min-h-[80vh] px-4">
    <div class="w-full max-w-3xl bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Dashboard Mahasiswa</h2>
        <p class="text-center text-gray-700">Selamat datang, <span class="font-semibold"><?php echo htmlspecialchars($user_name); ?></span>!</p>
        <p class="text-center text-gray-600">Anda login sebagai <span class="font-semibold text-blue-500">Mahasiswa</span>.</p>

        <div class="mt-6 flex flex-col space-y-2 text-center">
            <a href="krs.php" class="block bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Isi KRS</a>
            <a href="jadwal.php" class="block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Lihat Jadwal Kuliah</a>
            <a href="../public/login.php" class="block bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">Logout</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
