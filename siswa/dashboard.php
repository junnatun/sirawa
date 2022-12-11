<?php

include '../config.php';
include '../functions/functions.php';

error_reporting(0);

session_start();
if(!isset($_SESSION['username'])){
    header("Location:../index.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$data = mysqli_query($conn, "SELECT * FROM tb_siswa s JOIN tb_ortu USING(id_siswa) JOIN tb_kelas USING(id_kelas) WHERE id_user = '$id_user'");
$row = mysqli_fetch_assoc($data);

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="../assets/css/main/app.css">
    <link rel="stylesheet" href="../assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.png" type="image/png">

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
                        <li class="sidebar-item active ">
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
            <div class="page-heading">
                <h3>Dashboard</h3>
            </div>
            <!--content-->
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>Halo, <?=$row['nama'];?>! 👋 </h3>
                                        <p class="text-subtitle text-muted">Lihat hasil kompetensi belajarmu di Sirawa.</p>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="../assets/images/pic-dash3.png" height="180">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Data Siswa</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped" id="table1">
                                            <!--data-->
                                            <tbody>
                                            <tr>
                                                <th>ID Siswa</th>
                                                <td><?=$row['id_siswa'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Nama</th>
                                                <td><?=$row['nama'];?></td>
                                            </tr>
                                            <tr>
                                                <th>NISN</th>
                                                <td><?=$row['nisn'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Tempat, Tanggal Lahir</th>
                                                <td><?=$row['tempat_lahir'];?> , <?=tanggal($row['tgl_lahir']);?></td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Kelamin</th>
                                                <td><?=$row['jenis_kelamin'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Agama</th>
                                                <td><?=$row['agama'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Nomor Telepon</th>
                                                <td><?=$row['no_telp'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Kelas</th>
                                                <td><?=$row['kelas'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Nama Ayah</th>
                                                <td><?=$row['nama_ayah'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Pekerjaan Ayah</th>
                                                <td><?=$row['profesi_ayah'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Alamat Ayah</th>
                                                <td><?=$row['alamat_ayah'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Nomor Telepon Ayah</th>
                                                <td><?=$row['no_telp_ayah'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Nama Ibu</th>
                                                <td><?=$row['nama_ibu'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Pekerjaan Ibu</th>
                                                <td><?=$row['profesi_ibu'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Alamat Ibu</th>
                                                <td><?=$row['alamat_ibu'];?></td>
                                            </tr>
                                            <tr>
                                                <th>Nomor Telepon Ibu</th>
                                                <td><?=$row['no_telp_ibu'];?></td>
                                            </tr>
                                            <!--/data-->
                                        </table>
                                        <div class="alert alert-light-danger">
                                            <i class="bi bi-exclamation-circle"></i>
                                            Jika terdapat kesalahan data diri, silakan menghubungi wali kelas atau admin Sirawa. 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card">
                            <div class="card-body py-4 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl">
                                        <img src="../assets/images/faces/1.jpg" alt="Face 1">
                                    </div>
                                    <div class="ms-3 name">
                                        <h5 class="font-bold"><?php echo $_SESSION['username']; ?></h5>
                                        <h6 class="text-muted mb-0">@<?php echo $_SESSION['id_user']; ?></h6>
                                    </div>
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

    <!-- Need: Apexcharts -->
    <script src="../assets/js/pages/dashboard.js"></script>

</body>

</html>