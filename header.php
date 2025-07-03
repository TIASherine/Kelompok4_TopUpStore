<?php

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analog Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @import url(https://images.pexels.com/photos/3165335/pexels-photo-3165335.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2);
    </style>
</head>

<body>
    <header>
        <a href="home.html" class="logo"> Bennett id </a>
        <nav>
            <a class="<?= ($page == 'home') ? 'navigation' : '' ?>" href="home.php"> Beranda </a>
            <a class="<?= ($page == 'game') ? 'navigation' : '' ?>" href="game.php"> Game </a>
            <a href="transaksi.php"> Transaksi </a>
            <a href="listPembeli.php"> List Pembeli </a>
        </nav>
    </header>
