<?php

function getTotalSiswa($conn){
    $sql = 'SELECT COUNT(id_siswa) AS total_siswa FROM tb_siswa';
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        return $row['total_siswa'];
    }
}

function getTotalGuru($conn){
    $sql = 'SELECT COUNT(id_guru) AS total_guru FROM tb_guru';
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        return $row['total_guru'];
    }
}

function getTotalKelas($conn){
    $sql = 'SELECT COUNT(id_kelas) AS total_kelas FROM tb_kelas';
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        return $row['total_kelas'];
    }
}

function getTotalSiswaP($conn){
    $sql = 'SELECT COUNT(id_siswa) AS total_siswP FROM tb_siswa WHERE jenis_kelamin ="P"';
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        return $row['total_siswaP'];
    }
}

function getTotalSiswaL($conn){
    $sql = 'SELECT COUNT(id_siswa) AS total_siswL FROM tb_siswa WHERE jenis_kelamin ="L"';
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        return $row['total_siswaL'];
    }
}


?>