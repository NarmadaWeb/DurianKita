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
                <a href="tentang.php" class="nav-link active">Tentang</a>
            </div>
            <div>
                <a href="admin/login.php" class="nav-link" style="display: flex; align-items: center; justify-content: center; padding: 0.5rem; border-radius: 9999px; background-color: var(--primary-light);">
                    <span class="material-symbols-outlined">account_circle</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-16">
        <div class="container" style="max-width: 56rem;">
            <div class="text-center mb-12">
                <h1 class="hero-title" style="color: var(--primary-dark); margin-bottom: 1rem;">Tentang DurianCare</h1>
                <p style="font-size: 1.125rem; color: var(--gray-600);">Menjaga kesehatan kebun durian Anda dengan kecerdasan buatan.</p>
            </div>

            <div class="card" style="padding: 2rem; display: flex; flex-direction: column; gap: 2rem;">
                <section>
                    <h2 class="section-title" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 1rem; text-align: left; display: flex; align-items: center; gap: 0.5rem;">
                        <span class="material-symbols-outlined">visibility</span> Visi Kami
                    </h2>
                    <p style="color: var(--gray-700); line-height: 1.625;">Menjadi platform digital terpercaya bagi petani durian di Indonesia untuk mendeteksi penyakit tanaman secara dini dan akurat, serta memberikan edukasi berkelanjutan demi hasil panen yang maksimal.</p>
                </section>

                <section>
                    <h2 class="section-title" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 1rem; text-align: left; display: flex; align-items: center; gap: 0.5rem;">
                        <span class="material-symbols-outlined">track_changes</span> Misi Kami
                    </h2>
                    <ul style="list-style-type: disc; padding-left: 1.25rem; color: var(--gray-700); display: flex; flex-direction: column; gap: 0.5rem;">
                        <li>Mengembangkan sistem pakar dengan algoritma Forward Chaining yang transparan dan dapat diandalkan.</li>
                        <li>Menyediakan basis pengetahuan penyakit durian yang mudah diakses oleh semua lapisan petani.</li>
                        <li>Terus memperbarui data penyakit dan solusi berdasarkan riset terbaru di bidang agrikultur.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="section-title" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 1rem; text-align: left; display: flex; align-items: center; gap: 0.5rem;">
                        <span class="material-symbols-outlined">psychology</span> Teknologi Forward Chaining
                    </h2>
                    <p style="color: var(--gray-700); line-height: 1.625;">Sistem kami menggunakan metode Forward Chaining, yaitu proses inferensi yang memulai dari sekumpulan fakta (gejala yang dipilih petani) dan bergerak maju menuju sebuah kesimpulan (diagnosa penyakit). Berbeda dengan Certainty Factor yang berbasis persentase keyakinan, Forward Chaining memberikan hasil berdasarkan kecocokan aturan yang logis dan pasti.</p>
                </section>
            </div>

            <div class="text-center" style="margin-top: 3rem;">
                <h2 class="section-title" style="color: var(--primary-dark); margin-bottom: 1.5rem;">Hubungi Kami</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <div class="card" style="padding: 1.5rem;">
                        <span class="material-symbols-outlined" style="color: var(--primary); font-size: 2rem; margin-bottom: 0.5rem;">call</span>
                        <p style="font-size: 0.875rem; color: var(--gray-500);">WhatsApp</p>
                        <p style="font-weight: 700; color: var(--primary);">+62 812-3456-7890</p>
                    </div>
                    <div class="card" style="padding: 1.5rem;">
                        <span class="material-symbols-outlined" style="color: var(--primary); font-size: 2rem; margin-bottom: 0.5rem;">mail</span>
                        <p style="font-size: 0.875rem; color: var(--gray-500);">Email</p>
                        <p style="font-weight: 700; color: var(--primary);">support@duriancare.id</p>
                    </div>
                    <div class="card" style="padding: 1.5rem;">
                        <span class="material-symbols-outlined" style="color: var(--primary); font-size: 2rem; margin-bottom: 0.5rem;">location_on</span>
                        <p style="font-size: 0.875rem; color: var(--gray-500);">Lokasi</p>
                        <p style="font-weight: 700; color: var(--primary);">Jakarta, Indonesia</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include "includes/footer.php"; ?>
