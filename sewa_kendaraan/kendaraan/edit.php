<?php
include "../config/koneksi.php";

$data = mysqli_query($koneksi,
    "SELECT * FROM kendaraan WHERE id_kendaraan='$_GET[id]'");
$d = mysqli_fetch_array($data);

if (isset($_POST['update'])) {
    mysqli_query($koneksi, "UPDATE kendaraan SET
        nama_kendaraan='$_POST[nama]',
        jenis='$_POST[jenis]',
        plat_nomor='$_POST[plat]',
        harga_sewa='$_POST[harga]'
        WHERE id_kendaraan='$_GET[id]'");

    echo "<script>alert('Data diupdate');
          window.location='index.php'</script>";
}
?>

<h2>Edit Kendaraan</h2>

<form method="post">
    Nama <br>
    <input type="text" name="nama" value="<?= $d['nama_kendaraan'] ?>"><br><br>

    Jenis <br>
    <select name="jenis">
        <option value="<?= $d['jenis'] ?>"><?= $d['jenis'] ?></option>
        <option value="Bus">Bus</option>
        <option value="Minibus">Minibus</option>
        <option value="Motor">Motor</option>
    </select><br><br>

    Plat <br>
    <input type="text" name="plat" value="<?= $d['plat_nomor'] ?>"><br><br>

    Harga <br>
    <input type="number" name="harga" value="<?= $d['harga_sewa'] ?>"><br><br>

    <button name="update">Update</button>
    <a href="index.php">Kembali</a>
</form>
