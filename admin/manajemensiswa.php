<?php

include '../config.php';
include '../functions/functions.php';

error_reporting(0);

session_start();


//GET TOTAL SISWA P
$siswaP = getTotalSiswaP($conn);

//GET TOTAL SISWA L
$siswaL = getTotalSiswaL($conn);

//GET TOTAL 
$total = getTotalSiswa($conn);

//GET JUMLAH KELAS
$totkelas = getTotalKelas($conn);

//DELETE DATA
if(isset($_POST['delData'])) {
    $id_user = $_POST['id_user'];
    mysqli_query($conn, "DELETE FROM tb_user WHERE id_user='$id_user'");
}

//EDIT DATA
if (isset($_POST['editData'])) {
    $id_user = $_POST['id_user'];
    $id_siswa = $_POST['id_siswa'];
    $nama =$_POST['nama'];

    $kelas = $_POST['kelas'];
    // $fetch_id_kelas = mysqli_query($conn, "SELECT id_kelas FROM tb_kelas WHERE kelas='$kelas'");
    // $data_id_kelas = mysqli_fetch_array($fetch_id_kelas);
    // $id_kelas = $data_id_kelas['id_kelas'];
    $id_kelas = "K$kelas";

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
            header('refresh:0; url=manajemensiswa.php');
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
    <title>Manajemen Data Siswa</title>

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
                            <a href="index.php"><img src="../assets/images/logo/logo-1.svg" alt="Sirawa"></a>
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
                            <a href="index.php" class='sidebar-link'>
                                <i class="bi bi-house-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="manajemenguru.php" class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Manajemen Guru</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="manajemenwalkes.php" class='sidebar-link'>
                                <i class="bi bi-person-workspace"></i>
                                <span>Manajemen Wali Kelas</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="manajemenmapel.php" class='sidebar-link'>
                                <i class="bi bi-folder"></i>
                                <span>Manajemen Mapel</span>
                            </a>
                        </li>
                        <li class="sidebar-item active">
                            <a href="manajemensiswa.php" class='sidebar-link'>
                                <i class="bi bi-person-fill"></i>
                                <span>Manajemen Siswa</span>
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
                            <h3>Manajemen Data Siswa</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manajemen Siswa</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Siswa</h6>
                                        <h6 class="font-extrabold mb-0"><?=$siswaL?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Siswi</h6>
                                        <h6 class="font-extrabold mb-0"><?=$siswaP?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldUser1"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total</h6>
                                        <h6 class="font-extrabold mb-0"><?=$total?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldStar"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Kelas</h6>
                                        <h6 class="font-extrabold mb-0"><?=$totkelas?></h6>
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
                                <a href="inputsiswa.php" class="col-md-3 btn icon icon-left btn-primary rounded-pill"><i data-feather="plus"></i>Tambah Data Siswa</a>

                            </div>
                        </div>

                        <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>ID Siswa</th>
                                        <th>Username</th>
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
                                        $pullData=mysqli_query($conn, "SELECT * FROM tb_siswa JOIN tb_ortu USING(id_siswa) JOIN tb_user USING(id_user) JOIN tb_kelas USING(id_kelas)");
                                        while($data=mysqli_fetch_array($pullData)){
                                            $id_user =$data['id_user'];
                                            $id_siswa =$data['id_siswa'];
                                            $username = $data['username'];
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
                                        <td><?=$username?></td>
                                        <td><?=$nama?></td>
                                        <td><?=$kelas?></td>
                                        <td><?=$nisn?></td>
                                        <td><?=$jk?></td>
                                        <td><?=$tempat?></td>
                                        <td><?=$tgl?></td>
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
                                            <a href="#editModal<?= $id_user; ?>" class="btn btn-outline-primary icon rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal<?= $id_user; ?>" data-bs-placement="bottom" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="#hapusModal <?= $id_user; ?>" type="submit" class="btn btn-outline-danger icon rounded-circle" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $id_user; ?>" data-bs-placement="bottom" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->`
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
                                                <input type="text" name="kelas" class="form-control" value="<?= $kelas ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-0">
                                                <label for="emailLarge" class="form-label">Jenis Kelamin</label>
                                                <select class="form-select" name="jenis_kelamin" aria-label="Default select example">
                                                    <option selected value="<?= $jk ?>"><?= $jk?></option>
                                                    <option value="L">Laki-Laki</option>
                                                    <option value="P">Perempuan</option>
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

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="hapusModal<?= $id_user; ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="modalToggleLabel">Hapus Siswa</h3>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_user" value="<?= $id_user ?>">
                                                            <p>Yakin hapus siswa <b><?= $nama; ?></b> dengan ID <b><?= $id_user ?>?</b></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary d-grid w-100" type="submit" name="delData">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
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
                        <p>Made with ❤ by Junnatun</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    
    
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/app.js"></script>

    <script src="../assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="../assets/js/pages/simple-datatables.js"></script>

</body>

</html>