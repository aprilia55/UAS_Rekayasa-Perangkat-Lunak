<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

// Ambil data kendaraan yang tersedia
$kendaraan = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE status='tersedia'");

// Ambil data pelanggan
$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");

// Proses simpan transaksi
if (isset($_POST['simpan'])) {
    $id_kendaraan = $_POST['kendaraan'];
    $id_pelanggan = $_POST['pelanggan'];
    $tgl_sewa = $_POST['tgl_sewa'];
    $tgl_kembali = $_POST['tgl_kembali'];

    // Ambil harga sewa kendaraan
    $k = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT harga_sewa FROM kendaraan WHERE id_kendaraan='$id_kendaraan'"));
    $harga = $k['harga_sewa'];

    // Hitung lama sewa
    $lama = max(1, (strtotime($tgl_kembali) - strtotime($tgl_sewa)) / (60*60*24));
    $total_biaya = $lama * $harga;

    // Denda awal = 0
    $denda = 0;

    mysqli_query($koneksi, "INSERT INTO sewa (
        id_kendaraan, id_pelanggan, tanggal_sewa, tanggal_kembali, total_biaya, denda, status
    ) VALUES (
        '$id_kendaraan', '$id_pelanggan', '$tgl_sewa', '$tgl_kembali', '$total_biaya', '$denda', 'Disewa'
    )");

    // Update status kendaraan jadi 'Disewa'
    mysqli_query($koneksi, "UPDATE kendaraan SET status='Disewa' WHERE id_kendaraan='$id_kendaraan'");

    echo "<script>alert('Transaksi berhasil ditambah'); window.location='sewa.php'</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi | Lets Goo</title>
    <link rel="stylesheet" href="/sewa_kendaraan/assets/dashboard.css?v=4">
    <style>
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        .form-card {
            display: flex;
            max-width: 1000px;
            width: 100%;
            border-radius: 18px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            background: white;
        }

        .form-left {
            flex: 1;
            padding: 50px 40px;
        }

        .form-left h2 {
            color: #1e3a8a;
            margin-bottom: 25px;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 6px;
            color: #1e293b;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 14px;
            font-size: 15px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            transition: 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
            outline: none;
        }

        .form-actions {
            margin-top: 30px;
        }

        .form-actions button {
            background: #2563eb;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
            transition: 0.3s;
        }

        .form-actions button:hover {
            background: #1e40af;
        }

        .form-actions a {
            margin-left: 20px;
            color: #64748b;
            font-size: 14px;
            text-decoration: none;
        }

        .form-right {
            flex: 1;
            background: url('/sewa_kendaraan/assets/img/payment.png') center/cover no-repeat;
            min-width: 300px;
        }

        @media screen and (max-width: 900px) {
            .form-card {
                flex-direction: column;
            }
            .form-right {
                height: 250px;
            }
        }
    </style>
</head>
<body>

<div class="form-card">
    <div class="form-left">
        <h2>Tambah Transaksi</h2>
        <form method="post">
            <div class="form-group">
                <label>Kendaraan</label>
                <select name="kendaraan" required>
                    <option value="">- Pilih Kendaraan -</option>
                    <?php while($k = mysqli_fetch_assoc($kendaraan)) : ?>
                        <option value="<?= $k['id_kendaraan'] ?>"><?= $k['nama_kendaraan'] ?> (<?= $k['plat_nomor'] ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Pelanggan</label>
                <select name="pelanggan" required>
                    <option value="">- Pilih Pelanggan -</option>
                    <?php while($p = mysqli_fetch_assoc($pelanggan)) : ?>
                        <option value="<?= $p['id_pelanggan'] ?>"><?= $p['nama'] ?> (<?= $p['no_hp'] ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal Sewa</label>
                <input type="date" name="tgl_sewa" required>
            </div>

            <div class="form-group">
                <label>Tanggal Kembali</label>
                <input type="date" name="tgl_kembali" required>
            </div>

            <div class="form-actions">
                <button name="simpan">Simpan</button>
                <a href="sewa.php">Kembali</a>
            </div>
        </form>
    </div>

    <div class="form-right"></div>
</div>

</body>
</html>
