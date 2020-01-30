<?php 

session_start();

if ( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
} 

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");
require 'functions.php'; 
// Cek apakah tombol submite sudah ditekan atau belum
if (isset($_POST["submit"]) ) {

    // Cek apakah data berhasil ditambahkan atau tidak
   if (tambah($_POST) > 0 ) {
       // tampilan dengan sedikit javascript
       echo "
        <script>
            alert('Data berhasil ditambahkan!');
            document.location.href = 'index.php';
        </script>
       ";
   } else {
       echo "
       <script>
            alert('Data gagal berhasil ditambahkan!');
            document.location.href = 'index.php';
       </script>
       ";
   }
   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Data Mahasiswa</title>
</head>
<body>

<h1>Tambah data mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" require>
            </li>
            <li>
                <label for="nrp">NRP :</label>
                <input type="text" name="nrp" id="nrp">
            </li>
            <li>
                <label for="email">Email  :</label>
                <input type="text" name="email" id="email" require>
            </li>
            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" require>
            </li>
            <li>
                <label for="gambar">Gambar :</label>
                <input type="file" name="gambar" id="gambar" require>
            </li>
            <li>
               <button type="submit" name="submit">Tambah Data</button>
            </li>      
        </ul>
    
    </form>

</body>
</html>