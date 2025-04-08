<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <header class="bg-blue-800 shadow-md">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <h1 class="text-xl sm:text-2xl font-semibold text-white tracking-wide">Sistem Informasi Akademik MyKampus</h1>
        </div>
    </header>
    <main class="flex-grow container mx-auto px-4 py-6">
