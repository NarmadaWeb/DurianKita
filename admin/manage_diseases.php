<?php
require_once 'header.php';

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_disease'])) {
    if (validate_csrf_token($_POST['csrf_token'])) {
        $name = sanitize($_POST['name']);
        $scientific_name = sanitize($_POST['scientific_name']);
        $description = sanitize($_POST['description']);
        $solution = sanitize($_POST['solution']);
        $prevention = sanitize($_POST['prevention']);
        $maintenance = sanitize($_POST['maintenance']);
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE diseases SET name = ?, scientific_name = ?, description = ?, solution = ?, prevention = ?, maintenance = ? WHERE id = ?");
            $stmt->execute([$name, $scientific_name, $description, $solution, $prevention, $maintenance, $id]);
            redirect('manage_diseases.php', 'Penyakit berhasil diperbarui.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO diseases (name, scientific_name, description, solution, prevention, maintenance) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $scientific_name, $description, $solution, $prevention, $maintenance]);
            redirect('manage_diseases.php', 'Penyakit berhasil ditambahkan.');
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM diseases WHERE id = ?");
    $stmt->execute([$id]);
    redirect('manage_diseases.php', 'Penyakit berhasil dihapus.');
}

// Get Disease for Edit
$edit_disease = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM diseases WHERE id = ?");
    $stmt->execute([$id]);
    $edit_disease = $stmt->fetch();
}

$csrf_token = generate_csrf_token();
?>

<div class="mb-8">
    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Penyakit</h2>
    <p class="text-gray-500 mt-1">Tambah, ubah, atau hapus data penyakit durian.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Section -->
    <div class="lg:col-span-1">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 sticky top-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6"><?= $edit_disease ? 'Edit Penyakit' : 'Tambah Penyakit Baru' ?></h3>
            <form action="" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <?php if ($edit_disease): ?>
                    <input type="hidden" name="id" value="<?= $edit_disease['id'] ?>">
                <?php endif; ?>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Penyakit</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" value="<?= $edit_disease['name'] ?? '' ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Ilmiah</label>
                    <input type="text" name="scientific_name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" value="<?= $edit_disease['scientific_name'] ?? '' ?>">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"><?= $edit_disease['description'] ?? '' ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Solusi / Penanganan</label>
                    <textarea name="solution" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"><?= $edit_disease['solution'] ?? '' ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Pencegahan</label>
                    <textarea name="prevention" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"><?= $edit_disease['prevention'] ?? '' ?></textarea>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Perawatan</label>
                    <textarea name="maintenance" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"><?= $edit_disease['maintenance'] ?? '' ?></textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit" name="save_disease" class="flex-1 bg-green-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-800 transition">
                        Simpan
                    </button>
                    <?php if ($edit_disease): ?>
                        <a href="manage_diseases.php" class="flex-1 bg-gray-200 text-center text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider text-center w-16">ID</th>
                        <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider">Nama Penyakit</th>
                        <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider">Nama Ilmiah</th>
                        <th class="p-6 text-sm font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM diseases ORDER BY id DESC");
                    while ($row = $stmt->fetch()):
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                        <td class="p-6 text-sm text-gray-500 text-center font-mono"><?= $row['id'] ?></td>
                        <td class="p-6 text-sm text-gray-900 font-bold"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="p-6 text-sm text-gray-600 italic"><?= htmlspecialchars($row['scientific_name']) ?></td>
                        <td class="p-6 text-sm text-center">
                            <div class="flex justify-center gap-2">
                                <a href="?edit=<?= $row['id'] ?>" class="inline-flex p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <a href="?delete=<?= $row['id'] ?>" class="inline-flex p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('Yakin ingin menghapus penyakit ini?')">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if ($stmt->rowCount() == 0): ?>
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500 italic">Belum ada data penyakit.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
