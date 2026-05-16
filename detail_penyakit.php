<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM diseases WHERE id = ?");
$stmt->execute([$id]);
$disease = $stmt->fetch();

if (!$disease) {
    header('Location: katalog.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= htmlspecialchars($disease['name']) ?> - DurianCare Expert</title>
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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="katalog.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-green-800 transition mb-8 group">
                <span class="material-symbols-outlined text-sm transition group-hover:-translate-x-1">arrow_back</span> Kembali ke Katalog
            </a>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-green-900 p-8 md:p-12 text-white">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2"><?= htmlspecialchars($disease['name']) ?></h1>
                    <p class="text-xl italic text-green-200"><?= htmlspecialchars($disease['scientific_name']) ?></p>
                </div>
                <div class="p-8 md:p-12 space-y-12">
                    <section>
                        <h2 class="text-2xl font-bold text-green-900 mb-4 flex items-center gap-3">
                            <span class="material-symbols-outlined text-green-700">info</span> Deskripsi
                        </h2>
                        <div class="text-gray-700 leading-relaxed space-y-4">
                            <?= nl2br(htmlspecialchars($disease['description'])) ?>
                        </div>
                    </section>

                    <section class="bg-green-50 p-8 rounded-2xl border border-green-100">
                        <h2 class="text-2xl font-bold text-green-900 mb-4 flex items-center gap-3">
                            <span class="material-symbols-outlined text-green-700">shutter_speed</span> Solusi & Penanganan
                        </h2>
                        <div class="text-green-900 leading-relaxed">
                            <?= nl2br(htmlspecialchars($disease['solution'])) ?>
                        </div>
                    </section>
                </div>
            </div>

            <div class="mt-8 bg-orange-50 border border-orange-100 p-6 rounded-2xl flex items-start gap-4">
                <span class="material-symbols-outlined text-orange-600">warning</span>
                <div>
                    <h4 class="font-bold text-orange-900 mb-1">Penting!</h4>
                    <p class="text-orange-800 text-sm">Gunakan fitur diagnosa untuk mendapatkan hasil yang lebih akurat berdasarkan gejala spesifik yang muncul pada pohon durian Anda.</p>
                    <a href="diagnosa.php" class="inline-block mt-3 bg-orange-500 text-white px-4 py-2 rounded-full text-xs font-bold hover:bg-orange-600 transition shadow-sm">Mulai Diagnosa</a>
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
