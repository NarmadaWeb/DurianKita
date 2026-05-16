<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (is_admin_logged_in()) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    if (validate_csrf_token($_POST['csrf_token'])) {
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_name'] = $admin['full_name'];
            redirect('index.php', 'Selamat datang kembali, ' . $admin['full_name']);
        } else {
            $error = 'Username atau password salah.';
        }
    } else {
        $error = 'Token keamanan tidak valid.';
    }
}

$csrf_token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - DurianCare Expert</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background-color: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 28rem;
        }
        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }
        .alert-danger {
            background-color: #fee2e2;
            border: 1px solid #f87171;
            color: #991b1b;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h1 class="login-title">DurianCare Admin</h1>

        <?php if ($error): ?>
            <div class="alert-danger">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input class="form-control" type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" type="password" name="password" id="password" required>
            </div>
            <button class="btn btn-primary btn-full" type="submit" style="margin-top: 1rem;">
                Login
            </button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="../index.php" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--gray-500); text-decoration: none; font-size: 0.875rem;">
                <span class="material-symbols-outlined" style="font-size: 1.25rem;">arrow_back</span>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
