<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tentang Kami - DurianCare Expert</title>
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
                <a href="riwayat.php" class="text-gray-600 hover:text-green-800 transition">Riwayat</a>
                <a href="tentang.php" class="text-green-800 font-bold border-b-2 border-green-800 pb-1">Tentang</a>
            </div>
            <div>
                <a href="admin/login.php" class="text-green-800 hover:bg-green-50 p-2 rounded-full transition flex items-center justify-center">
                    <span class="material-symbols-outlined">account_circle</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-green-900 mb-4">Tentang DurianCare</h1>
                <p class="text-lg text-gray-600">Menjaga kesehatan kebun durian Anda dengan kecerdasan buatan.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 space-y-8">
                <section>
                    <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">visibility</span> Visi Kami
                    </h2>
                    <p class="text-gray-700 leading-relaxed">Menjadi platform digital terpercaya bagi petani durian di Indonesia untuk mendeteksi penyakit tanaman secara dini dan akurat, serta memberikan edukasi berkelanjutan demi hasil panen yang maksimal.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">track_changes</span> Misi Kami
                    </h2>
                    <ul class="list-disc pl-5 space-y-2 text-gray-700">
                        <li>Mengembangkan sistem pakar dengan algoritma Forward Chaining yang transparan dan dapat diandalkan.</li>
                        <li>Menyediakan basis pengetahuan penyakit durian yang mudah diakses oleh semua lapisan petani.</li>
                        <li>Terus memperbarui data penyakit dan solusi berdasarkan riset terbaru di bidang agrikultur.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">psychology</span> Teknologi Forward Chaining
                    </h2>
                    <p class="text-gray-700 leading-relaxed">Sistem kami menggunakan metode Forward Chaining, yaitu proses inferensi yang memulai dari sekumpulan fakta (gejala yang dipilih petani) dan bergerak maju menuju sebuah kesimpulan (diagnosa penyakit). Berbeda dengan Certainty Factor yang berbasis persentase keyakinan, Forward Chaining memberikan hasil berdasarkan kecocokan aturan yang logis dan pasti.</p>
                </section>
            </div>

            <div class="mt-12 text-center">
                <h2 class="text-2xl font-bold text-green-900 mb-6">Hubungi Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                        <span class="material-symbols-outlined text-green-700 text-3xl mb-2">call</span>
                        <p class="text-sm text-gray-500">WhatsApp</p>
                        <p class="font-bold text-green-800">+62 812-3456-7890</p>
                    </div>
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                        <span class="material-symbols-outlined text-green-700 text-3xl mb-2">mail</span>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-bold text-green-800">support@duriancare.id</p>
                    </div>
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                        <span class="material-symbols-outlined text-green-700 text-3xl mb-2">location_on</span>
                        <p class="text-sm text-gray-500">Lokasi</p>
                        <p class="font-bold text-green-800">Jakarta, Indonesia</p>
                    </div>
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
