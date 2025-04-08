<?php
session_start();
include '../config/database.php';
include '../includes/header.php'; // Header tetap digunakan

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

$id_mahasiswa = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ambil_kelas'])) {
    $id_kelas = intval($_POST['id_kelas']);

    $kelas_query = "SELECT * FROM kelas_mk WHERE id_kelas = $id_kelas";
    $kelas_result = mysqli_query($conn, $kelas_query);
    $kelas = mysqli_fetch_assoc($kelas_result);

    if (!$kelas) {
        $_SESSION['error'] = "Kelas tidak ditemukan!";
        header("Location: krs.php");
        exit();
    }

    $id_matkul = $kelas['id_matkul'];

    $cek_duplikat_query = "SELECT * FROM krs 
                           JOIN kelas_mk ON krs.id_kelas = kelas_mk.id_kelas
                           WHERE krs.id_mahasiswa = $id_mahasiswa 
                           AND kelas_mk.id_matkul = $id_matkul";
    $duplikat_result = mysqli_query($conn, $cek_duplikat_query);

    if (mysqli_num_rows($duplikat_result) > 0) {
        $_SESSION['error'] = "Mata kuliah ini sudah diambil di kelas lain.";
    } else {
        $bentrok_query = "SELECT * FROM krs 
                          JOIN kelas_mk km2 ON krs.id_kelas = km2.id_kelas
                          WHERE krs.id_mahasiswa = $id_mahasiswa
                          AND km2.hari = '{$kelas['hari']}'
                          AND (
                              (km2.jam_mulai < '{$kelas['jam_selesai']}' AND km2.jam_selesai > '{$kelas['jam_mulai']}')
                          )";
        $bentrok_result = mysqli_query($conn, $bentrok_query);

        if (mysqli_num_rows($bentrok_result) > 0) {
            $_SESSION['error'] = "Jadwal kelas ini bentrok dengan mata kuliah yang sudah diambil.";
        } else {
            $insert_query = "INSERT INTO krs (id_mahasiswa, id_kelas) VALUES ($id_mahasiswa, $id_kelas)";
            if (mysqli_query($conn, $insert_query)) {
                $_SESSION['success'] = "Berhasil mengambil kelas!";
            } else {
                $_SESSION['error'] = "Gagal mengambil kelas.";
            }
        }
    }
    header("Location: krs.php");
    exit();
}

$kelas_query = "
    SELECT km.*, mk.kode_matkul, mk.nama_matkul, mk.sks, mk.semester, d.nama AS nama_dosen 
    FROM kelas_mk km
    JOIN mata_kuliah mk ON km.id_matkul = mk.id_matkul
    JOIN dosen d ON mk.id_dosen = d.id_dosen
";
$kelas_result = mysqli_query($conn, $kelas_query);
?>

<!-- Responsiveness & Styling -->
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Ambil Mata Kuliah</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 max-w-2xl mx-auto">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 max-w-2xl mx-auto">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Scrollable Table Container -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="border px-4 py-2 whitespace-nowrap">Kode</th>
                    <th class="border px-4 py-2 whitespace-nowrap">Nama Mata Kuliah</th>
                    <th class="border px-4 py-2 whitespace-nowrap">Dosen</th>
                    <th class="border px-4 py-2 whitespace-nowrap">SKS</th>
                    <th class="border px-4 py-2 whitespace-nowrap">Semester</th>
                    <th class="border px-4 py-2 whitespace-nowrap">Kelas</th>
                    <th class="border px-4 py-2 whitespace-nowrap">Hari</th>
                    <th class="border px-4 py-2 whitespace-nowrap">Jam</th>
                    <th class="border px-4 py-2 whitespace-nowrap">Ruangan</th>
                    <th class="border px-4 py-2 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($kelas_result)): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['kode_matkul']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_matkul']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_dosen']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['sks']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['semester']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_kelas']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['hari']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['jam_mulai'] . ' - ' . $row['jam_selesai']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['ruangan']); ?></td>
                        <td class="border px-4 py-2">
                            <form action="krs.php" method="POST">
                                <input type="hidden" name="id_kelas" value="<?= $row['id_kelas']; ?>">
                                <button type="submit" name="ambil_kelas" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                    Ambil
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6 text-center">
            <a href="dashboard.php" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Kembali ke Dashboard</a>
        </div>
<?php include '../includes/footer.php'; ?>
