<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Ambil filter dan pencarian
$search_nama = $_GET['search_nama'] ?? '';
$filter_jurusan = $_GET['filter_jurusan'] ?? '';
$filter_tahun = $_GET['filter_tahun'] ?? '';

// Query dasar
$query = "SELECT * FROM mahasiswa WHERE 1";

// Tambah kondisi jika ada filter/pencarian
if (!empty($search_nama)) {
    $query .= " AND nama LIKE '%" . mysqli_real_escape_string($conn, $search_nama) . "%'";
}
if (!empty($filter_jurusan)) {
    $query .= " AND jurusan = '" . mysqli_real_escape_string($conn, $filter_jurusan) . "'";
}
if (!empty($filter_tahun)) {
    $query .= " AND tahun_masuk = '" . mysqli_real_escape_string($conn, $filter_tahun) . "'";
}

$result = mysqli_query($conn, $query);

include '../includes/header.php';
?>

<div class="w-full max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md mt-8">
    <h2 class="text-2xl font-bold text-center mb-4">Kelola Mahasiswa</h2>
    <a href="dashboard.php" class="mb-4 inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Kembali ke Dashboard</a>

    <!-- Form Search dan Filter -->
    <form method="GET" class="flex flex-wrap gap-4 mb-6 justify-center">
        <input type="text" name="search_nama" placeholder="Cari Nama" value="<?= htmlspecialchars($search_nama); ?>" class="border rounded px-3 py-2 w-48">
        <input type="text" name="filter_jurusan" placeholder="Filter Jurusan" value="<?= htmlspecialchars($filter_jurusan); ?>" class="border rounded px-3 py-2 w-48">
        <input type="text" name="filter_tahun" placeholder="Filter Tahun Masuk" value="<?= htmlspecialchars($filter_tahun); ?>" class="border rounded px-3 py-2 w-48">
        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Terapkan</button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-300 mt-4 text-sm sm:text-base">
            <thead>
                <tr class="bg-gray-200 text-center">
                    <th class="border border-gray-300 px-4 py-2">NIM</th>
                    <th class="border border-gray-300 px-4 py-2">Nama</th>
                    <th class="border border-gray-300 px-4 py-2">Tahun Masuk</th>
                    <th class="border border-gray-300 px-4 py-2">Jurusan</th>
                    <th class="border border-gray-300 px-4 py-2">Alamat</th>
                    <th class="border border-gray-300 px-4 py-2">Telepon</th>
                    <th class="border border-gray-300 px-4 py-2">Tanggal Input</th>
                    <th class="border border-gray-300 px-4 py-2">User Input</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($mahasiswa = mysqli_fetch_assoc($result)) { ?>
                    <tr class="text-center">
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($mahasiswa['nim']); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($mahasiswa['nama']); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($mahasiswa['tahun_masuk']); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($mahasiswa['jurusan']); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($mahasiswa['alamat']); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($mahasiswa['telepon']); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= date('d-m-Y H:i', strtotime($mahasiswa['created_at'])); ?></td>
                        <td class="border border-gray-300 px-4 py-2">admin</td>
                        <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">
                            <a href="edit_mahasiswa.php?id=<?= $mahasiswa['id_mahasiswa']; ?>" class="text-blue-500">Edit</a> |
                            <a href="delete_mahasiswa.php?id=<?= $mahasiswa['id_mahasiswa']; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Hapus mahasiswa ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6 text-center">
        <a href="tambah_mahasiswa.php" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Tambah Mahasiswa</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
