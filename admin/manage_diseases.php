<?php
require_once 'header.php';

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_disease'])) {
    if (validate_csrf_token($_POST['csrf_token'])) {
        $name = sanitize($_POST['name']);
        $scientific_name = sanitize($_POST['scientific_name']);
        $description = sanitize($_POST['description']);
        $solution = sanitize($_POST['solution']);
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE diseases SET name = ?, scientific_name = ?, description = ?, solution = ? WHERE id = ?");
            $stmt->execute([$name, $scientific_name, $description, $solution, $id]);
            redirect('manage_diseases.php', 'Penyakit berhasil diperbarui.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO diseases (name, scientific_name, description, solution) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $scientific_name, $description, $solution]);
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

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-green-900">Kelola Penyakit</h2>
        <p class="text-gray-600">Tambah, ubah, atau hapus data penyakit durian.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Section -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 sticky top-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4"><?= $edit_disease ? 'Edit Penyakit' : 'Tambah Penyakit Baru' ?></h3>
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
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Solusi / Penanganan</label>
                    <textarea name="solution" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"><?= $edit_disease['solution'] ?? '' ?></textarea>
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="p-4 text-sm font-semibold text-gray-600 border-b w-16 text-center">ID</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 border-b">Nama Penyakit</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 border-b">Nama Ilmiah</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM diseases ORDER BY id DESC");
                    while ($row = $stmt->fetch()):
                    ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-sm text-gray-600 border-b text-center"><?= $row['id'] ?></td>
                        <td class="p-4 text-sm text-gray-800 font-bold border-b"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="p-4 text-sm text-gray-600 italic border-b"><?= htmlspecialchars($row['scientific_name']) ?></td>
                        <td class="p-4 text-sm border-b text-center">
                            <div class="flex justify-center gap-2">
                                <a href="?edit=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 p-1">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <a href="?delete=<?= $row['id'] ?>" class="text-red-600 hover:text-red-800 p-1" onclick="return confirm('Yakin ingin menghapus penyakit ini?')">
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
