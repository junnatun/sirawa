<?php

include '../config.php';
include '../functions/functions.php';

error_reporting(0);

session_start();
if(!isset($_SESSION['username'])){
    header("Location:../index.php");
    exit();
}

//Inisialisasi nilai POST untuk sorting
if ($_POST['sort_by'] == '') {
    $sortBy = 'id_siswa';
    $sortType = 'ASC';
    $_POST['sort_by'] = $sortBy;
    $_POST['sort_type'] = $sortType;
}

//Inisialisasi nilai POST untuk searching
if ($_POST['search_value'] == '') {
    $searchValue = '';
    $placeHolder = 'Cari..';
} else {
    $searchValue = $_POST['search_value'];
    $placeHolder = '';
}

$id_user = $_SESSION['id_user'];
$data = mysqli_query($conn, "SELECT * FROM tb_walikelas JOIN tb_kelas USING(id_kelas) WHERE id_user = '$id_user'");
$row = mysqli_fetch_assoc($data);
$id_kelas = $row['id_kelas'];

$sql = mysqli_query($conn, "SELECT COUNT(id_kelas) AS siswa FROM tb_siswa WHERE id_kelas = '$id_kelas'");
$result= mysqli_fetch_assoc($sql);
$siswakelas = $result['siswa'];

//EDIT DATA
if (isset($_POST['editData'])) {
    $id_user = $_POST['id_user'];
    $id_siswa = $_POST['id_siswa'];
    $nama =$_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $nisn =$_POST['nisn'];
    $jk =$_POST['jenis_kelamin'];
    $tempat =$_POST['tempat'];
    $tgl =$_POST['tgl'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];
    $no =$_POST['no_telp'];

    $nama_ayah =$_POST['nama_ayah'];
    $profesi_ayah =$_POST['profesi_ayah'];
    $alamat_ayah =$_POST['alamat_ayah'];
    $no_ayah =$_POST['no_ayah'];

    $nama_ibu =$_POST['nama_ibu'];
    $profesi_ibu =$_POST['profesi_ibu'];
    $alamat_ibu =$_POST['alamat_ibu'];
    $no_ibu =$_POST['no_ibu'];
    
    $editSiswa = mysqli_query($conn, "UPDATE tb_siswa SET id_kelas='$id_kelas', nama='$nama', nisn='$nisn', jenis_kelamin='$jk', tempat_lahir = '$tempat', tgl_lahir='$tgl', agama= '$agama',alamat='$alamat', no_telp = '$no' WHERE id_user='$id_user'") ;
    if ($editSiswa) {
        $editOrtu = mysqli_query($conn, "UPDATE tb_ortu SET nama_ayah='$nama_ayah', profesi_ayah='$profesi_ayah', alamat_ayah='$alamat_ayah', no_telp_ayah='$no_ayah', nama_ibu='$nama_ibu', profesi_ibu='$profesi_ibu', alamat_ibu='$alamat_ibu', no_telp_ibu='$no_ibu' WHERE id_siswa='$id_siswa'");
        if($editOrtu){
            header('refresh:0; url=dashboard.php');
            echo "<script>alert('Berhasil mengedit data siswa!')</script>";
        }else {
            echo "<script>alert('Edit data siswa gagal!')</script>";
        }
    } else {
        echo "<script>alert('Edit data siswa gagal!')</script>";
    }
}

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
                                <span>Lihat Rapor Siswa</span>
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
                                        <h3>Halo, Wali Kelas <?= $row['kelas']?>! 👋</h3>
                                        <p class="text-subtitle text-muted">Mulai kelola data kelas perwalian dengan Sirawa.</p>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="../assets/images/pic-dash3.png" height="180">
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
                    <div class="row justify-content-between">
                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldStar"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Kelas Wali</h6>
                                        <h6 class="font-extrabold mb-0"><?=$row['kelas'];?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldUser1"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Siswa Wali</h6>
                                        <h6 class="font-extrabold mb-0"><?=$siswakelas?></h6>
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
                                <div class="col-md-9 h4">Data Siswa</div>
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
                                                <option value="nisn">NISN</option>
                                                <option value="jenis_kelamin">Jenis Kelamin</option>
                                                <option value="tempat_lahir">Tempat Lahir</option>
                                                <option value="tgl_lahir">Tanggal Lahir</option>
                                                <option value="agama">Agama</option>
                                                <option value="alamat">Alamat</option>
                                                <option value="no_telp">Telp</option>
                                                <option value="nama_ayah">Nama Ayah</option>
                                                <option value="profesi_ayah">Profesi Ayah</option>
                                                <option value="alamat_ayah">Alamat Ayah</option>
                                                <option value="no_telp_ayah">Telp Ayah</option>
                                                <option value="nama_ibu">Nama Ibu</option>
                                                <option value="profesi_ibu">Profesi Ibu</option>
                                                <option value="alamat_ibu">Alamat Ibu</option>
                                                <option value="no_telp_ibu">Telp Ibu</option>
                                            </select>
                                            <select class="form-select" id="inputGroupSelect04" name="sort_type">
                                                <option selected value="<?= $_POST['sort_type'] ?>"><?= $_POST['sort_type'] ?>ENDING</option>
                                                <option value="ASC">Ascending</option>
                                                <option value="DESC">Descending</option>
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
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover" id="table1">
                                <thead>
                                    <tr>
                                        <th>ID Siswa</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>NISN</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Agama</th>
                                        <th>Alamat</th>
                                        <th>Telp</th>
                                        <th>Nama Ayah</th>
                                        <th>Pekerjaan Ayah</th>
                                        <th>Alamat Ayah</th>
                                        <th>Telp Ayah</th>
                                        <th>Nama Ibu</th>
                                        <th>Pekerjaan Ibu</th>
                                        <th>Alamat Ibu</th>
                                        <th>Telp Ibu</th>
                                    </tr>
                                </thead>
                                <!--data-->
                                <tbody>
                                <?php
                                        if (isset($_POST['submitSort'])) {
                                            $sortBy = $_POST['sort_by'];
                                            $sortType = $_POST['sort_type'];
                                            header('refresh:0; url=dashboard.php');
                                        }
                    
                                        if (isset($_POST['submitSearch'])) {
                                            $searchValue = $_POST['search_value'];
                                            header('refresh:0; url=dashboard.php');
                                        }
                                        $pullData=mysqli_query($conn, "SELECT * FROM tb_siswa JOIN tb_ortu USING(id_siswa) JOIN tb_user USING(id_user) JOIN tb_kelas USING(id_kelas) 
                                        WHERE id_kelas='$id_kelas' HAVING id_siswa LIKE '%$searchValue%' OR nama LIKE '%$searchValue%' OR kelas LIKE '%$searchValue%' 
                                        OR nisn LIKE '%$searchValue%' OR jenis_kelamin LIKE '%$searchValue%' OR tempat_lahir LIKE '%$searchValue%' OR tgl_lahir LIKE '%$searchValue%' 
                                        OR agama LIKE '%$searchValue%' OR alamat LIKE '%$searchValue%' OR no_telp LIKE '%$searchValue%' OR nama_ayah LIKE '%$searchValue%' 
                                        OR profesi_ayah LIKE '%$searchValue%' OR alamat_ayah LIKE '%$searchValue%' OR no_telp_ayah LIKE '%$searchValue%' OR nama_ibu LIKE '%$searchValue%' 
                                        OR profesi_ibu LIKE '%$searchValue%' OR alamat_ibu LIKE '%$searchValue%' OR no_telp_ibu LIKE '%$searchValue%' ORDER BY $sortBy $sortType;");
                                        while($data=mysqli_fetch_array($pullData)){
                                            $id_user =$data['id_user'];
                                            $id_siswa =$data['id_siswa'];
                                            $nama =$data['nama'];
                                            $kelas = $data['kelas'];
                                            $nisn =$data['nisn'];
                                            $jk =$data['jenis_kelamin'];
                                            $tempat =$data['tempat_lahir'];
                                            $tgl =$data['tgl_lahir'];
                                            $agama = $data['agama'];
                                            $alamat = $data['alamat'];
                                            $no =$data['no_telp'];

                                            $nama_ayah =$data['nama_ayah'];
                                            $profesi_ayah =$data['profesi_ayah'];
                                            $alamat_ayah =$data['alamat_ayah'];
                                            $no_ayah =$data['no_telp_ayah'];

                                            $nama_ibu =$data['nama_ibu'];
                                            $profesi_ibu =$data['profesi_ibu'];
                                            $alamat_ibu =$data['alamat_ibu'];
                                            $no_ibu =$data['no_telp_ibu'];
                                    ?> <tr>
                                        <td><?=$id_siswa?></td>
                                        <td><?=$nama?></td>
                                        <td><?=$kelas?></td>
                                        <td><?=$nisn?></td>
                                        <td><?=$jk?></td>
                                        <td><?=$tempat?></td>
                                        <td><?=tanggal($tgl)?></td>
                                        <td><?=$agama?></td>
                                        <td><?=$alamat?></td>
                                        <td><?=$no?></td>
                                        <td><?=$nama_ayah?></td>
                                        <td><?=$profesi_ayah?></td>
                                        <td><?=$alamat_ayah?></td>
                                        <td><?=$no_ayah?></td>
                                        <td><?=$nama_ibu?></td>
                                        <td><?=$profesi_ibu?></td>
                                        <td><?=$alamat_ibu?></td>
                                        <td><?=$no_ibu?></td>
                                        <td>
                                            <a href="#editModal<?= $id_user; ?>" class="btn btn-outline-primary icon rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal<?= $id_user; ?>" data-bs-placement="bottom" title="Edit <?=$nama?>">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal<?= $id_user; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <form method="POST">
                                            <input type="hidden" name="id_user" value="<?= $id_user; ?>">
                                            <input type="hidden" name="id_siswa" value="<?= $id_siswa; ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel3">Edit Data Siswa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nama</label>
                                                <input type="text" name="nama" class="form-control" value="<?= $nama ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">NISN</label>
                                                <input type="number" name="nisn" class="form-control" value="<?= $nisn ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Kelas</label>
                                                <!-- <input type="text" name="kelas" class="form-control" value="<?= $kelas ?>" /> -->
                                                    <select class="form-select" name="id_kelas" aria-label="Default select example">
                                                        <option selected value="<?= $id_kelas?>"><?=$kelas?></option>
                                                            <?php
                                                                $ambil_data_kelas = mysqli_query($conn,"SELECT id_kelas, kelas FROM tb_kelas ORDER BY kelas");

                                                                while ($data = mysqli_fetch_array($ambil_data_kelas)) {
                                                                    $id_kelas = $data['id_kelas'];
                                                                    $kelas = $data['kelas'];
                                                                ?>
                                                                    <option value="<?= $id_kelas ?>"><?= $kelas ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-0">
                                                <label for="emailLarge" class="form-label">Jenis Kelamin</label>
                                                <select class="form-select" name="jenis_kelamin" aria-label="Default select example">
                                                    <option selected value="<?= $jk ?>"><?= $jk?></option>
                                                    <option value="Laki-Laki">Laki-Laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Tempat Lahir</label>
                                                <input type="text" name="tempat" class="form-control" value="<?= $tempat ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Tanggal Lahir</label>
                                                <input type="date" name="tgl" class="form-control" value="<?= $tgl ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Agama</label>
                                                <input type="text" name="agama" class="form-control" value="<?= $agama ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nomor Telepon</label>
                                                <input type="number" name="no_telp" class="form-control" value="<?= $no ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Alamat</label>
                                                <input class="form-control" name="alamat" rows="3" placeholder="<?= $alamat ?>"></input>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nama Ayah</label>
                                                <input type="text" name="nama_ayah" class="form-control" value="<?= $nama_ayah ?>" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Pekerjaan Ayah</label>
                                                <input type="text" name="profesi_ayah" class="form-control" value="<?= $profesi_ayah ?>" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Alamat Ayah</label>
                                                <input type="text" name="alamat_ayah" class="form-control" value="<?= $alamat_ayah ?>" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nomor Telepon Ayah</label>
                                                <input type="number" name="no_ayah" class="form-control" value="<?= $no_ayah ?>" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nama Ibu</label>
                                                <input type="text" name="nama_ibu" class="form-control" value="<?= $nama_ibu ?>" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Pekerjaan Ibu</label>
                                                <input type="text" name="profesi_ibu" class="form-control" value="<?= $profesi_ibu ?>" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Alamat Ibu</label>
                                                <input type="text" name="alamat_ibu" class="form-control" value="<?= $alamat_ibu ?>" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Nomor Telepon Ibu</label>
                                                <input type="number" name="no_ibu" class="form-control" value="<?= $no_ibu ?>" >
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

                                    <?php } ?>
                                    <!--/data-->
                            </table>
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