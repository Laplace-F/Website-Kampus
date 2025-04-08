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
        <h2 class="text-2xl font-bold text-center mb-4">Data Diri Dosen</h2>
        <p class="text-center text-gray-700 mb-6">Berikut adalah data diri Anda sebagai dosen:</p>

        <div class="p-4 bg-gray-50 rounded-lg shadow-md">
            <p><strong>Nama:</strong> <?= htmlspecialchars($dosen['nama']); ?></p>
            <p><strong>NIK:</strong> <?= htmlspecialchars($dosen['nik']); ?></p>
            <p><strong>Gelar:</strong> <?= htmlspecialchars($dosen['gelar']); ?></p>
            <p><strong>Lulusan:</strong> <?= htmlspecialchars($dosen['lulusan']); ?></p>
            <p><strong>Telepon:</strong> <?= htmlspecialchars($dosen['telepon']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($dosen['email']); ?></p>
        </div>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Kembali ke Dashboard</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>