<?php

include '../config.php';

error_reporting(0);

session_start();
if(!isset($_SESSION['username'])){
    header("Location:../index.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$data = mysqli_query($conn, "SELECT id_siswa, nama, nisn, kelas FROM tb_siswa s JOIN tb_kelas USING(id_kelas) WHERE id_user = '$id_user'");
$row = mysqli_fetch_assoc($data);
$id_siswa = $row['id_siswa'];
$nama = $row['nama'];
$nisn = $row['nisn'];
$kelas = $row['kelas'];
$id_kelas = "K$kelas";

//Inisialisasi Nilai POST untuk semester
if ($_POST['semester'] == '') {
    $semester='1';
    $_POST['semester']= $semester;
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Rapor</title>

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
                        <li class="sidebar-item">
                            <a href="dashboard.php" class='sidebar-link'>
                                <i class="bi bi-house-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item active">
                            <a href="lihatrapor.php" class='sidebar-link'>
                                <i class="bi bi-award-fill"></i>
                                <span>Lihat Rapor</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
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
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">

                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Lihat Rapor</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Lihat Rapor</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-lg-8 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <h5><?=$row['id_siswa'];?></h5>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <h5><?=$row['nama'];?></h5>
                                        <h5><?=$row['nisn'];?></h5>
                                        <h5><?=$row['kelas'];?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ms-5 ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldCalendar"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7 ms-5">
                                        <h5 class="text-muted font-semibold">Semester <?= $_POST['semester'] ?></h5>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-2 mt-2">Pilih semester :</div>
                                <div class="col-md-2">
                                <form method="POST">
                                    <div class="btn-group">
                                        <input type="submit" class="btn-check" name="semester" id="gasal" autocomplete="off" checked="" value='1'>
                                        <label class="btn btn-outline-primary" for="gasal">1</label>
                                        <input type="submit" class="btn-check" name="semester" id="genap" autocomplete="off" value='2'>
                                        <label class="btn btn-outline-primary" for="genap">2</label>
                                    </div>
                                </form>
                                </div>
                                
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Nilai</th>
                                            <th>Predikat</th>
                                        </tr>
                                        <?php
                                            if (isset($_POST['semester'])) {
                                                $semester = $_POST['semester'];
                                                header('refresh:0; url=lihatrapor.php');
                                            }

                                            $num =1;
                                            $totalNilai=0;
                                            $pullData=mysqli_query($conn, "SELECT * FROM tb_nilai JOIN tb_siswa USING(id_siswa) WHERE id_siswa='$id_siswa' AND id_kelas='$id_kelas' AND semester= '$semester'");
                                            while($data=mysqli_fetch_array($pullData)){
                                                $id_mapel = $data['id_mapel'];
                                                $getMapel = mysqli_query($conn, "SELECT * FROM tb_mapel WHERE id_mapel='$id_mapel'");
                                                $row= mysqli_fetch_array($getMapel);
                                                $mapel= $row['mapel'];

                                                $ph1 = $data['nilai_ph1'];
                                                $ph2 = $data['nilai_ph2'];
                                                $ph3 = $data['nilai_ph3'];
                                                $ph4 = $data['nilai_ph4'];
                                                $pts = $data['nilai_pts'];
                                                $pas = $data['nilai_pas'];

                                                $nilaiRapor = (($ph1+$ph2+$ph3+$ph4+$pts+$pas)/6);
                                                $totalNilai+=$nilaiRapor;
                                                if($nilaiRapor <61){
                                                    $predikat = 'D';
                                                } else if($nilaiRapor <74){
                                                    $predikat = 'C';
                                                } else if($nilaiRapor <87){
                                                    $predikat = 'B';
                                                }else if($nilaiRapor >=87){
                                                    $predikat = 'A';
                                                }
                                        ?>
                                        <tr>
                                            <td><?=$num++;?></td>
                                            <td><?=$mapel?></td>
                                            <td><?=$nilaiRapor?></td>
                                            <td><?=$predikat?></td>
                                            
                                        </tr>
                                        <?php } ?>
                                    </thead>
                                </table>
                            </div>
                            <div class="alert alert-primary">
                                <div class="table-responsive">
                                    <table class="table table-white table-lg">
                                        <thead>
                                            <tr>
                                                <th>Total Nilai</th>
                                                <th><?=$totalNilai?></th>
                                            </tr>
                                            <tr>
                                                <th>Nilai Rata-Rata</th>
                                                <th><?=$totalNilai/($num-1)?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted bottom-0">
                    <div class="float-start">
                        Made with ❤ by 
                        <a href="https://github.com/junnatun" target="_blank" class="footer-link fw-bolder">Junnatun</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/app.js"></script>

</body>

</html>