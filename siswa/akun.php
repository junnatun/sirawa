<?php

include '../config.php';

error_reporting(0);

//security
session_start();
if(!isset($_SESSION['username'])){
    header("Location:../index.php");
    exit();
}

//ambil data user
$id_user = $_SESSION['id_user'];
$ambildata = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user = '$id_user'");
$result = mysqli_fetch_assoc($ambildata);

//EDIT PASSWORD
if(isset($_POST['editPass'])){
    $pass_lama = md5($_POST['pass_lama']);
    $pass_baru = md5($_POST['pass_baru']);
    $repass_baru = md5($_POST['repass_baru']);

    $getDataUser = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user='$id_user' AND password='$pass_lama'");

    if ($getDataUser->num_rows > 0) {
        if ($pass_baru == $repass_baru) {
            $editPass = mysqli_query($conn, "UPDATE tb_user SET password='$pass_baru' WHERE id_user='$id_user'");
            if ($editPass) {
                header('refresh:0; url=akun.php');
                echo "<script>alert('Password berhasil diubah!')</script>";
            } else {
                header('refresh:0; url=akun.php');
                echo "<script>alert('Ubah password gagal!')</script>";
            }
        } else {
            header('refresh:0; url=akun.php');
            echo "<script>alert('Password tidak cocok!')</script>";
        }
    } else {
        header('refresh:0; url=akun.php');
        echo "<script>alert('Password lama salah!')</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya</title>

    <link rel="stylesheet" href="../assets/css/main/app.css">
    <link rel="stylesheet" href="../assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.png" type="image/png">

    <link rel="stylesheet" href="../assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="../assets/css/pages/simple-datatables.css">
    <link rel="stylesheet" href="../assets/css/shared/iconly.css">

</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="dashboard.php"><img src="../assets/images/logo/logo-1.svg" alt="Sirawa"></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path><g transform="translate(-210 -1)"><path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path><circle cx="220.5" cy="11.5" r="4"></circle><path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path></g></g></svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"></path></svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <!--menu-->
                <div class="sidebar-menu">
                    <ul class="menu">
                    <li class="sidebar-item ">
                            <a href="dashboard.php" class='sidebar-link'>
                                <i class="bi bi-house-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="lihatrapor.php" class='sidebar-link'>
                                <i class="bi bi-award-fill"></i>
                                <span>Lihat Rapor</span>
                            </a>
                        </li>
                        <li class="sidebar-item active">
                            <a href="akun.php" class='sidebar-link'>
                                <i class="bi bi-person-fill"></i>
                                <span>Akun Saya</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="menu footer position-absolute bottom-0">
                        <footer class="card-footer">
                            <a href="../logout.php" class='sidebar-link'>
                                <i class="bi bi-power"></i>
                                <span>Log Out</span>
                            </a>
                        </footer>
                    </ul>
                </div>
                <!--/menu-->
            </div>
        </div>
        <div id="main">
            <div class="page-heading">
            <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Akun Saya</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Akun Saya</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!--content-->
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-9">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-borderless" id="table1">
                                            <tbody>
                                            <tr>
                                                <th>Username</th>
                                                <td>:</td>
                                                <td><?=$result['username'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Password</th>
                                                <td>:</td>
                                                <td>*****</td>
                                            </tr>
                                        </table>
                                        <a href="#editModal<?=$result['id_user']?>" class="btn btn-primary" type="submit" data-bs-toggle="modal" data-bs-target="#editModal<?=$id_user?>">Ubah Password</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted position-absolute bottom-0">
                    <div class="float-start">
                        Made with ❤ by 
                        <a href="https://github.com/junnatun" target="_blank" class="footer-link fw-bolder">Junnatun</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal<?=$id_user?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST">
                <!-- <input type="hidden" name="id_user" value="<?=$id_user?>"> -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Ubah Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameLarge" class="form-label">Password Lama</label>
                            <input type="password" name="pass_lama" class="form-control" placeholder="Masukkan password lama" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameLarge" class="form-label">Password Baru</label>
                            <input type="password" name="pass_baru" class="form-control" placeholder="Masukkan password baru" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameLarge" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="repass_baru" class="form-control" placeholder="Masukkan ulang password baru" required/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" name="editPass" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/app.js"></script>

</body>

</html>