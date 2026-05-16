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
                <a href="katalog.php" class="nav-link active">Basis Pengetahuan</a>
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
        <div class="container">
            <div class="katalog-header">
                <div>
                    <h1 class="section-title" style="color: var(--primary-dark); margin-bottom: 0.5rem; text-align: left;">Katalog Penyakit Durian</h1>
                    <p class="text-gray-600">Pelajari berbagai penyakit yang menyerang pohon durian dan cara mengatasinya.</p>
                </div>
                <form action="" method="GET" class="search-form">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari penyakit..." class="search-input">
                </form>
            </div>

            <?php if (count($diseases) > 0): ?>
                <div class="diseases-grid">
                    <?php foreach ($diseases as $d): ?>
                        <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                            <div style="padding: 2rem; flex-grow: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                    <div style="width: 3rem; height: 3rem; background-color: var(--primary-light); color: var(--primary); border-radius: 9999px; display: flex; align-items: center; justify-content: center;">
                                        <span class="material-symbols-outlined">coronavirus</span>
                                    </div>
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--gray-400); text-transform: uppercase; letter-spacing: 0.05em;">Penyakit</span>
                                </div>
                                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 0.25rem;"><?= htmlspecialchars($d['name']) ?></h3>
                                <p style="font-size: 0.875rem; font-style: italic; color: var(--gray-500); margin-bottom: 1rem;"><?= htmlspecialchars($d['scientific_name']) ?></p>
                                <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.625; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 1.5rem;">
                                    <?= htmlspecialchars($d['description']) ?>
                                </p>
                                <a href="detail_penyakit.php?id=<?= $d['id'] ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--primary); font-weight: 700; font-size: 0.875rem;">
                                    Lihat Detail <span class="material-symbols-outlined" style="font-size: 1rem;">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center" style="padding: 5rem 0;">
                    <span class="material-symbols-outlined" style="font-size: 4rem; color: var(--gray-200); margin-bottom: 1rem;">search_off</span>
                    <p style="color: var(--gray-500); font-style: italic;">Penyakit yang Anda cari tidak ditemukan.</p>
                </div>
            <?php endif; ?>
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
