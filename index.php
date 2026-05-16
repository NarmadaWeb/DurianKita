<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>DurianCare Expert - Sistem Pakar Diagnosa Penyakit Durian</title>
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
                <a href="index.php" class="text-green-800 font-bold border-b-2 border-green-800 pb-1">Beranda</a>
                <a href="diagnosa.php" class="text-gray-600 hover:text-green-800 transition">Diagnosa</a>
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

    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="relative min-h-[500px] flex items-center overflow-hidden bg-green-900 text-white">
            <div class="absolute inset-0 z-0">
                <img alt="Durian Orchard" class="w-full h-full object-cover opacity-30" src="https://images.unsplash.com/photo-1550989460-0adf9ea622e2?auto=format&fit=crop&q=80&w=2000"/>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight">Sistem Pakar Diagnosa Penyakit Durian</h1>
                    <p class="text-lg text-green-100">Identifikasi cepat penyakit pada tanaman durian Anda menggunakan metode Forward Chaining dan dapatkan solusi tepat dari pakar otomatis.</p>
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="diagnosa.php" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-full font-bold shadow-lg transition transform hover:scale-105">
                            Mulai Diagnosa Sekarang
                        </a>
                        <a href="katalog.php" class="bg-white/10 hover:bg-white/20 text-white border-2 border-white/30 px-8 py-4 rounded-full font-bold backdrop-blur-sm transition">
                            Lihat Daftar Penyakit
                        </a>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <img alt="Fresh Durian" class="rounded-2xl shadow-2xl border-4 border-white/10" src="https://images.unsplash.com/photo-1548365328-8c6db3220e4c?auto=format&fit=crop&q=80&w=800"/>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-16 bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) FROM diseases");
                    $d_count = $stmt->fetchColumn();
                    $stmt = $pdo->query("SELECT COUNT(*) FROM diagnosis_history");
                    $h_count = $stmt->fetchColumn();
                    ?>
                    <div class="text-center p-6 rounded-xl bg-green-50 border border-green-100">
                        <p class="text-3xl font-bold text-green-800 mb-1"><?= $d_count ?>+</p>
                        <p class="text-gray-600 text-sm">Penyakit Terdaftar</p>
                    </div>
                    <div class="text-center p-6 rounded-xl bg-green-50 border border-green-100">
                        <p class="text-3xl font-bold text-green-800 mb-1"><?= $h_count ?>+</p>
                        <p class="text-gray-600 text-sm">Petani Terbantu</p>
                    </div>
                    <div class="text-center p-6 rounded-xl bg-green-50 border border-green-100">
                        <p class="text-3xl font-bold text-green-800 mb-1">95%</p>
                        <p class="text-gray-600 text-sm">Akurasi Logika</p>
                    </div>
                    <div class="text-center p-6 rounded-xl bg-green-50 border border-green-100">
                        <p class="text-3xl font-bold text-green-800 mb-1">&lt; 1m</p>
                        <p class="text-gray-600 text-sm">Respons Cepat</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Unggulan DurianCare</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Teknologi modern untuk memastikan kesehatan kebun durian Anda tetap optimal.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                        <div class="w-16 h-16 bg-green-100 text-green-800 rounded-full flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-3xl">psychology</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Forward Chaining</h3>
                        <p class="text-gray-600 leading-relaxed">Metode penalaran logis dari fakta ke kesimpulan untuk diagnosa yang akurat dan transparan.</p>
                    </div>
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                        <div class="w-16 h-16 bg-green-100 text-green-800 rounded-full flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-3xl">menu_book</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Katalog Penyakit</h3>
                        <p class="text-gray-600 leading-relaxed">Basis pengetahuan lengkap tentang gejala, penyebab, dan langkah penanganan penyakit durian.</p>
                    </div>
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                        <div class="w-16 h-16 bg-green-100 text-green-800 rounded-full flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-3xl">shield_check</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Keamanan Terjamin</h3>
                        <p class="text-gray-600 leading-relaxed">Dilengkapi dengan proteksi CSRF untuk menjaga integritas data selama proses diagnosa.</p>
                    </div>
                </div>
            </div>
        </section>
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
