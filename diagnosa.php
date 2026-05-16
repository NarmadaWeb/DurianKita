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
                <a href="diagnosa.php" class="nav-link active">Diagnosa</a>
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
        <div class="container" style="max-width: 64rem;">
            <div class="mb-12 text-center">
                <h1 class="section-title" style="color: var(--primary-dark);">Diagnosa Penyakit Durian</h1>
                <p class="text-gray-600">Silakan masukkan nama Anda dan pilih gejala-gejala yang terlihat pada pohon durian Anda.</p>
            </div>

            <form action="hasil.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

                <!-- Farmer Name -->
                <div class="card" style="max-width: 32rem; margin: 0 auto 3rem auto;">
                    <label class="form-label" for="farmer_name">Nama Lengkap Anda</label>
                    <input type="text" name="farmer_name" id="farmer_name" placeholder="Masukkan nama Anda..." class="form-control" required>
                </div>

                <!-- Symptoms Selection -->
                <div class="symptoms-grid">
                    <?php foreach ($symptoms_by_cat as $cat => $symptoms): ?>
                        <div class="category-card">
                            <div class="category-header">
                                <span class="material-symbols-outlined" style="color: var(--primary);">
                                    <?php
                                    switch($cat) {
                                        case 'Daun': echo 'eco'; break;
                                        case 'Batang': echo 'forest'; break;
                                        case 'Buah': echo 'nutrition'; break;
                                        case 'Akar': echo 'grass'; break;
                                    }
                                    ?>
                                </span>
                                <h3 class="category-title"><?= $cat ?></h3>
                            </div>
                            <div class="category-body">
                                <?php if (count($symptoms) > 0): ?>
                                    <?php foreach ($symptoms as $s): ?>
                                        <label class="symptom-label">
                                            <input type="checkbox" name="symptom_ids[]" value="<?= $s['id'] ?>" class="symptom-checkbox">
                                            <span style="font-size: 0.875rem; color: var(--gray-700);"><?= htmlspecialchars($s['name']) ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p style="color: var(--gray-400); font-size: 0.875rem; font-style: italic;">Belum ada data gejala.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center" style="margin-top: 3rem;">
                    <button type="submit" class="btn btn-primary" style="display: flex; align-items: center; gap: 0.5rem; margin: 0 auto;">
                        Proses Diagnosa <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>
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
