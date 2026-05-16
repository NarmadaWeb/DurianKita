<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

// Fetch all history
$stmt = $pdo->query("
    SELECT h.*, d.name as disease_name
    FROM diagnosis_history h
    LEFT JOIN diseases d ON h.disease_id = d.id
    ORDER BY h.diagnosis_date DESC
");
$history = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Riwayat Diagnosa - DurianCare Expert</title>
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
                <a href="riwayat.php" class="nav-link active">Riwayat</a>
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
            <div class="mb-12">
                <h1 class="section-title" style="color: var(--primary-dark); text-align: left; margin-bottom: 0.5rem;">Riwayat Diagnosa</h1>
                <p class="text-gray-600">Daftar diagnosa yang telah dilakukan oleh para petani.</p>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Petani</th>
                                <th>Hasil Penyakit</th>
                                <th>Gejala Terdeteksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $h): ?>
                            <tr>
                                <td style="white-space: nowrap;">
                                    <?= date('d M Y, H:i', strtotime($h['diagnosis_date'])) ?>
                                </td>
                                <td style="font-weight: 700; color: var(--gray-900); white-space: nowrap;">
                                    <?= htmlspecialchars($h['farmer_name']) ?>
                                </td>
                                <td>
                                    <?php if ($h['disease_name']): ?>
                                        <span style="background-color: var(--primary-light); color: var(--primary); padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 600;">
                                            <?= htmlspecialchars($h['disease_name']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: var(--gray-400); font-style: italic;">Tidak Terdeteksi</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $s_ids = json_decode($h['selected_symptoms'], true);
                                    if ($s_ids) {
                                        $placeholders = str_repeat('?,', count($s_ids) - 1) . '?';
                                        $stmt = $pdo->prepare("SELECT name FROM symptoms WHERE id IN ($placeholders)");
                                        $stmt->execute($s_ids);
                                        $names = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                        echo "<div style='display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;'>" . htmlspecialchars(implode(', ', $names)) . "</div>";
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (count($history) == 0): ?>
                            <tr>
                                <td colspan="4" style="padding: 5rem; text-align: center; color: var(--gray-500); font-style: italic;">
                                    Belum ada data diagnosa. <a href="diagnosa.php" style="color: var(--primary); text-decoration: underline;">Mulai diagnosa sekarang</a>.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

<?php include "includes/footer.php"; ?>
