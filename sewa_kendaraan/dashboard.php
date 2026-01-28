<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

include "config/koneksi.php";

/* HITUNG DATA STATISTIK */
$q1 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kendaraan");
$totalKendaraan = mysqli_fetch_assoc($q1)['total'] ?? 0;

$q2 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pelanggan");
$totalPelanggan = mysqli_fetch_assoc($q2)['total'] ?? 0;

$q3 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM sewa");
$totalTransaksi = mysqli_fetch_assoc($q3)['total'] ?? 0;

$q4 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM sewa WHERE status='Disewa'");
$sedangDisewa = mysqli_fetch_assoc($q4)['total'] ?? 0;

$q5 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM sewa WHERE status='Kembali'");
$sudahKembali = mysqli_fetch_assoc($q5)['total'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | Lets Goo</title>
    <link rel="stylesheet" href="/sewa_kendaraan/assets/dashboard.css?v=2">
    <style>
        /* ===================== ANIMASI STAT CARD ===================== */
        .stat-card {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.5s ease;
        }
        .stat-card.show {
            opacity: 1;
            transform: translateY(0);
        }
        .stat-card.touch-anim {
            animation: bounce 0.4s ease;
        }
        @keyframes bounce {
            0% { transform: scale(1); }
            30% { transform: scale(1.1); }
            60% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>🚗 Lets Goo</h2>
    <div class="admin-box">
        <div class="admin-avatar">👤</div>
        <div class="admin-info">
            <span class="admin-role">Administrator</span>
            <span class="admin-name">Admin Utama</span>
        </div>
    </div>
    <a href="kendaraan/index.php">Data Kendaraan</a>
    <a href="pelanggan/index.php">Data Pelanggan</a>
    <a href="transaksi/sewa.php">Transaksi</a>
    <a href="laporan.php">Laporan</a>
    <a href="auth/logout.php">Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

    <!-- HEADER PROFESIONAL DENGAN GAMBAR DI KANAN -->
    <div class="header-card">
        <div class="header-left">
            <h1>Panel Administrasi Sistem</h1>
            <p>Manajemen Operasional Sewa Kendaraan</p>
            <div class="header-date">
                <span class="label-date">Tanggal Sistem</span>
                <span class="value-date"><?= date("d F Y") ?></span>
            </div>
        </div>
        <div class="header-right"></div>
    </div>

    <!-- STATISTIK -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="icon">🚘</div>
            <div>
                <h2><?= $totalKendaraan ?></h2>
                <span>Total Kendaraan</span>
            </div>
        </div>
        <div class="stat-card green">
            <div class="icon">👥</div>
            <div>
                <h2><?= $totalPelanggan ?></h2>
                <span>Total Pelanggan</span>
            </div>
        </div>
        <div class="stat-card orange">
            <div class="icon">📄</div>
            <div>
                <h2><?= $totalTransaksi ?></h2>
                <span>Total Transaksi</span>
            </div>
        </div>
        <div class="stat-card red">
            <div class="icon">🔄</div>
            <div>
                <h2><?= $sedangDisewa ?></h2>
                <span>Sedang Disewa</span>
            </div>
        </div>
        <div class="stat-card cyan">
            <div class="icon">✅</div>
            <div>
                <h2><?= $sudahKembali ?></h2>
                <span>Sudah Kembali</span>
            </div>
        </div>
    </div>

    <!-- WELCOME CARD -->
    <div class="welcome-card">
        <h2>Sistem Informasi Manajemen Sewa Kendaraan</h2>
        <p>
            Dashboard ini digunakan untuk memantau serta mengelola seluruh aktivitas penyewaan kendaraan,
            termasuk pengelolaan data kendaraan, data pelanggan, dan transaksi sewa.
            Silakan gunakan menu navigasi di sebelah kiri untuk mengakses fitur sistem secara lengkap.
        </p>
    </div>

</div>

<!-- SCRIPT ANIMASI STAT CARD -->
<script>
    const stats = document.querySelectorAll('.stat-card');

    function animateStats() {
        stats.forEach(stat => {
            const rect = stat.getBoundingClientRect();
            if (rect.top < window.innerHeight - 50) {
                stat.classList.add('show');
            }
        });
    }

    // Trigger saat scroll dan saat load
    window.addEventListener('scroll', animateStats);
    window.addEventListener('load', animateStats);

    // Tambahkan animasi saat klik/touch
    stats.forEach(stat => {
        stat.addEventListener('click', () => {
            stat.classList.add('touch-anim');
            stat.addEventListener('animationend', () => {
                stat.classList.remove('touch-anim');
            }, { once: true });
        });
    });
</script>

</body>
</html>
