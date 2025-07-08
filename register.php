<?php
session_start();
include 'konekDatabase.php';

// Redirect jika sudah login
if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

// Proses registrasi
$errors = [];
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi dan validasi input
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi input (sama seperti sebelumnya)
    // ... [kode validasi yang sama]
    
    if(empty($errors)) {
        // Cek username/email dan simpan ke database
        // ... [kode database yang sama]
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
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.pexels.com/photos/3165335/pexels-photo-3165335.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            padding: 30px;
            width: 350px;
            text-align: center;
            color: white;
        }

        .register-container h1 {
            color: white;
            margin-bottom: 24px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            color: white;
            box-sizing: border-box;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .register-button {
            width: 100%;
            padding: 12px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .register-button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .error-message {
            color: #ff6b6b;
            margin-bottom: 16px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .login-link {
            margin-top: 16px;
            display: block;
            color: rgba(255, 255, 255, 0.8);
        }

        .login-link a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .password-hint {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 5px;
            text-align: left;
        }

        .field-error {
            color: #ff6b6b;
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
            text-shadow: 0 1px 1px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Daftar Akun Baru</h1>
        
        <?php if(isset($errors['general'])): ?>
            <div class="error-message"><?php echo htmlspecialchars($errors['general']); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" 
                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                       required>
                <?php if(isset($errors['name'])): ?>
                    <span class="field-error"><?php echo htmlspecialchars($errors['name']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                       required>
                <?php if(isset($errors['username'])): ?>
                    <span class="field-error"><?php echo htmlspecialchars($errors['username']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                       required>
                <?php if(isset($errors['email'])): ?>
                    <span class="field-error"><?php echo htmlspecialchars($errors['email']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div class="password-hint">Minimal 8 karakter, mengandung huruf besar dan angka</div>
                <?php if(isset($errors['password'])): ?>
                    <span class="field-error"><?php echo htmlspecialchars($errors['password']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <?php if(isset($errors['confirm_password'])): ?>
                    <span class="field-error"><?php echo htmlspecialchars($errors['confirm_password']); ?></span>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="register-button">Daftar</button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="login.php">Login disini</a>
        </div>
    </div>

    <script>
    // Validasi client-side
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if(password.length < 8) {
            alert('Password harus minimal 8 karakter');
            e.preventDefault();
            return;
        }
        
        if(!/[A-Z]/.test(password) || !/[0-9]/.test(password)) {
            alert('Password harus mengandung huruf besar dan angka');
            e.preventDefault();
            return;
        }
        
        if(password !== confirmPassword) {
            alert('Password dan konfirmasi password tidak sama');
            e.preventDefault();
        }
    });
    </script>
</body>
</html>