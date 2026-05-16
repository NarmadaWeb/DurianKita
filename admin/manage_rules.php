<?php
require_once 'header.php';

// Handle Add/Edit Rule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_rule'])) {
    if (validate_csrf_token($_POST['csrf_token'])) {
        $disease_id = (int)$_POST['disease_id'];
        $symptom_ids = $_POST['symptom_ids'] ?? [];

        // Simple approach: Delete existing symptoms for this disease and re-insert
        // This represents a "Set of symptoms" for a disease in Forward Chaining
        $stmt = $pdo->prepare("DELETE FROM rules WHERE disease_id = ?");
        $stmt->execute([$disease_id]);

        if (!empty($symptom_ids)) {
            $stmt = $pdo->prepare("INSERT INTO rules (disease_id, symptom_id) VALUES (?, ?)");
            foreach ($symptom_ids as $s_id) {
                $stmt->execute([$disease_id, (int)$s_id]);
            }
        }
        redirect('manage_rules.php', 'Basis aturan berhasil diperbarui.');
    }
}

// Get Rule for Edit
$edit_disease_id = 0;
$selected_symptoms = [];
if (isset($_GET['edit'])) {
    $edit_disease_id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT symptom_id FROM rules WHERE disease_id = ?");
    $stmt->execute([$edit_disease_id]);
    $selected_symptoms = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

$csrf_token = generate_csrf_token();
?>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-green-900">Basis Aturan (Rule Management)</h2>
    <p class="text-gray-600">Hubungkan gejala-gejala dengan penyakit untuk logika Forward Chaining.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Section -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 sticky top-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4"><?= $edit_disease_id ? 'Edit Aturan' : 'Tambah Aturan' ?></h3>
            <form action="" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Penyakit</label>
                    <select name="disease_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required <?= $edit_disease_id ? 'readonly' : '' ?>>
                        <option value="">-- Pilih Penyakit --</option>
                        <?php
                        $diseases = $pdo->query("SELECT id, name FROM diseases ORDER BY name ASC")->fetchAll();
                        foreach ($diseases as $d):
                        ?>
                        <option value="<?= $d['id'] ?>" <?= ($edit_disease_id == $d['id']) ? 'selected' : '' ?>><?= htmlspecialchars($d['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($edit_disease_id): ?>
                        <input type="hidden" name="disease_id" value="<?= $edit_disease_id ?>">
                    <?php endif; ?>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Gejala</label>
                    <div class="max-h-64 overflow-y-auto border rounded-lg p-3 space-y-2">
                        <?php
                        $symptoms = $pdo->query("SELECT id, name, category FROM symptoms ORDER BY category, name ASC")->fetchAll();
                        $current_cat = '';
                        foreach ($symptoms as $s):
                            if ($current_cat != $s['category']):
                                $current_cat = $s['category'];
                                echo "<div class='text-xs font-bold text-gray-400 uppercase mt-2'>$current_cat</div>";
                            endif;
                        ?>
                        <label class="flex items-center gap-2 hover:bg-gray-50 p-1 rounded cursor-pointer">
                            <input type="checkbox" name="symptom_ids[]" value="<?= $s['id'] ?>" <?= in_array($s['id'], $selected_symptoms) ? 'checked' : '' ?> class="rounded text-green-700 focus:ring-green-500">
                            <span class="text-sm text-gray-700"><?= htmlspecialchars($s['name']) ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" name="save_rule" class="flex-1 bg-green-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-800 transition">
                        Simpan Aturan
                    </button>
                    <?php if ($edit_disease_id): ?>
                        <a href="manage_rules.php" class="flex-1 bg-gray-200 text-center text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="p-4 text-sm font-semibold text-gray-600 border-b">Penyakit</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 border-b">Gejala-gejala</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("
                        SELECT d.id, d.name, GROUP_CONCAT(s.name SEPARATOR ', ') as symptom_list
                        FROM rules r
                        JOIN diseases d ON r.disease_id = d.id
                        JOIN symptoms s ON r.symptom_id = s.id
                        GROUP BY d.id
                        ORDER BY d.name ASC
                    ");
                    while ($row = $stmt->fetch()):
                    ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-sm text-gray-800 font-bold border-b"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="p-4 text-sm text-gray-600 border-b">
                            <div class="line-clamp-2"><?= htmlspecialchars($row['symptom_list']) ?></div>
                        </td>
                        <td class="p-4 text-sm border-b text-center">
                            <div class="flex justify-center gap-2">
                                <a href="?edit=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 p-1">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if ($stmt->rowCount() == 0): ?>
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-500 italic">Belum ada aturan yang dikonfigurasi.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
