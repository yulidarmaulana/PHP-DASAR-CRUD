<?php
session_start();
require 'functions.php';

// Cek Cookie
if ( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // Ambil Username berdasarkan id
    $resault = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($resault);
     
    // Cek Cookie dan Username
    if ( $key === hash('sha256', $row['username']) ) {
        $_SESSION['login'] = true; 
    }    

}

if ( isset($_SESSION["login"]) ) {
    header("Location: index.php");
    exit;
}


if ( isset($_POST["login"]) ) {
    
    $username = $_POST["username"];
    $password = $_POST["password"];

    $resault  = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' ");

    // Cek username
    if (mysqli_num_rows($resault) === 1 ) {
        
        // Cek Password
        $row = mysqli_fetch_assoc($resault);
        if ( password_verify($password, $row["password"] ) ){
            // Set Session
            $_SESSION["login"] = true;

            // Cek Remember Me
            if ( isset($_POST['remember']) ) {
                // Buat cookie
                setcookie('id', $row['id'], time() + 60 );
                setcookie('key', hash('sha256', $row['username']), time() + 60 );
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login</title>
</head>
<body>

<h1>Halaman Login</h1>

<?php if ( isset($error) ) : ?>
    <p style="color: red; font-style: italic;">Username / Password salah </p>
<?php endif;    ?>

<form action="" method="post">

    <ul>
        <li>
            <label for="username">Username :</label>
            <input type="text" name="username" id="username">
        </li>

        <li>
            <label for="password">Password :</label>
            <input type="password" name="password" id="password">
        </li>
        
        <li>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember me</label>
        </li>

        <li>
            <button type="submit" name="login">Login</button>
        </li>
    </ul>

</form>
    
</body>
</html>