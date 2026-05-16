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
                <a href="diagnosa.php" class="text-green-800 font-bold border-b-2 border-green-800 pb-1">Diagnosa</a>
                <a href="katalog.php" class="text-gray-600 hover:text-green-800 transition">Basis Pengetahuan</a>
                <a href="riwayat.php" class="text-gray-600 hover:text-green-800 transition">Riwayat</a>
                <a href="tentang.php" class="text-gray-600 hover:text-green-800 transition">Tentang</a>
            </div>
            <div>
                <a href="admin/login.php" class="text-green-800 hover:bg-green-50 p-2 rounded-full transition flex items-center justify-center">
                    <span class="material-symbols-outlined">account_circle</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <header class="mb-12 text-center">
                <h1 class="text-3xl font-bold text-green-900 mb-2">Hasil Diagnosis</h1>
                <p class="text-gray-600">Nama Petani: <strong><?= htmlspecialchars($farmer_name) ?></strong> • Tanggal: <?= date('d M Y') ?></p>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Result -->
                <div class="lg:col-span-2 space-y-8">
                    <?php if ($disease): ?>
                        <div class="bg-white rounded-3xl shadow-sm border-2 border-green-700 overflow-hidden relative">
                            <div class="absolute -right-8 -top-8 opacity-5 pointer-events-none text-green-900">
                                <span class="material-symbols-outlined" style="font-size: 200px;">psychiatry</span>
                            </div>
                            <div class="p-8 md:p-12">
                                <div class="inline-block bg-green-100 text-green-800 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest mb-4">Penyakit Terdeteksi</div>
                                <h2 class="text-3xl font-bold text-green-900 mb-1"><?= htmlspecialchars($disease['name']) ?></h2>
                                <p class="text-lg italic text-green-700 mb-6"><?= htmlspecialchars($disease['scientific_name']) ?></p>

                                <div class="space-y-6">
                                    <div>
                                        <h3 class="font-bold text-gray-900 mb-2 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-green-700">info</span> Deskripsi
                                        </h3>
                                        <p class="text-gray-600 leading-relaxed"><?= htmlspecialchars($disease['description']) ?></p>
                                    </div>
                                    <div class="bg-green-50 p-6 rounded-2xl border border-green-100">
                                        <h3 class="font-bold text-green-900 mb-2 flex items-center gap-2">
                                            <span class="material-symbols-outlined">shutter_speed</span> Solusi Penanganan
                                        </h3>
                                        <p class="text-green-800"><?= htmlspecialchars($disease['solution']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="bg-white rounded-3xl shadow-sm border-2 border-gray-300 p-12 text-center">
                            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">help_center</span>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Tidak Terdeteksi</h2>
                            <p class="text-gray-600">Berdasarkan gejala yang Anda pilih, sistem tidak menemukan kecocokan dengan aturan penyakit yang ada. Silakan konsultasikan dengan pakar pertanian setempat.</p>
                        </div>
                    <?php endif; ?>

                    <!-- Selected Symptoms -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-green-700">fact_check</span> Gejala yang Anda Pilih
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <?php foreach ($selected_symptoms_names as $sname): ?>
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                    <span class="material-symbols-outlined text-green-700 text-sm">check_circle</span>
                                    <span class="text-sm text-gray-700"><?= htmlspecialchars($sname) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Actions -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 sticky top-24">
                        <h3 class="font-bold text-gray-900 mb-6">Tindakan Lanjutan</h3>
                        <div class="space-y-4">
                            <button onclick="window.print()" class="w-full bg-green-800 text-white font-bold py-4 rounded-full shadow-md hover:bg-green-900 transition flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">print</span> Cetak Hasil
                            </button>
                            <a href="diagnosa.php" class="w-full bg-white text-green-800 border-2 border-green-800 font-bold py-4 rounded-full hover:bg-green-50 transition flex items-center justify-center gap-2 text-center">
                                <span class="material-symbols-outlined">replay</span> Diagnosa Ulang
                            </a>
                            <a href="riwayat.php" class="w-full bg-gray-100 text-gray-700 font-bold py-4 rounded-full hover:bg-gray-200 transition flex items-center justify-center gap-2 text-center">
                                <span class="material-symbols-outlined">history</span> Lihat Riwayat
                            </a>
                        </div>
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
