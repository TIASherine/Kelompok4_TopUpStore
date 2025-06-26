<?php  
include 'koneksiDB.php';
$id = $_GET['id'];


$koneksi->query("DELETE FROM MAHASISWA WHERE id = $id");

header("Location: tampilMHS.php");
?>