<?php
include "../config/koneksi.php";

$data = mysqli_query($koneksi,
    "SELECT * FROM pelanggan WHERE id_pelanggan='$_GET[id]'");
$p = mysqli_fetch_array($data);

if (isset($_POST['update'])) {
    mysqli_query($koneksi, "UPDATE pelanggan SET
        nama='$_POST[nama]',
        alamat='$_POST[alamat]',
        no_hp='$_POST[hp]',
        no_ktp='$_POST[ktp]'
        WHERE id_pelanggan='$_GET[id]'");

    echo "<script>alert('Data diupdate');
          window.location='index.php'</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pelanggan | Lets Goo</title>
    <link rel="stylesheet" href="/sewa_kendaraan/assets/dashboard.css?v=2">
    <style>
        /* CARD FORM PROFESIONAL */
        .form-card {
            display: grid;
            grid-template-columns: 1fr 1fr; /* kiri form | kanan gambar */
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            gap: 20px;
            max-width: 900px;
            margin: 40px auto;
        }

        .form-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-left h2 {
            margin-bottom: 20px;
            color: #1e3a8a;
        }

        .form-left label {
            font-size: 14px;
            color: #1e3a8a;
            margin-bottom: 4px;
        }

        .form-left input, 
        .form-left textarea, 
        .form-left select {
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            margin-bottom: 15px;
            font-size: 14px;
            width: 100%;
            resize: vertical;
        }

        .form-left button {
            background: #2563eb;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }

        .form-left button:hover {
            background: #1e40af;
        }

        .form-left a {
            margin-top: 10px;
            display: inline-block;
            text-decoration: none;
            color: #2563eb;
        }

        /* Gambar dekorasi di kanan */
        .form-right {
            background: url('/sewa_kendaraan/assets/img/form-pelanggan.png') center center / cover no-repeat;
            border-radius: 16px;
        }

        @media(max-width: 768px){
            .form-card {
                grid-template-columns: 1fr;
            }
            .form-right {
                height: 200px;
            }
        }
    </style>
</head>
<body>

<div class="form-card">
    <div class="form-left">
        <h2>Edit Pelanggan</h2>
        <form method="post">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($p['nama']) ?>" required>

            <label>Alamat</label>
            <textarea name="alamat" required><?= htmlspecialchars($p['alamat']) ?></textarea>

            <label>No HP</label>
            <input type="text" name="hp" value="<?= htmlspecialchars($p['no_hp']) ?>" required>

            <label>No KTP</label>
            <input type="text" name="ktp" value="<?= htmlspecialchars($p['no_ktp']) ?>" required>

            <button name="update">Update</button>
            <a href="index.php">Kembali</a>
        </form>
    </div>
    <div class="form-right"></div>
</div>

</body>
</html>
