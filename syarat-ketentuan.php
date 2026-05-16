<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Syarat & Ketentuan - DurianCare Expert</title>
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
            <h1 class="section-title" style="color: var(--primary-dark); text-align: left; margin-bottom: 2rem;">Syarat & Ketentuan</h1>

            <div class="card" style="line-height: 1.8; color: var(--gray-700);">
                <p style="margin-bottom: 1.5rem;">Dengan menggunakan layanan DurianCare Expert, Anda dianggap telah membaca dan menyetujui syarat serta ketentuan penggunaan berikut:</p>

                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin: 2rem 0 1rem 0;">1. Batasan Layanan</h2>
                <p style="margin-bottom: 1rem;">Sistem pakar ini disediakan sebagai alat bantu identifikasi awal penyakit durian berdasarkan gejala yang terlihat. Hasil diagnosa tidak menggantikan saran profesional dari ahli pertanian atau penyuluh lapangan.</p>

                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin: 2rem 0 1rem 0;">2. Tanggung Jawab Pengguna</h2>
                <p style="margin-bottom: 1rem;">Pengguna bertanggung jawab penuh atas keakuratan data gejala yang dimasukkan ke dalam sistem. Keputusan tindakan yang diambil berdasarkan hasil diagnosa sistem ini merupakan tanggung jawab penuh pengguna.</p>

                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin: 2rem 0 1rem 0;">3. Penggunaan Konten</h2>
                <p style="margin-bottom: 1.5rem;">Seluruh konten yang terdapat dalam situs ini, termasuk teks, gambar, dan basis pengetahuan, dilindungi oleh hak cipta dan tidak boleh disebarluaskan tanpa izin tertulis dari pihak DurianCare.</p>

                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin: 2rem 0 1rem 0;">4. Perubahan Ketentuan</h2>
                <p>Kami berhak untuk mengubah syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan terlebih dahulu demi meningkatkan kualitas layanan kami.</p>
            </div>
        </div>
    </main>

<?php include "includes/footer.php"; ?>
