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
                <a href="index.php" class="nav-link active">Beranda</a>
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

    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-bg">
                <img alt="Durian Orchard" src="assets/img/hero-bg.jpg"/>
            </div>
            <div class="container hero-content">
                <div>
                    <h1 class="hero-title">Sistem Pakar Diagnosa Penyakit Durian</h1>
                    <p class="hero-text">Identifikasi cepat penyakit pada tanaman durian Anda menggunakan metode Forward Chaining dan dapatkan solusi tepat dari pakar otomatis.</p>
                    <div class="btn-group">
                        <a href="diagnosa.php" class="btn btn-primary">
                            Mulai Diagnosa Sekarang
                        </a>
                        <a href="katalog.php" class="btn btn-outline">
                            Lihat Daftar Penyakit
                        </a>
                    </div>
                </div>
                <div class="hero-img">
                    <img alt="Fresh Durian" src="assets/img/durian.jpg"/>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats">
            <div class="container">
                <div class="stats-grid">
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) FROM diseases");
                    $d_count = $stmt->fetchColumn();
                    $stmt = $pdo->query("SELECT COUNT(*) FROM diagnosis_history");
                    $h_count = $stmt->fetchColumn();
                    ?>
                    <div class="stat-card">
                        <p class="stat-value"><?= $d_count ?>+</p>
                        <p class="stat-label">Penyakit Terdaftar</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-value"><?= $h_count ?>+</p>
                        <p class="stat-label">Petani Terbantu</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-value">95%</p>
                        <p class="stat-label">Akurasi Logika</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-value">&lt; 1m</p>
                        <p class="stat-label">Respons Cepat</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Fitur Unggulan DurianCare</h2>
                    <p class="section-subtitle">Teknologi modern untuk memastikan kesehatan kebun durian Anda tetap optimal.</p>
                </div>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span class="material-symbols-outlined" style="font-size: 2rem;">psychology</span>
                        </div>
                        <h3 class="feature-title">Forward Chaining</h3>
                        <p class="feature-text">Metode penalaran logis dari fakta ke kesimpulan untuk diagnosa yang akurat dan transparan.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span class="material-symbols-outlined" style="font-size: 2rem;">menu_book</span>
                        </div>
                        <h3 class="feature-title">Katalog Penyakit</h3>
                        <p class="feature-text">Basis pengetahuan lengkap tentang gejala, penyebab, dan langkah penanganan penyakit durian.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span class="material-symbols-outlined" style="font-size: 2rem;">shield_check</span>
                        </div>
                        <h3 class="feature-title">Keamanan Terjamin</h3>
                        <p class="feature-text">Dilengkapi dengan proteksi CSRF untuk menjaga integritas data selama proses diagnosa.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container footer-content">
            <div class="footer-logo">
                <span class="footer-logo-text">DurianCare</span>
                <p class="footer-copy">© <?= get_current_year() ?> DurianCare Expert. All Rights Reserved.</p>
            </div>
            <div class="footer-links">
                <a href="#" class="footer-link">Kebijakan Privasi</a>
                <a href="#" class="footer-link">Syarat & Ketentuan</a>
                <a href="#" class="footer-link">Kontak</a>
            </div>
        </div>
    </footer>
</body>
</html>
