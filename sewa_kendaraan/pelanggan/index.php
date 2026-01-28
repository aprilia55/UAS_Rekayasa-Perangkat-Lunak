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
    <title>Data Pelanggan | Lets Goo</title>
    <link rel="stylesheet" href="../assets/dashboard.css?v=7">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f8; margin:0; padding:0; }

        .sidebar {
            width: 220px;
            background: #1e3a8a;
            height: 100vh;
            position: fixed;
            padding: 20px;
            color: white;
        }

        .sidebar h2 { text-align: center; margin-bottom: 30px; }
        .sidebar a {
            display:block; padding:10px 15px; color:white; margin-bottom:8px;
            border-radius:8px; text-decoration:none; transition:0.3s;
        }
        .sidebar a:hover { background:#2563eb; }

        .content { margin-left:240px; padding:30px; }

        .card { background:white; padding:25px 30px; border-radius:15px; box-shadow:0 8px 25px rgba(0,0,0,0.08); }

        .card h2 { margin-top:0; margin-bottom:20px; color:#1e3a8a; }

        .btn {
            padding:8px 16px; border-radius:8px; text-decoration:none;
            color:white; font-size:14px; transition:0.3s; display:inline-block; margin-bottom:15px;
        }
        .btn-add { background:#2563eb; } .btn-add:hover { background:#1e40af; }
        .btn-edit { background:#16a34a; } .btn-edit:hover { background:#15803d; }
        .btn-delete { background:#dc2626; } .btn-delete:hover { background:#b91c1c; }

        table { width:100%; border-collapse:collapse; margin-top:10px; }
        th, td { border:1px solid #e2e8f0; padding:12px 10px; text-align:center; font-size:14px; }
        th { background:#f3f4f6; color:#1e3a8a; font-weight:600; }
        tr:nth-child(even){ background:#f9fafb; } tr:hover { background:#edf2f7; }

        @media screen and (max-width:900px) {
            .sidebar { width:100%; height:auto; position:relative; }
            .content { margin-left:0; padding:15px; }
            table { font-size:12px; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Rental</h2>
    <a href="../dashboard.php">Dashboard</a>
    <a href="../kendaraan/index.php">Data Kendaraan</a>
    <a href="index.php">Data Pelanggan</a>
    <a href="../transaksi/sewa.php">Transaksi</a>
    <a href="../laporan/laporan.php">Laporan</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<div class="content">
    <div class="card">
        <h2>Data Pelanggan</h2>
        <a href="tambah.php" class="btn btn-add">+ Tambah Pelanggan</a>

        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM pelanggan");
            while ($d = mysqli_fetch_assoc($data)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['nama'] ?></td>
                <td><?= $d['no_hp'] ?></td>
                <td><?= $d['alamat'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $d['id_pelanggan'] ?>" class="btn btn-edit">Edit</a>
                    <a href="?hapus=<?= $d['id_pelanggan'] ?>" class="btn btn-delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>

<?php
if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan='$_GET[hapus]'");
    echo "<script>alert('Data dihapus'); window.location='index.php'</script>";
}
?>
