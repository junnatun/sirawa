<?php
//koneksi ke db

$server = "localhost";
$user = "root";
$pass = "";
$db = "sirawa";

$conn = mysqli_connect($server, $user, $pass, $db);

if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}

?>