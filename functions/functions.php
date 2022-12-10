<?php

//Format tanggal
function tanggal($tanggal){
    return date('d F Y', strtotime($tanggal));
}

//Get Total Siswa
function getTotalSiswa($conn){
    $sql = 'SELECT COUNT(id_siswa) AS total_siswa FROM tb_siswa';
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        return $row['total_siswa'];
    }
}

//Get Total Guru
function getTotalGuru($conn){
    $sql = 'SELECT COUNT(id_guru) AS total_guru FROM tb_guru';
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        return $row['total_guru'];
    }
}

//Get Total Kelas
function getTotalKelas($conn){
    $sql = 'SELECT COUNT(id_kelas) AS total_kelas FROM tb_kelas';
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        return $row['total_kelas'];
    }
}

//Get Total Siswa Perempuan
function getTotalSiswaP($conn){
    $sql = 'SELECT COUNT(id_siswa) AS total_siswaP FROM tb_siswa WHERE jenis_kelamin ="Perempuan"';
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        return $row['total_siswaP'];
    }
}

//Get Total Siswa Laki-Laki
function getTotalSiswaL($conn){
    $sql = 'SELECT COUNT(id_siswa) AS total_siswaL FROM tb_siswa WHERE jenis_kelamin ="Laki-Laki"';
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        return $row['total_siswaL'];
    }
}

//Get Total
function getTotal($conn, $table, $field) {
    $sql = "SELECT COUNT($field) as total FROM $table";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
}

//Get ID User
function getIdUser($conn){
    $sql = mysqli_query($conn, "SELECT max(id_user) as maxrow FROM tb_user");
    $data = mysqli_fetch_array($sql);
    $id = $data['maxrow'];
    $order = (int) substr($id, 3, 3);
    $order++;
    $code = 'US';
    $id = $code.sprintf("%03s", $order);
    return $id;
    
}

//Get ID Guru
function getIdGuru($conn){
    $sql = mysqli_query($conn, "SELECT max(id_guru) as maxrow FROM tb_guru");
    $data = mysqli_fetch_array($sql);
    $id = $data['maxrow'];
    $order = (int) substr($id, 2,2);
    $order++;
    $code = 'GR';
    $id = $code.sprintf("%02s", $order);
    return $id;
    
}

//Get ID Siswa
function getIdSiswa($conn){
    $sql = mysqli_query($conn, "SELECT max(id_siswa) as maxrow FROM tb_siswa");
    $data = mysqli_fetch_array($sql);
    $id = $data['maxrow'];
    $order = (int) substr($id, 3, 3);
    $order++;
    $code = 'SW';
    $id = $code.sprintf("%03s", $order);
    return $id;
    
}

//Get ID Mapel
function getIdMapel($conn){
    $sql = mysqli_query($conn, "SELECT max(id_mapel) as maxrow FROM tb_mapel");
    $data = mysqli_fetch_array($sql);
    $id = $data['maxrow'];
    $order = (int) substr($id, 2, 2);
    $order++;
    $code = 'MP';
    $id = $code.sprintf("%02s", $order);
    return $id;
    
}

//Generate Password
function generatePass($conn, $tgl){
    return preg_replace("/-/", "", $tgl);
}

//Create Username
function createUsername($conn, $nama, $tgl){
    $revTgl =preg_replace("/-/", "", $tgl );
    $cutName= substr($nama, 0,3);
    $cutNumber= substr($revTgl, 4, 4);
    $username= $cutName.$cutNumber;
    return $username;
}


?>