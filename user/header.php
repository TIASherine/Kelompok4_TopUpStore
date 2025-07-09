<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$akun = $_SESSION['username'] ?? 'Login';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analog Store</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        @import url(https://images.pexels.com/photos/3165335/pexels-photo-3165335.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2);
    </style>
</head>

<body>
    <header>
        <a href="home.php" class="logo"> <?php echo $akun ?> </a>
        <nav>
            <a class="<?= ($page == 'game') ? 'navigation' : '' ?>" href="game.php"> Beranda </a>
            <a class="<?= ($page == 'riwayat') ? 'navigation' : '' ?>" href="riwayat.php"> Riwayat </a>
            <a href="../index.php"> Keluar </a>
        </nav>
    </header>