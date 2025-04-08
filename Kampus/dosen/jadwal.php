<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'dosen') {
    header('Location: ../login.php');
    exit();
}

// Ambil id_user dari sesi (bukan id_dosen langsung)
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Ambil id_dosen berdasarkan id_user
$dosen_query = mysqli_query($conn, "SELECT id_dosen FROM dosen WHERE id_user = '$user_id'");
$dosen_data = mysqli_fetch_assoc($dosen_query);

if (!$dosen_data) {
    echo "Dosen tidak ditemukan.";
    exit();
}

$id_dosen = $dosen_data['id_dosen'];

// Ambil jadwal mengajar berdasarkan id_dosen
$query = "
    SELECT 
        mk.nama_matkul,
        mk.sks,
        kmk.hari,
        kmk.jam_mulai,
        kmk.jam_selesai,
        kmk.ruangan,
        kmk.nama_kelas
    FROM mata_kuliah mk
    INNER JOIN kelas_mk kmk ON mk.id_matkul = kmk.id_matkul
    WHERE mk.id_dosen = '$id_dosen'
    ORDER BY FIELD(kmk.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'), kmk.jam_mulai
";

$result = mysqli_query($conn, $query);

include '../includes/header.php';
?>

<div class="flex justify-center items-center min-h-[80vh] px-4">
    <div class="w-full max-w-5xl bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Jadwal Mengajar</h2>
        <p class="text-center text-gray-700">Dosen: <span class="font-semibold"><?php echo $user_name; ?></span></p>
        
        <table class="w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-200 text-center">
                    <th class="border border-gray-300 px-4 py-2">Hari</th>
                    <th class="border border-gray-300 px-4 py-2">Mata Kuliah</th>
                    <th class="border border-gray-300 px-4 py-2">SKS</th>
                    <th class="border border-gray-300 px-4 py-2">Kelas</th>
                    <th class="border border-gray-300 px-4 py-2">Jam</th>
                    <th class="border border-gray-300 px-4 py-2">Ruangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($jadwal = mysqli_fetch_assoc($result)) { ?>
                        <tr class="text-center">
                            <td class="border border-gray-300 px-4 py-2"><?php echo $jadwal['hari']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $jadwal['nama_matkul']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $jadwal['sks']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $jadwal['nama_kelas']; ?></td>
                            <td class="border border-gray-300 px-4 py-2">
                                <?php echo date('H:i', strtotime($jadwal['jam_mulai'])) . " - " . date('H:i', strtotime($jadwal['jam_selesai'])); ?>
                            </td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $jadwal['ruangan']; ?></td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">Tidak ada jadwal mengajar yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-6 text-center">
            <a href="dashboard.php" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Kembali ke Dashboard</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
