<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

// Fetch all history
$stmt = $pdo->query("
    SELECT h.*, d.name as disease_name
    FROM diagnosis_history h
    LEFT JOIN diseases d ON h.disease_id = d.id
    ORDER BY h.diagnosis_date DESC
");
$history = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Riwayat Diagnosa - DurianCare Expert</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, .font-poppins { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-bold text-green-800">DurianCare</span>
            </div>
            <div class="hidden md:flex gap-8">
                <a href="index.php" class="text-gray-600 hover:text-green-800 transition">Beranda</a>
                <a href="diagnosa.php" class="text-gray-600 hover:text-green-800 transition">Diagnosa</a>
                <a href="katalog.php" class="text-gray-600 hover:text-green-800 transition">Basis Pengetahuan</a>
                <a href="riwayat.php" class="text-green-800 font-bold border-b-2 border-green-800 pb-1">Riwayat</a>
                <a href="tentang.php" class="text-gray-600 hover:text-green-800 transition">Tentang</a>
            </div>
            <div>
                <a href="admin/login.php" class="text-green-800 hover:bg-green-50 p-2 rounded-full transition flex items-center justify-center">
                    <span class="material-symbols-outlined">account_circle</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <h1 class="text-3xl font-bold text-green-900 mb-2">Riwayat Diagnosa</h1>
                <p class="text-gray-600">Daftar diagnosa yang telah dilakukan oleh para petani.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-green-50">
                                <th class="p-6 text-sm font-bold text-green-800 border-b">Tanggal</th>
                                <th class="p-6 text-sm font-bold text-green-800 border-b">Nama Petani</th>
                                <th class="p-6 text-sm font-bold text-green-800 border-b">Hasil Penyakit</th>
                                <th class="p-6 text-sm font-bold text-green-800 border-b">Gejala Terdeteksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $h): ?>
                            <tr class="hover:bg-gray-50 transition border-b border-gray-100 last:border-0">
                                <td class="p-6 text-sm text-gray-500 whitespace-nowrap">
                                    <?= date('d M Y, H:i', strtotime($h['diagnosis_date'])) ?>
                                </td>
                                <td class="p-6 text-sm font-bold text-gray-900 whitespace-nowrap">
                                    <?= htmlspecialchars($h['farmer_name']) ?>
                                </td>
                                <td class="p-6 text-sm">
                                    <?php if ($h['disease_name']): ?>
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-semibold">
                                            <?= htmlspecialchars($h['disease_name']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic">Tidak Terdeteksi</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-6 text-sm text-gray-600">
                                    <?php
                                    $s_ids = json_decode($h['selected_symptoms'], true);
                                    if ($s_ids) {
                                        $placeholders = str_repeat('?,', count($s_ids) - 1) . '?';
                                        $stmt = $pdo->prepare("SELECT name FROM symptoms WHERE id IN ($placeholders)");
                                        $stmt->execute($s_ids);
                                        $names = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                        echo "<div class='line-clamp-1'>" . htmlspecialchars(implode(', ', $names)) . "</div>";
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (count($history) == 0): ?>
                            <tr>
                                <td colspan="4" class="p-20 text-center text-gray-500 italic">
                                    Belum ada data diagnosa. <a href="diagnosa.php" class="text-green-800 underline">Mulai diagnosa sekarang</a>.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="space-y-2 text-center md:text-left">
                <span class="text-xl font-bold text-green-800">DurianCare</span>
                <p class="text-gray-500 text-sm">© <?= get_current_year() ?> DurianCare Expert. All Rights Reserved.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-6 text-sm text-gray-600">
                <a href="#" class="hover:text-green-800 transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-green-800 transition">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-green-800 transition">Kontak</a>
            </div>
        </div>
    </footer>
</body>
</html>
