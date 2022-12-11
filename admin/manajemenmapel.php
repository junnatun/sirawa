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
    $sortBy = 'id_mapel';
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

//ADD DATA
if (isset($_POST['addData'])){
    $id_mapel = $_POST['id_mapel'];
    $mapel=$_POST['mapel'];
    $id_guru = $_POST['id_guru'];
    $id_kelas=$_POST['id_kelas'];

    $addMapel = mysqli_query($conn, "INSERT INTO tb_mapel VALUES ('$id_mapel','$id_guru','$mapel','$id_kelas')");
    if($addMapel){
        header('refresh:0; url=manajemenmapel.php');
        echo "<script>alert('Berhasil menambah mata pelajaran!')</script>";
    }else {
            echo "<script>alert('Mata pelajaran gagal ditambahkan!')</script>";
    }
}

//DELETE DATA
if(isset($_POST['delData'])) {
    $id_mapel = $_POST['id_mapel'];
    $id_kelas = $_POST['id_kelas'];
    $delMapel=mysqli_query($conn, "DELETE FROM tb_mapel WHERE id_mapel='$id_mapel' AND id_kelas = '$id_kelas'");
    if ($delMapel) {
        header('refresh:0; url=manajemenmapel.php');
        echo "<script>alert('Berhasil menghapus mata pelajaran!')</script>";
    } else {
        echo "<script>alert('Hapus mata pelajaran gagal!')</script>";
    }
}

