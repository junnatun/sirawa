<?php

include '../config.php';

error_reporting(0);

session_start();


$id_siswa = $_POST['id_siswa'];
$semester = $_POST['semester'];
$data = mysqli_query($conn, "SELECT nama, nisn, kelas FROM tb_siswa s JOIN tb_kelas USING(id_kelas) WHERE id_siswa = '$id_siswa'");
$row = mysqli_fetch_assoc($data);
$nama = $row['nama'];
$nisn = $row['nisn'];
$kelas = $row['kelas'];
$id_kelas = "K$kelas";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rapor Siswa</title>

    <link rel="stylesheet" href="../assets/css/print.css">
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
        <div style="margin: 60px;">
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Rapor Siswa</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-lg-8 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                <div class="col-md-3 col-12">
                                        <h5><?=$id_siswa;?></h5>
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
                            <div class="card-body px-4 py-4">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start noPrint">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldCalendar"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Semester</h6>
                                        <h6 class="font-extrabold mb-0"><?= $_POST['semester'] ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header noPrint">
                            <div class="row">
                                <div class="col-md-9 h4"></div>
                                <button onclick="window.print();" href="#" data-bs-toggle="modal" data-bs-target="#" type="button" class="col-md-3 btn icon icon-left btn-primary rounded-pill noPrint"><i class="bi bi-printer-fill"></i>  Cetak</button>
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
                                        $num =1;
                                        $totalNilai=0;
                                        $pullData=mysqli_query($conn, "SELECT * FROM tb_nilai JOIN tb_siswa USING(id_siswa) WHERE id_siswa='$id_siswa' AND id_kelas='$id_kelas' AND semester='$semester'");
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
                <div class="footer clearfix mb-0 text-muted bottom-0 noPrint">
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