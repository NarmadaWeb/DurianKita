<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/diagnosis_engine.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: diagnosa.php');
    exit();
}

if (!validate_csrf_token($_POST['csrf_token'])) {
    die("Token keamanan tidak valid.");
}

$farmer_name = sanitize($_POST['farmer_name']);
$selected_symptom_ids = $_POST['symptom_ids'] ?? [];

// Simple Rate Limiting to prevent database spamming
$last_submit = $_SESSION['last_diagnosis_time'] ?? 0;
if (time() - $last_submit < 10) { // 10 seconds cooldown
    die("Harap tunggu sebentar sebelum melakukan diagnosa kembali.");
}
$_SESSION['last_diagnosis_time'] = time();

// Perform Diagnosis
$disease_id = perform_diagnosis($pdo, $selected_symptom_ids);

// Save to History
$symptoms_json = json_encode($selected_symptom_ids);
$stmt = $pdo->prepare("INSERT INTO diagnosis_history (farmer_name, disease_id, selected_symptoms) VALUES (?, ?, ?)");
$stmt->execute([$farmer_name, $disease_id, $symptoms_json]);

// Fetch Disease details if found
$disease = null;
if ($disease_id) {
    $stmt = $pdo->prepare("SELECT * FROM diseases WHERE id = ?");
    $stmt->execute([$disease_id]);
    $disease = $stmt->fetch();
}

// Fetch Names of Selected Symptoms
$selected_symptoms_names = [];
if (!empty($selected_symptom_ids)) {
    $placeholders = str_repeat('?,', count($selected_symptom_ids) - 1) . '?';
    $stmt = $pdo->prepare("SELECT name FROM symptoms WHERE id IN ($placeholders)");
    $stmt->execute($selected_symptom_ids);
    $selected_symptoms_names = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Hasil Diagnosa - DurianCare Expert</title>
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
            <header class="mb-12 text-center">
                <h1 class="section-title" style="color: var(--primary-dark);">Hasil Diagnosis</h1>
                <p class="text-gray-600">Nama Petani: <strong><?= htmlspecialchars($farmer_name) ?></strong> • Tanggal: <?= date('d M Y') ?></p>
            </header>

            <div class="result-grid">
                <!-- Main Result -->
                <div>
                    <?php if ($disease): ?>
                        <div class="disease-card">
                            <div style="position: absolute; right: -2rem; top: -2rem; opacity: 0.05; pointer-events: none; color: var(--primary-dark);">
                                <span class="material-symbols-outlined" style="font-size: 200px;">psychiatry</span>
                            </div>
                            <div class="badge badge-success">Penyakit Terdeteksi</div>
                            <h2 class="section-title" style="color: var(--primary-dark); margin-bottom: 0.25rem; text-align: left;"><?= htmlspecialchars($disease['name']) ?></h2>
                            <p style="font-size: 1.125rem; font-style: italic; color: var(--primary); margin-bottom: 1.5rem;"><?= htmlspecialchars($disease['scientific_name']) ?></p>

                            <div style="margin-top: 2rem;">
                                <div style="margin-bottom: 1.5rem;">
                                    <h3 style="font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                        <span class="material-symbols-outlined" style="color: var(--primary);">info</span> Deskripsi
                                    </h3>
                                    <p style="color: var(--gray-600); line-height: 1.625;"><?= htmlspecialchars($disease['description']) ?></p>
                                </div>
                                <div class="solution-box">
                                    <h3 style="font-weight: 700; color: var(--primary-dark); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                        <span class="material-symbols-outlined">shutter_speed</span> Solusi Penanganan
                                    </h3>
                                    <p style="color: var(--primary);"><?= htmlspecialchars($disease['solution']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="card text-center" style="padding: 3rem; border: 2px solid var(--gray-300);">
                            <span class="material-symbols-outlined" style="font-size: 4rem; color: var(--gray-300); margin-bottom: 1rem;">help_center</span>
                            <h2 class="section-title" style="color: var(--gray-800); margin-bottom: 0.5rem;">Tidak Terdeteksi</h2>
                            <p class="text-gray-600">Berdasarkan gejala yang Anda pilih, sistem tidak menemukan kecocokan dengan aturan penyakit yang ada. Silakan konsultasikan dengan pakar pertanian setempat.</p>
                        </div>
                    <?php endif; ?>

                    <!-- Selected Symptoms -->
                    <div class="card" style="margin-top: 2rem;">
                        <h3 style="font-weight: 700; color: var(--gray-900); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span class="material-symbols-outlined" style="color: var(--primary);">fact_check</span> Gejala yang Anda Pilih
                        </h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.75rem;">
                            <?php foreach ($selected_symptoms_names as $sname): ?>
                                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background-color: var(--gray-50); border-radius: 0.75rem; border: 1px solid var(--gray-100);">
                                    <span class="material-symbols-outlined" style="color: var(--primary); font-size: 1rem;">check_circle</span>
                                    <span style="font-size: 0.875rem; color: var(--gray-700);"><?= htmlspecialchars($sname) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Actions -->
                <div>
                    <div class="sidebar-card">
                        <h3 style="font-weight: 700; color: var(--gray-900); margin-bottom: 1.5rem;">Tindakan Lanjutan</h3>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <button onclick="window.print()" class="btn btn-primary btn-full" style="background-color: var(--primary-dark);">
                                <span class="material-symbols-outlined">print</span> Cetak Hasil
                            </button>
                            <a href="diagnosa.php" class="btn btn-outline btn-full" style="color: var(--primary-dark); border-color: var(--primary-dark);">
                                <span class="material-symbols-outlined">replay</span> Diagnosa Ulang
                            </a>
                            <a href="riwayat.php" class="btn btn-full" style="background-color: var(--gray-100); color: var(--gray-700);">
                                <span class="material-symbols-outlined">history</span> Lihat Riwayat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include "includes/footer.php"; ?>
