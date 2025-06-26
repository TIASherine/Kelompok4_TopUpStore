<?php  
include 'konekDatabase.php';
$id = $_GET['id'];


$koneksi->query("DELETE FROM topupstore WHERE id = $id");

header("Location: Admin.php");
?>