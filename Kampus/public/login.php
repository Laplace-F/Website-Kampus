<?php
session_start();
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && $password === $user['password']) {
        $role = $user['role'];
        $_SESSION['user_role'] = $role;
        $_SESSION['user_name'] = $user['nama'];

        if ($role === 'mahasiswa') {
            $id_user = $user['id_user'];
            $query_mhs = "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = $id_user";
            $result_mhs = mysqli_query($conn, $query_mhs);
            $mahasiswa = mysqli_fetch_assoc($result_mhs);

            if ($mahasiswa) {
                $_SESSION['user_id'] = $mahasiswa['id_mahasiswa'];
                header('Location: ../mahasiswa/dashboard.php');
                exit();
            } else {
                $error = "Data mahasiswa tidak ditemukan untuk user ini.";
            }
        } elseif ($role === 'dosen') {
            $_SESSION['user_id'] = $user['id_user'];
            header('Location: ../dosen/dashboard.php');
            exit();
        } elseif ($role === 'admin') {
            $_SESSION['user_id'] = $user['id_user'];
            header('Location: ../admin/dashboard.php');
            exit();
        }
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200 flex items-center justify-center font-sans">
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full">
        <div class="flex flex-col items-center mb-6">
            <!-- Logo Placeholder -->

            <h1 class="text-xl font-semibold text-gray-800">MYKAMPUS UNIVERSITY</h1>
            <p class="text-sm text-gray-500">Silakan login untuk melanjutkan</p>
        </div>

        <?php if (isset($error)) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required
                    class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors">Login</button>
        </form>

        <p class="text-xs text-gray-400 mt-6 text-center">© <?= date("Y") ?> Website Resmi MyKampus. All rights reserved.</p>
    </div>
</body>
</html>
