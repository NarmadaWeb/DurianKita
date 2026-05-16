<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$csrf_token = generate_csrf_token();

// Fetch symptoms by category
$categories = ['Daun', 'Batang', 'Buah', 'Akar'];
$symptoms_by_cat = [];
foreach ($categories as $cat) {
    $stmt = $pdo->prepare("SELECT * FROM symptoms WHERE category = ? ORDER BY name ASC");
    $stmt->execute([$cat]);
    $symptoms_by_cat[$cat] = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Diagnosa Mandiri - DurianCare Expert</title>
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
                <a href="diagnosa.php" class="text-green-800 font-bold border-b-2 border-green-800 pb-1">Diagnosa</a>
                <a href="katalog.php" class="text-gray-600 hover:text-green-800 transition">Basis Pengetahuan</a>
                <a href="riwayat.php" class="text-gray-600 hover:text-green-800 transition">Riwayat</a>
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
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h1 class="text-3xl font-bold text-green-900 mb-4">Diagnosa Penyakit Durian</h1>
                <p class="text-gray-600">Silakan masukkan nama Anda dan pilih gejala-gejala yang terlihat pada pohon durian Anda.</p>
            </div>

            <form action="hasil.php" method="POST" class="space-y-12">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

                <!-- Farmer Name -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 max-w-lg mx-auto">
                    <label class="block text-green-900 font-bold mb-3" for="farmer_name">Nama Lengkap Anda</label>
                    <input type="text" name="farmer_name" id="farmer_name" placeholder="Masukkan nama Anda..." class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>

                <!-- Symptoms Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($symptoms_by_cat as $cat => $symptoms): ?>
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="bg-green-50 px-6 py-4 border-b border-green-100 flex items-center gap-2">
                                <span class="material-symbols-outlined text-green-800">
                                    <?php
                                    switch($cat) {
                                        case 'Daun': echo 'eco'; break;
                                        case 'Batang': echo 'forest'; break;
                                        case 'Buah': echo 'nutrition'; break;
                                        case 'Akar': echo 'grass'; break;
                                    }
                                    ?>
                                </span>
                                <h3 class="font-bold text-green-800"><?= $cat ?></h3>
                            </div>
                            <div class="p-6 space-y-3">
                                <?php if (count($symptoms) > 0): ?>
                                    <?php foreach ($symptoms as $s): ?>
                                        <label class="flex items-center gap-3 p-3 rounded-xl border border-transparent hover:bg-gray-50 hover:border-gray-200 transition cursor-pointer">
                                            <input type="checkbox" name="symptom_ids[]" value="<?= $s['id'] ?>" class="w-5 h-5 rounded text-green-700 focus:ring-green-500 border-gray-300">
                                            <span class="text-gray-700 text-sm"><?= htmlspecialchars($s['name']) ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-gray-400 text-sm italic">Belum ada data gejala.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex justify-center pt-8">
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-12 py-4 rounded-full font-bold shadow-lg transition transform hover:scale-105 flex items-center gap-2">
                        Proses Diagnosa <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </form>
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
