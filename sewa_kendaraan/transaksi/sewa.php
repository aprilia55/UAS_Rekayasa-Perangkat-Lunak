<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Sewa | Lets Goo</title>
    <link rel="stylesheet" href="../assets/dashboard.css?v=6">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 220px;
            background: #1e3a8a;
            height: 100vh;
            position: fixed;
            padding: 20px;
            color: white;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            color: white;
            margin-bottom: 8px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #2563eb;
        }

        .content {
            margin-left: 240px;
            padding: 30px;
        }

        .card {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #1e3a8a;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            transition: 0.3s;
            display: inline-block;
            margin-bottom: 15px;
        }

        .btn-add { background: #2563eb; }
        .btn-add:hover { background: #1e40af; }
        .btn-edit { background: #16a34a; }
        .btn-edit:hover { background: #15803d; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #e2e8f0;
            padding: 12px 10px;
            text-align: center;
            font-size: 14px;
            word-wrap: break-word;
        }

        th {
            background: #f3f4f6;
            color: #1e3a8a;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        tr:hover {
            background: #edf2f7;
        }

        @media screen and (max-width: 900px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
                padding: 15px;
            }
            table {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Rental</h2>
    <a href="../dashboard.php">Dashboard</a>
    <a href="../kendaraan/index.php">Data Kendaraan</a>
    <a href="../pelanggan/index.php">Data Pelanggan</a>
    <a href="sewa.php">Transaksi</a>
    <a href="../laporan/laporan.php">Laporan</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<div class="content">
    <div class="card">
        <h2>Transaksi Sewa Kendaraan</h2>
        <a href="tambah.php" class="btn btn-add">+ Transaksi Baru</a>

        <table>
            <tr>
                <th>No</th>
                <th>ID Sewa</th>
                <th>Pelanggan</th>
                <th>Kendaraan</th>
                <th>Tgl Sewa</th>
                <th>Tgl Kembali</th>
                <th>Total Biaya</th>
                <th>Denda</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "
                SELECT s.*, p.nama AS nama_pelanggan, k.nama_kendaraan, k.harga_sewa
                FROM sewa s
                JOIN pelanggan p ON s.id_pelanggan = p.id_pelanggan
                JOIN kendaraan k ON s.id_kendaraan = k.id_kendaraan
                ORDER BY s.id_sewa DESC
            ");

            while ($d = mysqli_fetch_assoc($data)) {
                $tgl_sewa = strtotime($d['tanggal_sewa']);
                $tgl_kembali = strtotime($d['tanggal_kembali']);
                $lama = max(1, ($tgl_kembali - $tgl_sewa)/(60*60*24));
                $total_biaya = $lama * $d['harga_sewa'];
                $denda = 0;
                if (strcasecmp($d['status'], "Disewa") == 0 && time() > $tgl_kembali) {
                    $terlambat = (time() - $tgl_kembali)/(60*60*24);
                    $denda = $terlambat * 50000;
                }
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['id_sewa'] ?></td>
                <td><?= $d['nama_pelanggan'] ?></td>
                <td><?= $d['nama_kendaraan'] ?></td>
                <td><?= $d['tanggal_sewa'] ?></td>
                <td><?= $d['tanggal_kembali'] ?></td>
                <td>Rp <?= number_format($total_biaya) ?></td>
                <td>Rp <?= number_format($denda) ?></td>
                <td><?= $d['status'] ?></td>
                <td>
                    <?php if(strcasecmp($d['status'], "Disewa") == 0): ?>
                        <a href="kembali.php?id=<?= $d['id_sewa'] ?>" class="btn btn-edit">Pengembalian</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
