<?php
$host_koneksi = "localhost";
$username_koneksi = "root";
$password_koneksi = "";
$database_koneksi = "perpustakaan_2";

$koneksi = mysqli_connect($host_koneksi, $username_koneksi, $password_koneksi, $database_koneksi);


if (!$koneksi) {
    die("Error mysqli" . mysqli_connect_error());
}
