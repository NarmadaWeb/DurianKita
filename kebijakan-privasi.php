<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kebijakan Privasi - DurianCare Expert</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="container nav-content">
            <div class="nav-logo">
                <span>DurianCare</span>
            </div>
            <div class="nav-links">
                <a href="index.php" class="nav-link">Beranda</a>
                <a href="diagnosa.php" class="nav-link">Diagnosa</a>
                <a href="katalog.php" class="nav-link">Basis Pengetahuan</a>
                <a href="riwayat.php" class="nav-link">Riwayat</a>
                <a href="tentang.php" class="nav-link">Tentang</a>
            </div>
            <div>
                <a href="admin/login.php" class="nav-link" style="display: flex; align-items: center; justify-content: center; padding: 0.5rem; border-radius: 9999px; background-color: var(--primary-light);">
                    <span class="material-symbols-outlined">account_circle</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-12">
        <div class="container" style="max-width: 48rem;">
            <h1 class="section-title" style="color: var(--primary-dark); text-align: left; margin-bottom: 2rem;">Kebijakan Privasi</h1>

            <div class="card" style="line-height: 1.8; color: var(--gray-700);">
                <p style="margin-bottom: 1.5rem;">Selamat datang di DurianCare Expert. Kami sangat menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi yang Anda bagikan kepada kami.</p>

                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin: 2rem 0 1rem 0;">1. Informasi yang Kami Kumpulkan</h2>
                <p style="margin-bottom: 1rem;">Saat Anda menggunakan fitur diagnosa kami, kami mengumpulkan informasi berupa:</p>
                <ul style="list-style-type: disc; margin-left: 1.5rem; margin-bottom: 1.5rem;">
                    <li>Nama lengkap (untuk pencatatan riwayat diagnosa).</li>
                    <li>Gejala-gejala tanaman yang Anda pilih.</li>
                    <li>Waktu dan tanggal akses sistem.</li>
                </ul>

                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin: 2rem 0 1rem 0;">2. Penggunaan Informasi</h2>
                <p style="margin-bottom: 1rem;">Data yang dikumpulkan digunakan semata-mata untuk:</p>
                <ul style="list-style-type: disc; margin-left: 1.5rem; margin-bottom: 1.5rem;">
                    <li>Memberikan hasil diagnosa penyakit durian yang akurat.</li>
                    <li>Menyimpan riwayat diagnosa agar dapat Anda lihat kembali di masa mendatang.</li>
                    <li>Meningkatkan kualitas sistem pakar kami melalui analisis data gejala anonim.</li>
                </ul>

                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin: 2rem 0 1rem 0;">3. Keamanan Data</h2>
                <p style="margin-bottom: 1.5rem;">Kami menerapkan langkah-langkah keamanan teknis seperti proteksi CSRF dan sanitasi input untuk menjaga integritas data Anda dari akses yang tidak sah.</p>

                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin: 2rem 0 1rem 0;">4. Hubungi Kami</h2>
                <p>Jika Anda memiliki pertanyaan mengenai kebijakan privasi ini, silakan hubungi kami melalui halaman Kontak.</p>
            </div>
        </div>
    </main>

<?php include "includes/footer.php"; ?>
