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
        <a href="home.html" class="logo">Bennett id</a>
        <nav>
            <a class="<?= ($page == 'home') ? 'navigation' : '' ?>" href="home.php"> Home </a>
            <a class="<?= ($page == 'produk') ? 'navigation' : '' ?>" href="Produk.php"> Products </a>
            <a class="<?= ($page == 'about') ? 'navigation' : '' ?>" href="about_us.php"> About Us </a>
            <a class="<?= ($page == 'contact') ? 'navigation' : '' ?>" href="contact.php"> Contact Us </a>
            <a class="<?= ($page == 'index') ? 'navigation' : '' ?>" href="index.php"> Login </a>
        </nav>
    </header>

    <div class="break"> </div>