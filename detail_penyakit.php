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
        <div class="container" style="max-width: 56rem;">
            <a href="katalog.php" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--gray-500); margin-bottom: 2rem; font-size: 0.875rem;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--gray-500)'">
                <span class="material-symbols-outlined" style="font-size: 1rem;">arrow_back</span> Kembali ke Katalog
            </a>

            <div class="card" style="padding: 0; overflow: hidden;">
                <div style="background-color: var(--primary-dark); padding: 2rem; color: white;">
                    <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem;"><?= htmlspecialchars($disease['name']) ?></h1>
                    <p style="font-size: 1.25rem; font-style: italic; color: #a7f3d0;"><?= htmlspecialchars($disease['scientific_name']) ?></p>
                </div>
                <div style="padding: 2rem; display: flex; flex-direction: column; gap: 3rem;">
                    <section>
                        <h2 class="section-title" style="font-size: 1.5rem; color: var(--primary-dark); margin-bottom: 1rem; text-align: left; display: flex; align-items: center; gap: 0.75rem;">
                            <span class="material-symbols-outlined" style="color: var(--primary);">info</span> Deskripsi
                        </h2>
                        <div style="color: var(--gray-700); line-height: 1.625;">
                            <?= nl2br(htmlspecialchars($disease['description'])) ?>
                        </div>
                    </section>

                    <section style="background-color: var(--primary-light); padding: 2rem; border-radius: 1rem; border: 1px solid #d1fae5;">
                        <h2 class="section-title" style="font-size: 1.5rem; color: var(--primary-dark); margin-bottom: 1rem; text-align: left; display: flex; align-items: center; gap: 0.75rem;">
                            <span class="material-symbols-outlined" style="color: var(--primary);">shutter_speed</span> Solusi & Penanganan
                        </h2>
                        <div style="color: var(--primary-dark); line-height: 1.625;">
                            <?= nl2br(htmlspecialchars($disease['solution'])) ?>
                        </div>
                    </section>
                </div>
            </div>

            <div style="margin-top: 2rem; background-color: #fff7ed; border: 1px solid #ffedd5; padding: 1.5rem; border-radius: 1rem; display: flex; align-items: flex-start; gap: 1rem;">
                <span class="material-symbols-outlined" style="color: #ea580c;">warning</span>
                <div>
                    <h4 style="font-weight: 700; color: #7c2d12; margin-bottom: 0.25rem;">Penting!</h4>
                    <p style="color: #9a3412; font-size: 0.875rem;">Gunakan fitur diagnosa untuk mendapatkan hasil yang lebih akurat berdasarkan gejala spesifik yang muncul pada pohon durian Anda.</p>
                    <a href="diagnosa.php" style="display: inline-block; margin-top: 0.75rem; background-color: var(--secondary); color: white; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">Mulai Diagnosa</a>
                </div>
            </div>
        </div>
    </main>

<?php include "includes/footer.php"; ?>
