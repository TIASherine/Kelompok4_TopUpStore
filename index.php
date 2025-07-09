<?php
session_start();
include 'konekDatabase.php';

$db = new konekDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $akun = $_POST['akun'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($akun != "sudo_admin") {
        $result = $db->execute("SELECT * FROM AKUN WHERE NAMA_AKUN = '$akun'");

        if (!$result || count($result) === 0) {
            echo "<script> alert('User Tidak Ditemukan!'); window.location.href='index.php'; </script>";
            exit;
        }

        if ($result[0]['PASSWORD'] !== $password) {
            echo "<script> alert('Password Salah!'); window.location.href='index.php'; </script>";
            exit;
        }

        $_SESSION['username'] = $akun;
        header("Location: user/home.php");
    } else {
        if ($password != 'admin') {
            echo "<script> alert('Password Salah!'); window.location.href='index.php'; </script>";
            exit;
        }
        
        $_SESSION['username'] = 'Admin';
        header("Location: admin/adminHome.php");
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login - Analog Store </title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.pexels.com/photos/3165335/pexels-photo-3165335.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h2> Login </h2>
        <form action="" method="post">
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <input type="text" id="akun" name="akun" placeholder="Nama Akun" required>
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="register-button"> Login </button>
            </form>

            <div class="register-link">
                Belum punya akun? <a href="register.php"> Daftar disini </a>
            </div>
        </form>
    </div>
</body>

</html>

<script>
    function login() {
        const akun = document.getElementById('akun').value;
    }
</script>