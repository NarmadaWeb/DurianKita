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
    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Overview</h2>
    <p class="text-gray-500 mt-1">Selamat datang di panel kendali DurianCare Expert.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-6">
            <div class="p-3 bg-green-50 rounded-xl">
                <span class="material-symbols-outlined text-green-700">coronavirus</span>
            </div>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Penyakit</span>
        </div>
        <p class="text-4xl font-black text-gray-900"><?= $count_diseases ?></p>
    </div>
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-6">
            <div class="p-3 bg-blue-50 rounded-xl">
                <span class="material-symbols-outlined text-blue-700">conditions</span>
            </div>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Gejala</span>
        </div>
        <p class="text-4xl font-black text-gray-900"><?= $count_symptoms ?></p>
    </div>
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-6">
            <div class="p-3 bg-orange-50 rounded-xl">
                <span class="material-symbols-outlined text-orange-700">account_tree</span>
            </div>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Basis Aturan</span>
        </div>
        <p class="text-4xl font-black text-gray-900"><?= $count_rules ?></p>
    </div>
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-6">
            <div class="p-3 bg-purple-50 rounded-xl">
                <span class="material-symbols-outlined text-purple-700">history</span>
            </div>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Diagnosa</span>
        </div>
        <p class="text-4xl font-black text-gray-900"><?= $count_history ?></p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
        <h3 class="text-xl font-bold text-gray-900">Diagnosa Terbaru</h3>
        <a href="manage_history.php" class="text-sm font-semibold text-green-700 hover:text-green-800">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider">Nama Petani</th>
                    <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider">Hasil Penyakit</th>
                </tr>
            </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT h.*, d.name as disease_name FROM diagnosis_history h LEFT JOIN diseases d ON h.disease_id = d.id ORDER BY h.diagnosis_date DESC LIMIT 5");
            while ($row = $stmt->fetch()):
            ?>
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="p-6 text-sm text-gray-500"><?= date('d M Y H:i', strtotime($row['diagnosis_date'])) ?></td>
                <td class="p-6 text-sm text-gray-900 font-bold"><?= htmlspecialchars($row['farmer_name']) ?></td>
                <td class="p-6 text-sm">
                    <?php if($row['disease_name']): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                            <?= htmlspecialchars($row['disease_name']) ?>
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                            Tidak Terdeteksi
                        </span>
                    <?php endif; ?>
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
