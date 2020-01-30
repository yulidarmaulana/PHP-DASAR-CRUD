<?php
session_start();

if ( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
} 

// koneksi ke file finctions
require 'functions.php';
// ambil data dari tabel mahasiswa / query data mahasiswa
$mahasiswa = query("SELECT * FROM mahasiswa");
// tombol cari ditekan
if (isset($_POST["cari"]) ) {
    $mahasiswa = cari($_POST["keyword"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Admin</title>

    <style>
        @media print {
            .logout{
                display: none;
            }
        }
    </style>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/script.js"></script>

</head>
<body>

<a href="logout.php" class="logout">Logout</a>

<h1>Daftar Mahasiswa</h1>

<a href="tambah.php">Tambah data mahasiswa</a>
<br><br>

<form action="" method="post">

    <input type="text" name="keyword" size="30" autofocus
    placeholder="masukan keyowrd pencarian" autocomplete="off" id="keyword">
    <!-- <button type="submit" name="cari" id="tombol-cari" >Cari</button> -->

</form>

<br>

<div id="container">
    <table border="1" cellpadding="10" cellspacing="0">
    
    <tr>
        <th>No.</th>
        <th>Aksi</th>
        <th>Gambar</th>
        <th>NRP</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Jurusan</th>
    </tr>
    <?php $no= 1; ?>
    <?php foreach( $mahasiswa as $row) : ?>
    <tr>
        <td><?= $no; ?></td>
        <td>
            <a href="ubah.php?id=<?= $row["id"]; ?>">Ubah</a> |
            <a href="hapus.php?id=<?= $row["gambar"]; ?> " width="50" onclick="
            return confirm('yakin');">Hapus</a>
        </td>
        <td><img src="img/<?= $row["gambar"]; ?> " width="50"></td>
        <td><?= $row["nrp"]; ?></td>
        <td><?= $row["nama"]; ?></td>
        <td><?= $row["email"]; ?></td>
        <td><?= $row["jurusan"]; ?></td>
    </tr>
    <?php $no++; ?>
    <?php endforeach; ?>
</table>
</div>


</body>
</html>