<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analog Store - Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <a href="home.html" class="logo">Bennett id</a>
        <nav>
            <a href="home.html">Home</a>
            <a href="Produk.html">Products</a>
            <a href="shop.php">Shop</a>
            <a href="about_us.html">About Us</a>
            <a href="contact.html">Contact Us</a>
            <a href="Admin.php" class="navigation">Admin</a>
        </nav>
    </header>

    <div class="admin-container">
        <h2 class="admin-title">Data Admin</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $admins = [
                    ['id' => 1, 'nama' => 'Admin Utama', 'email' => 'admin@bennett.id'],
                    ['id' => 2, 'nama' => 'Staff IT', 'email' => 'it@bennett.id'],
                    ['id' => 3, 'nama' => 'Marketing', 'email' => 'marketing@bennett.id']
                ];
                
                foreach ($admins as $admin) {
                    echo "<tr>
                            <td>{$admin['id']}</td>
                            <td>{$admin['nama']}</td>
                            <td>{$admin['email']}</td>
                            <td>
                                <button class='action-btn edit-btn'>Edit</button>
                                <button class='action-btn delete-btn'>Hapus</button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>