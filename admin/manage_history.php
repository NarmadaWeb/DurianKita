<?php
require_once 'header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM diagnosis_history WHERE id = ?");
    $stmt->execute([$id]);
    redirect('manage_history.php', 'Data riwayat berhasil dihapus.');
}

// Fetch all history
$stmt = $pdo->query("
    SELECT h.*, d.name as disease_name
    FROM diagnosis_history h
    LEFT JOIN diseases d ON h.disease_id = d.id
    ORDER BY h.diagnosis_date DESC
");
$history = $stmt->fetchAll();
?>

<div class="mb-8">
    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Riwayat Diagnosa</h2>
    <p class="text-gray-500 mt-1">Daftar lengkap hasil diagnosa yang dilakukan oleh pengguna.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider">Nama Petani</th>
                    <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider">Hasil Penyakit</th>
                    <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider">Gejala</th>
                    <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $h): ?>
                <tr class="hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                    <td class="p-6 text-sm text-gray-500 whitespace-nowrap">
                        <?= date('d/m/Y H:i', strtotime($h['diagnosis_date'])) ?>
                    </td>
                    <td class="p-6 text-sm font-bold text-gray-900">
                        <?= htmlspecialchars($h['farmer_name']) ?>
                    </td>
                    <td class="p-6 text-sm">
                        <?php if ($h['disease_name']): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                <?= htmlspecialchars($h['disease_name']) ?>
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                Tidak Terdeteksi
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="p-6 text-sm text-gray-600">
                        <?php
                        $s_ids = json_decode($h['selected_symptoms'], true);
                        if ($s_ids) {
                            $placeholders = str_repeat('?,', count($s_ids) - 1) . '?';
                            $stmt_s = $pdo->prepare("SELECT name FROM symptoms WHERE id IN ($placeholders)");
                            $stmt_s->execute($s_ids);
                            $names = $stmt_s->fetchAll(PDO::FETCH_COLUMN);
                            echo "<div class='line-clamp-2' title='" . htmlspecialchars(implode(', ', $names)) . "'>" . htmlspecialchars(implode(', ', $names)) . "</div>";
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>
                    <td class="p-6 text-sm text-center">
                        <a href="?delete=<?= $h['id'] ?>" class="inline-flex p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('Hapus riwayat ini?')">
                            <span class="material-symbols-outlined">delete</span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (count($history) == 0): ?>
                <tr>
                    <td colspan="5" class="p-12 text-center text-gray-500 italic">Belum ada data riwayat diagnosa.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'footer.php'; ?>
