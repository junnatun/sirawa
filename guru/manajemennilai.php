<?php

include '../config.php';

error_reporting(0);

//security
session_start();
if(!isset($_SESSION['username'])){
    header("Location:../index.php");
    exit();
}

//Ambil data guru dan mapel
$id_user = $_SESSION['id_user'];
$ambildata = mysqli_query($conn, "SELECT * FROM tb_guru JOIN tb_mapel USING(id_guru) WHERE id_user = '$id_user'");
$result = mysqli_fetch_assoc($ambildata);
$id_mapel = $result['id_mapel'];


//Inisialisasi nilai POST untuk sorting
if ($_POST['sort_by'] == '') {
    $sortBy = 'id_siswa';
    $sortType = 'ASC';
    $smt='1';
    $_POST['sort_by'] = $sortBy;
    $_POST['sort_type'] = $sortType;
    $_POST['smt']= $smt;
}

//Inisialisasi nilai POST untuk searching
if ($_POST['search_value'] == '') {
    $searchValue = '';
    $placeHolder = 'Cari..';
} else {
    $searchValue = $_POST['search_value'];
    $placeHolder = '';
}

//GET KELAS YANG DIAMPU
$id_guru=$result['id_guru'];
$sql= mysqli_query($conn, "SELECT COUNT(id_kelas) as kelas FROM tb_mapel WHERE id_guru='$id_guru'");
$row = mysqli_fetch_assoc($sql);

//GET SISWA YANG DIAMPU
$id_kelas = $result['id_kelas'];
$sql2= mysqli_query($conn, "SELECT COUNT(id_siswa) AS siswa FROM tb_nilai WHERE id_mapel='$id_mapel'");
$row2 = mysqli_fetch_assoc($sql2);