//EDIT DATA
if (isset($_POST['editData'])) {
    $id_mapel = $_POST['id_mapel'];
    $id_guru= $_POST['id_guru'];
    $mapel = $_POST['mapel'];
    $id_kelas = $_POST['id_kelas'];

    $editQuery = "UPDATE tb_mapel SET mapel='$mapel', id_guru='$id_guru', id_kelas='$id_kelas' WHERE id_mapel='$id_mapel'";
    $edit = mysqli_query($conn, $editQuery);
    if ($edit) {
        header('refresh:0; url=manajemenmapel.php');
        echo "<script>alert('Berhasil mengedit data mata pelajaran!')</script>";
    } else {
        echo "<script>alert('Edit data mata pelajaran gagal!')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Mata Pelajaran</title>

    <link rel="stylesheet" href="../assets/css/main/app.css">
    <link rel="stylesheet" href="../assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.png" type="image/png">

    <link rel="stylesheet" href="../assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="../assets/css/pages/simple-datatables.css">

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
                        <li class="sidebar-item active">
                            <a href="manajemenmapel.php" class='sidebar-link'>
                                <i class="bi bi-folder"></i>
                                <span>Manajemen Mapel</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
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
                            <h3>Manajemen Mata Pelajaran</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manajemen Mapel</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="card">

                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-9 h4">Data Mata Pelajaran</div>
                                <a href="#tambahModal" class="col-md-3 btn icon icon-left btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahModal"><i data-feather="plus"></i>Tambah Mata Pelajaran</a>
                            </div>
                            <div class="row g-2 d-flex justify-content-between mt-3">
                                <div class="col-md-6">
                                    <form method="POST">
                                        <div class="input-group">
                                            <select class="form-select" id="" aria-label="Example select with button addon" name="sort_by">
                                                <option selected value="<?= $_POST['sort_by'] ?>"><?= strtoupper(preg_replace("/_/", " ",  $_POST['sort_by'])) ?></option>
                                                <option value="id_mapel">ID Mapel</option>
                                                <option value="mapel">Mapel</option>
                                                <option value="nama">Nama</option>
                                                <option value="kelas">Kelas</option>
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
                                    <tr class="text-nowrap">
                                        <th>ID Mapel</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru Pengampu</th>
                                        <th>Kelas</th>
                                    </tr>
                                </thead> 

                                <!--data-->
                                <tbody>
                                    <?php
                                        if (isset($_POST['submitSort'])) {
                                            $sortBy = $_POST['sort_by'];
                                            $sortType = $_POST['sort_type'];
                                            header('refresh:0; url=manajemenmapel.php');
                                        }
                    
                                        if (isset($_POST['submitSearch'])) {
                                            $searchValue = $_POST['search_value'];
                                            header('refresh:0; url=manajemenmapel.php');
                                        }

                                        $pullData=mysqli_query($conn, "SELECT * FROM tb_mapel JOIN tb_guru USING(id_guru) JOIN tb_kelas USING(id_kelas)
                                        WHERE id_mapel LIKE '%$searchValue%' OR mapel LIKE '%$searchValue%' OR nama LIKE '%$searchValue%' OR kelas LIKE '%$searchValue%'
                                        ORDER BY $sortBy $sortType");
                                        
                                        while($data=mysqli_fetch_array($pullData)){
                                            $id_mapel = $data['id_mapel'];
                                            $mapel = $data['mapel'];
                                            $id_guru = $data['id_guru'];
                                            $nama = $data['nama'];
                                            $kelas= $data['kelas'];
                                            $id_kelas = $data['id_kelas'];
                                    ?> <tr>
                                        
                                        <td><?=$id_mapel?></td>
                                        <td><?=$mapel?></td>
                                        <td><?=$nama?></td>
                                        <td><?=$kelas?></td>
                                        <td>                                        
                                            <a href="#editModal<?= $id_mapel, $id_kelas; ?>" class="btn btn-outline-primary icon rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal<?= $id_mapel, $id_kelas; ?>" data-bs-placement="bottom" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="#hapusModal<?= $id_mapel, $id_kelas; ?>" class="btn btn-outline-danger icon rounded-circle" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $id_mapel, $id_kelas; ?>" data-bs-placement="bottom" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="hapusModal<?= $id_mapel, $id_kelas; ?>" aria-labelledby="modalToggleLabel" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="modalToggleLabel">Hapus Mata Pelajaran</h3>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_mapel" value="<?= $id_mapel ?>">
                                                        <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">
                                                        <p>Yakin hapus mapel <b><?= $mapel; ?></b><br> dengan ID <b><?= $id_mapel ?></b> di kelas <b><?=$kelas?></b> ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary d-grid w-100" type="submit" name="delData">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal<?= $id_mapel, $id_kelas;?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <form method="POST">
                                            <input type="hidden" name="id_mapel" value="<?= $id_mapel; ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel3">Edit Data Mata Pelajaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">ID Mata Pelajaran</label>
                                                <p class="ms-2"><?=$id_mapel?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Mata Pelajaran</label>
                                                <input type="text" name="mapel" class="form-control" value="<?= $mapel ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Guru Pengampu</label>
                                                <!-- <input type="text" name="nama_guru" class="form-control" value="<?= $nama ?>" /> -->
                                                <select class="form-select" name="id_guru" aria-label="Default select example">
                                                <option selected value="<?= $id_guru?>"><?=$nama?></option>
                                                <?php
                                                    $ambil_data_guru = mysqli_query($conn,"SELECT id_guru, nama FROM tb_guru ORDER BY nama");
                                                    while ($data = mysqli_fetch_array($ambil_data_guru)) {
                                                        $id_guru = $data['id_guru'];
                                                        $nama = $data['nama'];
                                                    ?>
                                                        <option value="<?= $id_guru ?>"><?= $nama ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="nameLarge" class="form-label">Kelas</label>
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
    
    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Tambah Mata Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameLarge" class="form-label">ID Mapel</label>
                            <input type="text" name="id_mapel" class="form-control" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameLarge" class="form-label">Mata Pelajaran</label>
                            <input type="text" name="mapel" class="form-control" placeholder="Contoh : Matematika" required />
                        </div>
                    </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameLarge" class="form-label">Guru Pengampu</label>
                        <select class="form-select" name="id_guru" aria-label="Default select example" required>
                            <?php
                                $ambil_data_guru = mysqli_query($conn,"SELECT id_guru, nama FROM tb_guru ORDER BY nama");

                                while ($data = mysqli_fetch_array($ambil_data_guru)) {
                                    $id_guru = $data['id_guru'];
                                    $nama = $data['nama'];
                                ?>
                                    <option value="<?= $id_guru ?>"><?= $nama ?></option>
                                <?php
                                }
                                ?>
                            </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameLarge" class="form-label">Kelas</label>
                        <select class="form-select" name="id_kelas" aria-label="Default select example" required>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" name="addData" class="btn btn-primary">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/app.js"></script>

</body>

</html>