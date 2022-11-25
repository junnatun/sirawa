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

function getUser($conn){

}



?>