<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kontak Kami - DurianCare Expert</title>
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
                <a href="diagnosa.php" class="nav-link">Diagnosa</a>
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
            <div class="text-center mb-12">
                <h1 class="section-title" style="color: var(--primary-dark);">Kontak Kami</h1>
                <p class="text-gray-600">Punya pertanyaan atau masukan? Kami siap membantu Anda.</p>
            </div>

            <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div class="card">
                    <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1.5rem;">Informasi Kontak</h2>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 2.5rem; height: 2.5rem; background-color: var(--primary-light); color: var(--primary); border-radius: 9999px; display: flex; align-items: center; justify-content: center;">
                                <span class="material-symbols-outlined">mail</span>
                            </div>
                            <div>
                                <p style="font-size: 0.75rem; color: var(--gray-500); font-weight: 700;">EMAIL</p>
                                <p style="color: var(--gray-700);">info@duriancare.example.com</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 2.5rem; height: 2.5rem; background-color: var(--primary-light); color: var(--primary); border-radius: 9999px; display: flex; align-items: center; justify-content: center;">
                                <span class="material-symbols-outlined">call</span>
                            </div>
                            <div>
                                <p style="font-size: 0.75rem; color: var(--gray-500); font-weight: 700;">TELEPON</p>
                                <p style="color: var(--gray-700);">+62 812-3456-7890</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 2.5rem; height: 2.5rem; background-color: var(--primary-light); color: var(--primary); border-radius: 9999px; display: flex; align-items: center; justify-content: center;">
                                <span class="material-symbols-outlined">location_on</span>
                            </div>
                            <div>
                                <p style="font-size: 0.75rem; color: var(--gray-500); font-weight: 700;">ALAMAT</p>
                                <p style="color: var(--gray-700);">Jl. Kebun Durian No. 123, Bogor, Jawa Barat</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1.5rem;">Kirim Pesan</h2>
                    <form action="#" method="POST" onsubmit="alert('Pesan Anda telah terkirim!'); return false;">
                        <div class="form-group">
                            <label class="form-label" for="name">Nama</label>
                            <input type="text" id="name" class="form-control" placeholder="Nama Anda" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" class="form-control" placeholder="Email Anda" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="message">Pesan</label>
                            <textarea id="message" class="form-control" rows="4" placeholder="Apa yang ingin Anda tanyakan?" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-full" style="margin-top: 1rem;">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

<?php include "includes/footer.php"; ?>
