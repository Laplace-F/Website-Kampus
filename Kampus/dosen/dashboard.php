<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'dosen') {
    header('Location: ../login.php');
    exit();
}

include '../config/database.php';

$user_id = $_SESSION['user_id'];

// Ambil data dosen berdasarkan id_user
$query = "SELECT * FROM dosen WHERE id_user = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $dosen = mysqli_fetch_assoc($result);
} else {
    $_SESSION['error'] = "Data dosen tidak ditemukan!";
    header("Location: ../login.php");
    exit();
}

include '../includes/header.php';
?>

<div class="flex justify-center items-center min-h-[80vh] px-4">
    <div class="w-full max-w-3xl bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Dashboard Dosen</h2>
        <p class="text-center text-gray-700">Selamat datang, <span class="font-semibold"><?= htmlspecialchars($dosen['nama']); ?></span>!</p>
        <p class="text-center text-gray-600">Anda login sebagai <span class="font-semibold text-blue-500">Dosen</span>.</p>

        <div class="mt-6 flex flex-col space-y-2 text-center">
            <a href="data_diri.php" class="block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Data Diri</a>
            <a href="jadwal.php" class="block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Lihat Jadwal Mengajar</a>
            <a href="../public/login.php" class="block bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">Logout</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
