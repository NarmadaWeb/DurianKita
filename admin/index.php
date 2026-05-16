<?php
require_once 'header.php';

// Get stats
$stmt = $pdo->query("SELECT COUNT(*) FROM diseases");
$count_diseases = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM symptoms");
$count_symptoms = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM rules GROUP BY disease_id");
$count_rules = $stmt->rowCount();

$stmt = $pdo->query("SELECT COUNT(*) FROM diagnosis_history");
$count_history = $stmt->fetchColumn();
?>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-green-900">Dashboard Overview</h2>
    <p class="text-gray-600">Selamat datang di panel admin sistem pakar DurianCare.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Penyakit</h3>
            <span class="material-symbols-outlined text-green-600">coronavirus</span>
        </div>
        <p class="text-3xl font-bold text-gray-800"><?= $count_diseases ?></p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Gejala</h3>
            <span class="material-symbols-outlined text-green-600">conditions</span>
        </div>
        <p class="text-3xl font-bold text-gray-800"><?= $count_symptoms ?></p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Basis Aturan</h3>
            <span class="material-symbols-outlined text-green-600">account_tree</span>
        </div>
        <p class="text-3xl font-bold text-gray-800"><?= $count_rules ?></p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Diagnosa</h3>
            <span class="material-symbols-outlined text-green-600">history</span>
        </div>
        <p class="text-3xl font-bold text-gray-800"><?= $count_history ?></p>
    </div>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Diagnosa Terbaru</h3>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50">
                <th class="p-3 text-sm font-semibold text-gray-600 border-b">Tanggal</th>
                <th class="p-3 text-sm font-semibold text-gray-600 border-b">Nama Petani</th>
                <th class="p-3 text-sm font-semibold text-gray-600 border-b">Hasil Penyakit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT h.*, d.name as disease_name FROM diagnosis_history h LEFT JOIN diseases d ON h.disease_id = d.id ORDER BY h.diagnosis_date DESC LIMIT 5");
            while ($row = $stmt->fetch()):
            ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="p-3 text-sm text-gray-600 border-b"><?= date('d M Y H:i', strtotime($row['diagnosis_date'])) ?></td>
                <td class="p-3 text-sm text-gray-800 font-medium border-b"><?= htmlspecialchars($row['farmer_name']) ?></td>
                <td class="p-3 text-sm border-b">
                    <span class="<?= $row['disease_name'] ? 'text-green-700 font-semibold' : 'text-gray-500 italic' ?>">
                        <?= $row['disease_name'] ?? 'Tidak Terdeteksi' ?>
                    </span>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php if ($stmt->rowCount() == 0): ?>
            <tr>
                <td colspan="3" class="p-4 text-center text-gray-500 italic">Belum ada data diagnosa.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'footer.php'; ?>
