<?php

date_default_timezone_set('Asia/Jakarta');

$host   = 'localhost';
$user   = 'root';
$pass   = '';
$dbname = 'db_mymoro';

$koneksi = mysqli_connect($host, $user, $pass, $dbname);
$koneksi = mysqli_connect("localhost", "root", "", "db_mymoro");

// if (mysqli_connect_errno()) {
//     echo "gagal koneksi ke database";
//     exit();
// } else {
//     echo "berhasil koneksi ke database";
// }

$main_url = "http://localhost/mymoro/";

?>