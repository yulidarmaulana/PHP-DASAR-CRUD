<?php 
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data){
    global $conn;
     // Ambil data dari setiap elemen dalam form
     $nama = htmlspecialchars($data["nama"]);
     $nrp = htmlspecialchars($data["nrp"]);
     $email = htmlspecialchars($data["email"]);
     $jurusan = htmlspecialchars($data["jurusan"]);
     
     // Upload gambar
     $gambar = upload();
     if ( !$gambar ) {
         return false;
     }

     // Query insert data // Id harus tetap dimasukan dalam values 
    $query = "INSERT INTO mahasiswa VALUES('','$nama','$nrp','$email','$jurusan','$gambar')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload(){
    $nameFile = $_FILES['gambar']['nama'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Cek apakah tidak ada gambar yang diupload
    if ( $error === 4 ){
        echo "<script>
                alert('Pilih gambar terlebih dahulu');
             </script>";
        return false;
    }

    // Cek apakah yang diupload adalah gambar 
    $ekstensiGambarValid = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.', $nameFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if ( !in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('yang anda upload bukan gambar!');
            </script>";
        return false;
    }

    // Cek jika ukurannya teralu besar
    if ($ukuranFile) {
        echo "<script>
                alert('Ukuran gambar terlalu besar');
             </script>";
        return false;
    }

    // Lolos pengecekan, gambar siap diupload
    // Generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/'. $nameFile);

    return $namaFileBaru; 
}

function hapus($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;
    // Ambil data dari setiap elemen dalam form
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);
    
    // Cek apakah user pilih gambar baru atau tidak 
    if ( $_FILES['gambar']['error'] === 4 ) {
        $gambar = $gambarLama;
    }else {
        $gambar = upload();
    }
    // $gambar = htmlspecialchars($data["gambar"]);

    // Query insert data // Id harus tetap dimasukan dalam values 
   $query = "UPDATE mahasiswa SET nama = '$nama',
                                  nrp = '$nrp',
                                  email = '$email',
                                  jurusan = '$jurusan',
                                  gambar = '$gambar'
            WHERE id = $id
            ";

   mysqli_query($conn, $query);

   return mysqli_affected_rows($conn);

}
    // Function cari berdasarkan data kecuali data gambar
function cari($keyword){
    $query = "SELECT * FROM mahasiswa 
              WHERE
              nama LIKE '%$keyword%' OR
              nrp LIKE '%$keyword%' OR
              email LIKE '%$keyword%' OR
              jurusan LIKE '%$keyword%'
              ";
    return query($query);
}

function registrasi($data){
    global $conn;

    $nama = strtolower(stripcslashes($data["username"]) );
    $password = mysqli_real_escape_string( $conn, $data["password"]);
    $password2 = mysqli_real_escape_string( $conn, $data["password2"]);

    // Cek username sudah ada apa belum
   $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$nama'");

   if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('username sudah terdaftar')
            </script>";
            return false;
   }

    // Cek Konfirmasi Password
    if ( $password !== $password2) {
        echo "<script>
                alert('Konfirmasi Password tidak sesuai');
            </script>";
            return true;
    }
        //Enskripsi Password
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        //Tambah User baru ke database
        mysqli_query($conn, "INSERT INTO user VALUES('', '$nama', '$password')");

        return mysqli_affected_rows($conn);
}

?>