//AMBIL DATA
if(isset($_POST['getDataSiswa'])) {
    $semester = $_POST['semester'];
    $ambil_data_siswa = mysqli_query($conn,"SELECT id_siswa FROM tb_mapel JOIN tb_siswa USING(id_kelas) WHERE id_mapel='$id_mapel'");
    
    while ($data = mysqli_fetch_array($ambil_data_siswa)) {
        $id_siswa = $data['id_siswa'];

        //search data yang sudah ada
        $data_terinput = mysqli_query($conn, "SELECT id_siswa, id_mapel, semester FROM tb_nilai
                                                WHERE id_siswa='$id_siswa' AND  id_mapel = '$id_mapel' AND semester = '$semester'");

        if($data_terinput->num_rows == 0){
            $addToTable = mysqli_query($conn, "INSERT INTO tb_nilai VALUES ('$id_siswa', '$id_mapel', '$semester', '0', '0', '0', '0', '0', '0')");
        }else {
            header('refresh:0; url=manajemennilai.php');
            echo "<script>alert('Semua data sudah diambil!')</script>";
        }
    }
}

//EDIT DATA
if(isset($_POST['editData'])){
    $id_siswa=$_POST['id_siswa'];
    $semester=$_POST['semester'];
    $ph1=$_POST['ph1'];
    $ph2=$_POST['ph2'];
    $ph3=$_POST['ph3'];
    $ph4=$_POST['ph4'];
    $pts=$_POST['pts'];
    $pas=$_POST['pas'];

    $editNilai=mysqli_query($conn,"UPDATE tb_nilai SET nilai_ph1='$ph1', nilai_ph2='$ph2', nilai_ph3='$ph3', nilai_ph4='$ph4', nilai_pts='$pts', nilai_pas='$pas' WHERE id_siswa='$id_siswa' AND semester='$semester'");
    if($editNilai){
        header('refresh:0; url=manajemennilai.php');
        echo "<script>alert('Berhasil mengedit nilai siswa!')</script>";
    }else {
        echo "<script>alert('Edit data nilai gagal!')</script>";
    }
    
}

//RESET NILAI
if(isset($_POST['resetNilai'])){
    $id_siswa=$_POST['id_siswa'];
    $semester=$_POST['semester'];
    $id_mapel=$_POST['id_mapel'];

    $resetNilai=mysqli_query($conn,"UPDATE tb_nilai SET nilai_ph1='0', nilai_ph2='0', nilai_ph3='0', nilai_ph4='0', nilai_pts='0', nilai_pas='0' WHERE id_siswa='$id_siswa' AND semester='$semester' AND id_mapel='$id_mapel'");
    if($resetNilai){
        header('refresh:0; url=manajemennilai.php');
        echo "<script>alert('Berhasil mereset nilai siswa!')</script>";
    }else {
        echo "<script>alert('Reset data nilai gagal!')</script>";
    }
}

//DELETE DATA
if(isset($_POST['delData'])){
    $id_siswa=$_POST['id_siswa'];
    $semester=$_POST['semester'];
    $id_mapel=$_POST['id_mapel'];

    $delData=mysqli_query($conn,"DELETE FROM tb_nilai WHERE id_siswa='$id_siswa' AND semester='$semester' AND id_mapel='$id_mapel'");
    if($delData){
        header('refresh:0; url=manajemennilai.php');
        echo "<script>alert('Berhasil menghapus data siswa!')</script>";
    }else {
        echo "<script>alert('Hapus data siswa gagal!')</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Nilai Siswa</title>

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
                            <a href="manajemennilai.php" class='sidebar-link'>
                                <i class="bi bi-table"></i>
                                <span>Manajemen Nilai Siswa</span>
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
                            <h3>Manajemen Nilai Siswa</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manajemen Nilai Siswa</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldUser1"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Siswa yang Diampu</h6>
                                        <h6 class="font-extrabold mb-0"><?= $row2['siswa']?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldTick-Square"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Kelas yang Diampu</h6>
                                        <h6 class="font-extrabold mb-0"><?= $row['kelas']?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldCalendar"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Semester</h6>
                                        <h6 class="font-extrabold mb-0"><?= $_POST['smt'] ?></h6>
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
                                <div class="col-md-9 h4">Data Nilai Siswa</div>
                                <a href="#getDataModal" data-bs-toggle="modal" data-bs-target="#getDataModal" class="col-md-3 btn icon icon-left btn-primary rounded-pill"><i data-feather="download"></i>Ambil Data Siswa</a>
                            </div>
                            <div class="row g-2 d-flex justify-content-between mt-3">
                                <div class="col-md-6">
                                    <form method="POST">
                                        <div class="input-group">
                                            <select class="form-select" id="" aria-label="Example select with button addon" name="sort_by">
                                                <option selected value="<?= $_POST['sort_by'] ?>"><?= strtoupper(preg_replace("/_/", " ",  $_POST['sort_by'])) ?></option>
                                                <option value="id_siswa">ID Siswa</option>
                                                <option value="nama">Nama</option>
                                                <option value="kelas">Kelas</option>
                                            </select>
                                            <select class="form-select" id="inputGroupSelect04" name="sort_type">
                                                <option selected value="<?= $_POST['sort_type'] ?>"><?= $_POST['sort_type'] ?>ENDING</option>
                                                <option value="ASC">Ascending</option>
                                                <option value="DESC">Descending</option>
                                            </select>
                                            <select class="form-select" id="inputGroupSelect04" name="smt">
                                                <option selected value="<?= $_POST['smt'] ?>">SEMESTER <?= $_POST['smt'] ?></option>
                                                <option value="1">Semester 1</option>
                                                <option value="2">Semester 2</option>
                                            </select>
                                            <button class="btn btn-primary" type="submit" name="submitSort">Sort</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <form method="POST">
                                        <div class="input-group">
                                            <input type="text" name="search_value" class="form-control" placeholder="<?= $placeHolder ?>" value="<?= $searchValue ?>" aria-describedby="button-addon2" />
                                            <button class="btn btn-primary" type="submit" id="button-addon2" name="submitSearch">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>                            
                        </div>

                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>ID Siswa</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>smt</th>
                                        <th>PH1</th>
                                        <th>PH2</th>
                                        <th>PH3</th>
                                        <th>PH4</th>
                                        <th>PTS</th>
                                        <th>PAS</th>
                                    </tr>
                                </thead>

                                <!--data-->
                                <tbody>
                                    <?php
                                        if (isset($_POST['submitSort'])) {
                                            $sortBy = $_POST['sort_by'];
                                            $sortType = $_POST['sort_type'];
                                            $smt = $_POST['smt'];
                                            header('refresh:0; url=manajemennilai.php');
                                        }
                    
                                        if (isset($_POST['submitSearch'])) {
                                            $searchValue = $_POST['search_value'];
                                            header('refresh:0; url=manajemennilai.php');
                                        }
                                        
                                        $pullData=mysqli_query($conn, "SELECT * FROM tb_nilai JOIN tb_siswa USING(id_siswa) JOIN tb_kelas USING(id_kelas) 
                                        WHERE id_mapel='$id_mapel' AND semester = '$smt' HAVING id_siswa LIKE '%$searchValue%' OR nama LIKE '%$searchValue%' OR kelas LIKE '%$searchValue%' 
                                        OR nilai_ph1 LIKE '%$searchValue%' OR nilai_ph2 LIKE '%$searchValue%' OR nilai_ph3 LIKE '%$searchValue%' OR nilai_ph4 LIKE '%$searchValue%' 
                                        OR nilai_pts LIKE '%$searchValue%' OR nilai_pas LIKE '%$searchValue%' ORDER BY $sortBy $sortType");
                                        while($data=mysqli_fetch_array($pullData)){
                                            $id_siswa =$data['id_siswa'];
                                            $nama =$data['nama'];
                                            $kelas = $data['kelas'];
                                            $semester = $data['semester'];
                                            $ph1 = $data['nilai_ph1'];
                                            $ph2 = $data['nilai_ph2'];
                                            $ph3 = $data['nilai_ph3'];
                                            $ph4 = $data['nilai_ph4'];
                                            $pts = $data['nilai_pts'];
                                            $pas = $data['nilai_pas'];
                                    ?>
                                    <tr>
                                        <td><?=$id_siswa?></td>
                                        <td><?=$nama?></td>
                                        <td><?=$kelas?></td>
                                        <td><?=$semester?></td>
                                        <td><?=$ph1?></td>
                                        <td><?=$ph2?></td>
                                        <td><?=$ph3?></td>
                                        <td><?=$ph4?></td>
                                        <td><?=$pts?></td>
                                        <td><?=$pas?></td>
                                        <td>
                                            <a href="#editModal<?= $id_siswa; ?>" class="btn btn-outline-primary icon rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal<?= $id_siswa; ?>" data-bs-placement="bottom" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="#hapusModal <?= $id_siswa; ?>" type="submit" class="btn btn-outline-danger icon rounded-circle" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $id_siswa; ?>" data-bs-placement="bottom" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal<?= $id_siswa; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <form method="POST">
                                            <input type="hidden" name="id_siswa" value="<?= $id_siswa; ?>">
                                            <input type="hidden" name="semester" value="<?= $semester; ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel3">Edit Nilai Siswa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <div class="row">
                                                <div class="col mb-3 col-md-10">
                                                <label for="nameLarge" class="form-label"><h5><?= $id_siswa ?> - <?= $kelas; ?> - <?= $nama ?></h5></label>
                                                </div>
                                                <div class="col mb-3 col-md-2">
                                                <label for="nameLarge" class="form-label">Semester <?= $semester ?></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nilai PH1</label>
                                                <input type="number" name="ph1" class="form-control" value="<?= $ph1 ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nilai PH2</label>
                                                <input type="number" name="ph2" class="form-control" value="<?= $ph2 ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nilai PH3</label>
                                                <input type="number" name="ph3" class="form-control" value="<?= $ph3 ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nilai PH4</label>
                                                <input type="number" name="ph4" class="form-control" value="<?= $ph4 ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nilai PTS</label>
                                                <input type="number" name="pts" class="form-control" value="<?= $pts ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nilai PAS</label>
                                                <input type="number" name="pas" class="form-control" value="<?= $pas ?>" />
                                                </div>
                                            </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <button type="submit" name="editData" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    </div>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="hapusModal<?= $id_siswa; ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="modalToggleLabel">Hapus Nilai</h3>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_siswa" value="<?= $id_siswa ?>">
                                                        <input type="hidden" name="semester" value="<?= $semester ?>">
                                                        <input type="hidden" name="id_mapel" value="<?= $id_mapel ?>">
                                                            <p>Yakin menghapus nilai dari <b><?= $nama; ?></b>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                            <button class="btn btn-outline-primary " type="submit" name="resetNilai">Reset Nilai</button>
                                                            <button class="btn btn-outline-danger " type="submit" name="delData">Hapus Siswa</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <!--/data-->
                            </table>
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

    <!-- Modal Get Data -->
    <div class="modal fade" id="getDataModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <form method="POST">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Ambil Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-5">
                        <label for="emailLarge" class="form-label">Semester</label>
                        <select class="form-select" name="semester" aria-label="Default select example">
                            <option value='1'>1 - Gasal</option>
                            <option value='2'>2 - Genap</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Batal
                </button>
                <button type="submit" name="getDataSiswa" class="btn btn-primary">Ambil</button>
            </div>
            </div>
        </form>
        </div>
    </div>

    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/app.js"></script>

</body>

</html>