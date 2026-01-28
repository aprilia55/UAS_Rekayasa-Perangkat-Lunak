<?php
include "../config/koneksi.php";

if (isset($_POST['simpan'])) {
    mysqli_query($koneksi, "INSERT INTO kendaraan VALUES (
        '',
        '$_POST[nama]',
        '$_POST[jenis]',
        '$_POST[plat]',
        '$_POST[harga]',
        'tersedia'
    )");

    echo "<script>alert('Data berhasil ditambah'); window.location='index.php'</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kendaraan | Lets Goo</title>
    <link rel="stylesheet" href="/sewa_kendaraan/assets/dashboard.css?v=1">
    <style>
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        /* CARD PROFESIONAL LEBAR */
        .form-card {
            display: flex;
            max-width: 1000px;
            width: 100%;
            border-radius: 18px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            background: white;
        }

        /* FORM BAGIAN KIRI */
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

        /* GAMBAR HIASAN DI KANAN */
        .form-right {
            flex: 1;
            background: url('/sewa_kendaraan/assets/img/form-decor.png') center/cover no-repeat;
            min-width: 300px;
        }

        /* RESPONSIVE */
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
        <h2>Tambah Kendaraan</h2>
        <form method="post">
            <div class="form-group">
                <label>Nama Kendaraan</label>
                <input type="text" name="nama" required>
            </div>

            <div class="form-group">
                <label>Jenis Kendaraan</label>
                <select name="jenis" required>
                    <option value="">- Pilih -</option>
                    <option value="Bus">Bus</option>
                    <option value="Minibus">Minibus</option>
                    <option value="Motor">Motor</option>
                </select>
            </div>

            <div class="form-group">
                <label>Plat Nomor</label>
                <input type="text" name="plat" required>
            </div>

            <div class="form-group">
                <label>Harga Sewa / Hari</label>
                <input type="number" name="harga" required>
            </div>

            <div class="form-actions">
                <button name="simpan">Simpan</button>
                <a href="index.php">Kembali</a>
            </div>
        </form>
    </div>

    <div class="form-right"></div>
</div>

</body>
</html>
