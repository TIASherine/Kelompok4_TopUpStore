<?php
session_start();
include 'konekDatabase.php';

$db = new konekDatabase();
$koneksi = $db->getConnection();

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $akun = trim($_POST['akun']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($errors)) {
        $stmt = $koneksi->prepare("SELECT * FROM AKUN WHERE NAMA_AKUN = ? OR EMAIL = ?");
        $stmt->bind_param("ss", $akun, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors['general'] = "Nama akun atau email sudah digunakan";
        } else {
            $stmt = $koneksi->prepare("INSERT INTO AKUN (NAMA_AKUN, EMAIL, PASSWORD) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $akun, $email, $password);
            $stmt->execute();

            header("Location: index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Analog Store</title>
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
        <h2> Daftar Akun Baru </h2>

        <?php if (isset($errors['general'])): ?>
            <div class="error-message"><?php echo htmlspecialchars($errors['general']); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <input type="text" id="akun" name="akun"
                    value="<?php echo isset($_POST['akun']) ? htmlspecialchars($_POST['akun']) : ''; ?>"
                    placeholder="Nama Akun" required>
                <?php if (isset($errors['akun'])): ?>
                    <span class="field-error"><?php echo htmlspecialchars($errors['akun']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="email" id="email" name="email"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    placeholder="Email" required>
                <?php if (isset($errors['email'])): ?>
                    <span class="field-error"><?php echo htmlspecialchars($errors['email']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <?php if (isset($errors['password'])): ?>
                    <span class="field-error"><?php echo htmlspecialchars($errors['password']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password"
                    required>
                <?php if (isset($errors['confirm_password'])): ?>
                    <span class="field-error"><?php echo htmlspecialchars($errors['confirm_password']); ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" class="register-button">Daftar</button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="index.php">Login disini</a>
        </div>
    </div>

    <script>
        // Validasi client-side
        document.querySelector('form').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert('Password tidak sama!');
                e.preventDefault();
            }
        });
    </script>
</body>

</html>