<?php
$hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "topupstore";

    $koneksi = new mysqli($hostname, $username, $password, $database);

    if($koneksi->connect_error) {
        die("Koneksi Gagal");
    } else {
    }
?>