<?php
include 'konekDatabase.php';

// Ambil parameter dari form
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status_filter']) ? trim($_GET['status_filter']) : '';

// Bangun query
$sql = "SELECT * FROM TRANSAKSI_TOP_UP WHERE 1=1";
$params = [];

if ($search !== '') {
    $search = mysqli_real_escape_string($koneksi, $search);
    $sql .= " AND (
        ID_TOKO_TR LIKE '%$search%' OR
        ID_PEMBELI_TR LIKE '%$search%' OR
        PRODUK_TRANSAKSI LIKE '%$search%'
    )";
}

if ($status_filter !== '') {
    $status_filter = mysqli_real_escape_string($koneksi, $status_filter);
    $sql .= " AND STATUS = '$status_filter'";
}

$sql .= " ORDER BY ID_TRANSAKSI";

$result = mysqli_query($koneksi, $sql);
$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title> Riwayat Transaksi </title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { 
            margin-bottom: 15px; 
            width: 100%; 
            border-collapse: collapse; 
        }

        th, td { 
            text-align: center; 
            padding: 8px; 
            border: 1px solid #ccc; 
        }

        a { 
            color: rgb(107, 228, 63); 
            text-decoration: none; 
        }

        .search-bar { 
            margin: 20px 0; 
        }

        input[type="text"],
        select {
            height: 25px;
        }

        input[type="text"] {
            width: 150px;
        }

        button[type="submit"] {
            width: 60px;
            height: 25px;
        }

    </style>

</head>
<body>
    <div class="admin-container">
        <h1> Riwayat Transaksi </h1>

        <form method="GET" class="search-bar">
            <input type="text" name="search" placeholder="Cari Transaksi.." value="<?= htmlspecialchars($search) ?>">
            <select name="status_filter">
                <option value=""> Tampilkan Semua </option>
                <option value="menunggu" <?= $status_filter == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                <option value="selesai" <?= $status_filter == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                <option value="gagal" <?= $status_filter == 'gagal' ? 'selected' : '' ?>>Gagal</option>
            </select>
            <button type="submit"> Cari </button>
        </form>

        <table>
            <thead>
                <tr>
                    <th> ID Order </th>
                    <th> ID Toko </th>
                    <th> ID Pembeli </th>
                    <th> Pembelian </th>
                    <th> Harga </th>
                    <th> Metode Pembayaran </th>
                    <th> Tanggal </th>
                    <th> Status </th>
                    <th> Aksi </th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($orders)): ?>
                    <tr><td colspan="9">Tidak ada transaksi ditemukan.</td></tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['ID_TRANSAKSI']) ?></td>
                            <td><?= htmlspecialchars($order['ID_TOKO_TR']) ?></td>
                            <td><?= htmlspecialchars($order['ID_PEMBELI_TR']) ?></td>
                            <td><?= htmlspecialchars($order['PRODUK_TRANSAKSI']) ?></td>
                            <td>Rp <?= number_format($order['HARGA'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($order['METODE_PEMBAYARAN']) ?></td>
                            <td><?= date('Y-m-d', strtotime($order['WAKTU_TR'])) ?></td>
                            <td><?= htmlspecialchars($order['STATUS']) ?></td>
                            <td>
                                <a href="crud.php?aksi=update&id=<?= $order['ID_TRANSAKSI'] ?>&table=TRANSAKSI&redirect=transaksi.php">
                                    <img src="edit.jpeg" alt="Edit" width="25">
                                </a>
                                <a href="crud.php?aksi=hapus&id=<?= $order['ID_TRANSAKSI'] ?>&table=TRANSAKSI&redirect=transaksi.php"
                                   onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    <img src="trash.jpg" alt="Hapus" width="20">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="home.php"> ← Kembali </a>
    </div>
</body>
</html>
