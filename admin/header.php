<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

if (!is_admin_logged_in()) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - DurianCare Expert</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Admin specific overrides */
        body {
            background-color: var(--gray-100);
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 16rem;
            background-color: #064e3b;
            color: white;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            z-index: 50;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        .admin-sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }
        .admin-sidebar-header h1 {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            color: white;
        }
        .admin-nav {
            flex-grow: 1;
            padding: 0 1rem;
        }
        .admin-nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            color: rgba(255, 255, 255, 0.8) !important;
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
        }
        .admin-nav-link .material-symbols-outlined {
            color: rgba(255, 255, 255, 0.6);
            transition: color 0.2s;
        }
        .admin-nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white !important;
        }
        .admin-nav-link:hover .material-symbols-outlined {
            color: white;
        }
        .admin-nav-link.active {
            background-color: var(--secondary);
            color: white !important;
            font-weight: 700;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .admin-nav-link.active .material-symbols-outlined {
            color: white;
        }
        .admin-sidebar-footer {
            padding: 1rem;
            border-top: 1px solid #065f46;
        }
        .logout-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: #fecaca;
            text-decoration: none;
        }
        .logout-link:hover {
            background-color: #b91c1c;
            color: white;
        }
        .admin-main {
            flex-grow: 1;
            margin-left: 16rem;
            padding: 2rem;
            width: calc(100% - 16rem);
        }
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid transparent;
        }
        .alert-success {
            background-color: #d1fae5;
            border-color: #34d399;
            color: #065f46;
        }
        .alert-danger {
            background-color: #fee2e2;
            border-color: #f87171;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <h1>DurianCare Admin</h1>
        </div>
        <nav class="admin-nav">
            <ul class="admin-nav-list">
                <li>
                    <a href="index.php" class="admin-nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                        <span class="material-symbols-outlined">dashboard</span> Dashboard
                    </a>
                </li>
                <li>
                    <a href="manage_diseases.php" class="admin-nav-link <?= basename($_SERVER['PHP_SELF']) == 'manage_diseases.php' ? 'active' : '' ?>">
                        <span class="material-symbols-outlined">coronavirus</span> Kelola Penyakit
                    </a>
                </li>
                <li>
                    <a href="manage_symptoms.php" class="admin-nav-link <?= basename($_SERVER['PHP_SELF']) == 'manage_symptoms.php' ? 'active' : '' ?>">
                        <span class="material-symbols-outlined">conditions</span> Kelola Gejala
                    </a>
                </li>
                <li>
                    <a href="manage_rules.php" class="admin-nav-link <?= basename($_SERVER['PHP_SELF']) == 'manage_rules.php' ? 'active' : '' ?>">
                        <span class="material-symbols-outlined">account_tree</span> Basis Aturan
                    </a>
                </li>
                <li>
                    <a href="manage_history.php" class="admin-nav-link <?= basename($_SERVER['PHP_SELF']) == 'manage_history.php' ? 'active' : '' ?>">
                        <span class="material-symbols-outlined">history</span> Riwayat Diagnosa
                    </a>
                </li>
            </ul>
        </nav>
        <div class="admin-sidebar-footer">
            <a href="logout.php" class="logout-link">
                <span class="material-symbols-outlined">logout</span> Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] == 'success' ? 'success' : 'danger' ?>">
                <?= $_SESSION['message'] ?>
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            </div>
        <?php endif; ?>
