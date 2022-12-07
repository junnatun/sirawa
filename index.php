<?php

include 'config.php';

error_reporting(0);

session_start();

if (isset($_POST['login'])){
    $username =$_POST['username'];
    $password =$_POST['password'];

    $sql = "SELECT * FROM tb_user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id_user']=$row['id_user'];
        $_SESSION['username']=$row['username'];
        $_SESSION['role']=$row['role'];
        if ($_SESSION['role'] == "admin"){
            header("Location: admin/dashboard.php");
        }else if ($_SESSION['role'] == "guru"){
            header("Location: guru/dashboard.php");
        }else if ($_SESSION['role'] == "wali kelas"){
            header("Location: walkes/dashboard.php");
        } else if ($_SESSION['role'] == "siswa"){
            header("Location: siswa/dashboard.php");
        }
    } else {
        echo "<script>alert('Username atau password Anda salah. Silahkan coba lagi!')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sirawa</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <link rel="shortcut icon" href="assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.php"><img src="assets/images/logo/logo-1.svg" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Log in</h1>
                    <p class="auth-subtitle mb-5">Masukkan username dan password anda.</p>

                    <form action="index.php" method="POST">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input name ="username" type="text" class="form-control form-control-xl" placeholder="Username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input name ="password" type="password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button name="login" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <div class="auth-logo">
                        <img src="assets/images/logo/Saly-1.svg" height="500">
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>