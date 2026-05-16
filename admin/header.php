<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

if (!is_admin_logged_in()) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - DurianCare Expert</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-gray-100 flex min-h-screen">
    <!-- Sidebar -->
    <aside class="bg-green-900 text-white w-64 fixed h-full flex flex-col overflow-y-auto z-50">
        <div class="p-6">
            <h1 class="text-xl font-bold">DurianCare Admin</h1>
        </div>
        <nav class="flex-grow px-4">
            <ul class="space-y-2">
                <li>
                    <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'bg-green-700' : 'hover:bg-green-800' ?>">
                        <span class="material-symbols-outlined">dashboard</span> Dashboard
                    </a>
                </li>
                <li>
                    <a href="manage_diseases.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'manage_diseases.php' ? 'bg-green-700' : 'hover:bg-green-800' ?>">
                        <span class="material-symbols-outlined">coronavirus</span> Kelola Penyakit
                    </a>
                </li>
                <li>
                    <a href="manage_symptoms.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'manage_symptoms.php' ? 'bg-green-700' : 'hover:bg-green-800' ?>">
                        <span class="material-symbols-outlined">conditions</span> Kelola Gejala
                    </a>
                </li>
                <li>
                    <a href="manage_rules.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'manage_rules.php' ? 'bg-green-700' : 'hover:bg-green-800' ?>">
                        <span class="material-symbols-outlined">account_tree</span> Basis Aturan
                    </a>
                </li>
                <li>
                    <a href="manage_history.php" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= basename($_SERVER['PHP_SELF']) == 'manage_history.php' ? 'bg-green-700' : 'hover:bg-green-800' ?>">
                        <span class="material-symbols-outlined">history</span> Riwayat Diagnosa
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t border-green-800">
            <a href="logout.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-700 text-red-200">
                <span class="material-symbols-outlined">logout</span> Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow ml-64 p-8">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="bg-<?= $_SESSION['message_type'] == 'success' ? 'green' : 'red' ?>-100 border border-<?= $_SESSION['message_type'] == 'success' ? 'green' : 'red' ?>-400 text-<?= $_SESSION['message_type'] == 'success' ? 'green' : 'red' ?>-700 px-4 py-3 rounded mb-6">
                <?= $_SESSION['message'] ?>
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            </div>
        <?php endif; ?>
