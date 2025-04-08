<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'mahasiswa') {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Ambil filter dari form
$filter_hari = isset($_GET['hari']) ? $_GET['hari'] : '';
$filter_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';

// Query dasar
$query = "
    SELECT 
        mk.nama_matkul,
        mk.sks,
        d.nama AS nama_dosen,
        kmk.nama_kelas,
        kmk.hari,
        kmk.jam_mulai,
        kmk.jam_selesai,
        kmk.ruangan
    FROM krs k
    JOIN kelas_mk kmk ON k.id_kelas = kmk.id_kelas
    JOIN mata_kuliah mk ON kmk.id_matkul = mk.id_matkul
    JOIN dosen d ON mk.id_dosen = d.id_dosen
    WHERE k.id_mahasiswa = '$user_id'
";

// Tambahkan filter jika ada
if (!empty($filter_hari)) {
    $query .= " AND kmk.hari = '" . mysqli_real_escape_string($conn, $filter_hari) . "'";
}
if (!empty($filter_kelas)) {
    $query .= " AND kmk.nama_kelas = '" . mysqli_real_escape_string($conn, $filter_kelas) . "'";
}

$result = mysqli_query($conn, $query);

// Ambil daftar hari dan kelas untuk dropdown filter
$hari_list = mysqli_query($conn, "SELECT DISTINCT hari FROM kelas_mk WHERE hari IS NOT NULL");
$kelas_list = mysqli_query($conn, "SELECT DISTINCT nama_kelas FROM kelas_mk WHERE nama_kelas IS NOT NULL");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Kuliah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<?php include '../includes/header.php'; ?>

<main class="flex-grow flex justify-center items-center px-4 py-10">
    <div class="w-full max-w-6xl bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Jadwal Kuliah</h2>
        <p class="text-center text-gray-700 mb-6">Mahasiswa: <span class="font-semibold"><?php echo htmlspecialchars($user_name); ?></span></p>

        <!-- Filter Form -->
        <form method="GET" class="flex flex-wrap gap-4 justify-center mb-6">
            <select name="hari" class="px-3 py-2 border rounded-lg w-40">
                <option value="">-- Semua Hari --</option>
                <?php while ($row = mysqli_fetch_assoc($hari_list)) { ?>
                    <option value="<?= $row['hari'] ?>" <?= ($filter_hari == $row['hari']) ? 'selected' : '' ?>>
                        <?= $row['hari'] ?>
                    </option>
                <?php } ?>
            </select>

            <select name="kelas" class="px-3 py-2 border rounded-lg w-40">
                <option value="">-- Semua Kelas --</option>
                <?php while ($row = mysqli_fetch_assoc($kelas_list)) { ?>
                    <option value="<?= $row['nama_kelas'] ?>" <?= ($filter_kelas == $row['nama_kelas']) ? 'selected' : '' ?>>
                        <?= $row['nama_kelas'] ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Filter</button>
            <a href="jadwal.php" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">Reset</a>
        </form>

        <!-- Tabel Jadwal -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-sm md:text-base">
                <thead>
                    <tr class="bg-gray-200 text-center">
                        <th class="border px-4 py-2">Hari</th>
                        <th class="border px-4 py-2">Jam</th>
                        <th class="border px-4 py-2">Mata Kuliah</th>
                        <th class="border px-4 py-2">SKS</th>
                        <th class="border px-4 py-2">Dosen</th>
                        <th class="border px-4 py-2">Kelas</th>
                        <th class="border px-4 py-2">Ruangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($jadwal = mysqli_fetch_assoc($result)): ?>
                            <tr class="text-center">
                                <td class="border px-4 py-2"><?php echo $jadwal['hari']; ?></td>
                                <td class="border px-4 py-2"><?php echo date('H:i', strtotime($jadwal['jam_mulai'])) . ' - ' . date('H:i', strtotime($jadwal['jam_selesai'])); ?></td>
                                <td class="border px-4 py-2"><?php echo $jadwal['nama_matkul']; ?></td>
                                <td class="border px-4 py-2"><?php echo $jadwal['sks']; ?></td>
                                <td class="border px-4 py-2"><?php echo $jadwal['nama_dosen']; ?></td>
                                <td class="border px-4 py-2"><?php echo $jadwal['nama_kelas']; ?></td>
                                <td class="border px-4 py-2"><?php echo $jadwal['ruangan']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-4 text-gray-500">Tidak ada jadwal ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Kembali ke Dashboard</a>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>

</body>
</html>
