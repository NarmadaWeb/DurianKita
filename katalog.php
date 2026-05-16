<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM diseases WHERE name LIKE ? OR description LIKE ? ORDER BY name ASC");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM diseases ORDER BY name ASC");
}
$diseases = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Katalog Penyakit - DurianCare Expert</title>
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
                <a href="katalog.php" class="text-green-800 font-bold border-b-2 border-green-800 pb-1">Basis Pengetahuan</a>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                <div>
                    <h1 class="text-3xl font-bold text-green-900 mb-2">Katalog Penyakit Durian</h1>
                    <p class="text-gray-600">Pelajari berbagai penyakit yang menyerang pohon durian dan cara mengatasinya.</p>
                </div>
                <form action="" method="GET" class="relative w-full md:w-96">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari penyakit..." class="w-full pl-10 pr-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-green-500 border-gray-300">
                </form>
            </div>

            <?php if (count($diseases) > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($diseases as $d): ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                            <div class="p-8">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-12 h-12 bg-green-100 text-green-800 rounded-full flex items-center justify-center">
                                        <span class="material-symbols-outlined">coronavirus</span>
                                    </div>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Penyakit</span>
                                </div>
                                <h3 class="text-xl font-bold text-green-900 mb-1 group-hover:text-green-700 transition"><?= htmlspecialchars($d['name']) ?></h3>
                                <p class="text-sm italic text-gray-500 mb-4"><?= htmlspecialchars($d['scientific_name']) ?></p>
                                <p class="text-gray-600 line-clamp-3 text-sm mb-6 leading-relaxed">
                                    <?= htmlspecialchars($d['description']) ?>
                                </p>
                                <a href="detail_penyakit.php?id=<?= $d['id'] ?>" class="inline-flex items-center gap-2 text-green-800 font-bold hover:gap-3 transition-all text-sm">
                                    Lihat Detail <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-20">
                    <span class="material-symbols-outlined text-6xl text-gray-200 mb-4">search_off</span>
                    <p class="text-gray-500 italic">Penyakit yang Anda cari tidak ditemukan.</p>
                </div>
            <?php endif; ?>
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
