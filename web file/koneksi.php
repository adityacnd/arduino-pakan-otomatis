<?php
$host = "localhost"; //alamat host database
$user = "root"; //username database
$password = ""; //password database
$database = "uaspirdas"; //nama database

//buat koneksi ke database
$konek = mysqli_connect($host, $user, $password, $database);

//cek koneksi ke database
if (mysqli_connect_errno()) {
    echo "Gagal melakukan koneksi ke MySQL: " . mysqli_connect_error();
    exit();
}
?>