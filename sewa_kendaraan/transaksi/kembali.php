<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

// Ambil data sewa
$data = mysqli_query($koneksi,
    "SELECT s.*, p.nama AS nama_pelanggan, k.nama_kendaraan, k.harga_sewa
     FROM sewa s
     JOIN pelanggan p ON s.id_pelanggan = p.id_pelanggan
     JOIN kendaraan k ON s.id_kendaraan = k.id_kendaraan
     WHERE s.id_sewa='$_GET[id]'"
);
$s = mysqli_fetch_assoc($data);

if (!$s) {
    echo "<script>alert('Data tidak ditemukan'); window.location='sewa.php'</script>";
    exit;
}

if (isset($_POST['kembali'])) {
    $tgl_kembali = $_POST['tgl_kembali'];

    // Hitung lama sewa
    $hari = (strtotime($tgl_kembali) - strtotime($s['tanggal_sewa'])) / (60*60*24);
    if ($hari < 1) $hari = 1;

    $total = $hari * $s['harga_sewa'];

    // Denda misal sewa lebih dari 3 hari
    $denda = ($hari > 3) ? ($hari - 3) * 50000 : 0;

    // Update tabel sewa
    mysqli_query($koneksi, "UPDATE sewa SET
        tanggal_kembali='$tgl_kembali',
        total_biaya='$total',
        denda='$denda',
        status='Kembali'
        WHERE id_sewa='$_GET[id]'");

    // Update kendaraan jadi tersedia
    mysqli_query($koneksi, "UPDATE kendaraan SET status='tersedia' WHERE id_kendaraan='$s[id_kendaraan]'");

    echo "<script>alert('Pengembalian berhasil'); window.location='sewa.php'</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengembalian Kendaraan | Lets Goo</title>
    <link rel="stylesheet" href="../assets/dashboard.css?v=4">
    <style>
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }
        .form-card {
            max-width: 600px;
            width: 100%;
            border-radius: 18px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            background: white;
            padding: 40px 30px;
        }
        h2 { color: #1e3a8a; margin-bottom: 20px; font-size: 26px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 500; margin-bottom: 6px; color: #1e293b; }
        .form-group input { width: 100%; padding: 12px 14px; font-size: 15px; border: 1px solid #cbd5e1; border-radius: 10px; transition: 0.3s; }
        .form-group input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.15); outline: none; }
        .form-actions { margin-top: 25px; }
        .form-actions button {
            background: #16a34a;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
            transition: 0.3s;
        }
        .form-actions button:hover { background: #15803d; }
        .form-actions a { margin-left: 20px; color: #64748b; font-size: 14px; text-decoration: none; }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Pengembalian Kendaraan</h2>

    <div class="form-group">
        <label>Pelanggan</label>
        <input type="text" value="<?= $s['nama_pelanggan'] ?>" disabled>
    </div>

    <div class="form-group">
        <label>Kendaraan</label>
        <input type="text" value="<?= $s['nama_kendaraan'] ?>" disabled>
    </div>

    <div class="form-group">
        <label>Tanggal Sewa</label>
        <input type="date" value="<?= $s['tanggal_sewa'] ?>" disabled>
    </div>

    <form method="post">
        <div class="form-group">
            <label>Tanggal Kembali</label>
            <input type="date" name="tgl_kembali" required value="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-actions">
            <button name="kembali">Proses Pengembalian</button>
            <a href="sewa.php">Batal</a>
        </div>
    </form>
</div>

</body>
</html>
