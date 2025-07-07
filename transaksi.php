<?php
include 'konekDatabase.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : null;

$sql = "SELECT * FROM TRANSAKSI_TOP_UP WHERE 1";
if ($search) {
    $search = mysqli_real_escape_string($koneksi, $search);
    $sql .= " AND (ID_TRANSAKSI LIKE '%$search%' OR ID_TOKO_TR LIKE '%$search%' OR ID_PLAYER_TR LIKE '%$search%' OR PRODUK_TRANSAKSI LIKE '%$search%')";
}
if ($status_filter) {
    $status_filter = mysqli_real_escape_string($koneksi, $status_filter);
    $sql .= " AND STATUS = '$status_filter'";
}

$sql .= " ORDER BY WAKTU_TR DESC";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Transaksi Bennet id </title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    table {
        margin-bottom: 15px;
    }

    tr,
    td,
    th {
        text-align: center;
        width: 200px;
    }

    a {
        color: rgb(107, 228, 63);
        text-decoration: none;
    }
</style>

<body>
    <div class="admin-container">
        <h1> Riwayat Transaksi </h1>

        <br>

        <div class="search-bar">
            <form method="GET">
                <input type="text" name="search" placeholder="Cari Transaksi.."
                    value="<?php echo htmlspecialchars($search ?? ''); ?>"
                    style="height: 20px; width: 200px; margin: 10px 0;">

                <br>

                <select name="status_filter">
                    <option value=""> Tampilkan Semua </option>
                    <option value="pending" <?php echo ($status_filter == 'menunggu') ? 'selected' : ''; ?>> Menunggu
                    </option>
                    <option value="selesai" <?php echo ($status_filter == 'selesai') ? 'selected' : ''; ?>> Selesai
                    </option>
                    <option value="gagal" <?php echo ($status_filter == 'gagal') ? 'selected' : ''; ?>> Gagal </option>
                </select>

                <button type="submit" style="width: 50px;"> Filter </button>

            </form>
        </div>

        <br>

        <table>
            <thead>
                <tr>
                    <th> ID Order </th>
                    <th> ID Toko </th>
                    <th> ID Pembeli </th>
                    <th> Pembelian </th>
                    <th> Harga </th>
                    <th> Tanggal </th>
                    <th> Status </th>
                    <th> Aksi </th>
                </tr>

            </thead>

            <br> <br>

            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="10" class="no-orders">No orders found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['ID_TRANSAKSI']); ?></td>
                            <td><?php echo htmlspecialchars($order['ID_TOKO_TR']); ?></td>
                            <td><?php echo htmlspecialchars($order['ID_PLAYER_TR']); ?></td>
                            <td><?php echo htmlspecialchars($order['PRODUK_TRANSAKSI']); ?></td>
                            <td> Rp <?php echo number_format($order['HARGA'], 0, ',', '.'); ?></td>
                            <td><?php echo date('Y M d', strtotime($order['WAKTU_TR'])); ?></td>
                            <td><?php echo htmlspecialchars($order['STATUS']); ?></td>

                            <td class="actions">
                                <a
                                    href="crud.php?aksi=update&id=<?= $order['ID_TRANSAKSI'] ?>&table=TRANSAKSI&redirect=transaksi.php">
                                    <img src="edit.jpeg" alt="Edit" style="width: 30px; height: 20px;">
                                </a>

                                <a href="crud.php?aksi=hapus&id=<?= $order['ID_TRANSAKSI'] ?>&table=TRANSAKSI&redirect=transaksi.php"
                                    onclick="return confirm('Yakin Ingin Menghapus Riwayat?')">
                                    <img src="trash.jpg" alt="Hapus" style="width: 25px; height: 20px;">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="home.php"> Kembali </a>
    </div>
</body>

</html>