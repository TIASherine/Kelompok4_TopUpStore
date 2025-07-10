<?php
include 'header.php';
include '../konekDatabase.php';

$db = new konekDatabase();
$koneksi = $db->getConnection();

$sql = "FROM TRANSAKSI WHERE DATE(WAKTU_TR) = CURDATE()";

$countQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah $sql");
$countSql = mysqli_fetch_assoc($countQuery);
$count = $countSql['jumlah'];

$maxQuery = mysqli_query($koneksi, "SELECT MAX(HARGA) AS max_harga $sql");
$maxSql = mysqli_fetch_assoc($maxQuery);
$max = $maxSql['max_harga'];

$minQuery = mysqli_query($koneksi, "SELECT MIN(HARGA) AS min_harga $sql");
$minSql = mysqli_fetch_assoc($minQuery);
$min = $minSql['min_harga'];

$avgQuery = mysqli_query($koneksi, "SELECT AVG(HARGA) AS avg_harga $sql");
$avgSql = mysqli_fetch_assoc($avgQuery);
$avg = $avgSql['avg_harga'];

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status_filter']) ? trim($_GET['status_filter']) : '';

$sql = "SELECT * FROM TRANSAKSI WHERE 1=1";
$params = [];

if ($search !== '') {
    $search = mysqli_real_escape_string($koneksi, $search);
    $sql .= " AND (
        ID_TRANSAKSI LIKE '%$search%' OR
        ID_TOKO_TR LIKE '%$search%' OR
        ID_PEMBELI_TR LIKE '%$search%' OR
        PRODUK_TRANSAKSI LIKE '%$search%' OR
        HARGA LIKE '%$search%' OR
        METODE_PEMBAYARAN LIKE '%$search%' OR
        WAKTU_TR LIKE '%$search%'
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

<style>
    .admin-containers {
        width: 350px;
        min-height: 100px;
        width: 90%;
        margin: 30px auto;
        padding: 30px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    table {
        margin-bottom: 15px;
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
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

<main class="main-content">
    <div style="dashboard-title">
        <h1> DASHBOARD </h1>

        <br>

        <h3> Rangkuman Transaksi Tanggal <strong style="color:rgb(175, 48, 230);"> <?php echo date('Y-m-d'); ?>
            </strong> </h3>
    </div>

    <br>

    <div class="admin">
        <div class="admin-containers">
            <h4> Jumlah Transaksi <br><br> </h4>
            <br>
            <div class="dashboard">
                <?php echo $count ?>
            </div>
        </div>

        <div class="admin-containers">
            <h4> Produk Dengan Harga Termahal </h4>
            <br>
            <div class="dashboard">
                <?php echo "Rp " . number_format($max, 0, ',', '.'); ?>
            </div>
        </div>

        <div class="admin-containers">
            <h4> Produk Dengan Harga Termurah </h4>
            <br>
            <div class="dashboard">
                <?php echo "Rp " . number_format($min, 0, ',', '.'); ?>
            </div>
        </div>

        <div class="admin-containers">
            <h4> Rata-rata Pendapatan <br><br> </h4>
            <br>
            <div class="dashboard">
                <?php echo "Rp " . number_format($avg, 0, ',', '.'); ?>
            </div>
        </div>
    </div>

    <div class="admin-container">
        <h1> Riwayat Transaksi </h1>

        <form method="GET" class="search-bar">
            <input type="text" name="search" placeholder="Cari Transaksi.." value="<?= htmlspecialchars($search) ?>">
            <select name="status_filter">
                <option value=""> Tampilkan Semua </option>
                <option value="menunggu" <?= $status_filter == 'menunggu' ? 'selected' : '' ?>> Menunggu </option>
                <option value="selesai" <?= $status_filter == 'selesai' ? 'selected' : '' ?>> Selesai </option>
                <option value="gagal" <?= $status_filter == 'gagal' ? 'selected' : '' ?>> Gagal </option>
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
                    <tr>
                        <td colspan="9"> Data transaksi tidak ditemukan.</td>
                    </tr>
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
                                <a
                                    href="../crud.php?aksi=update&id=<?= $order['ID_TRANSAKSI'] ?>&table=TRANSAKSI&redirect=admin/adminHome.php">
                                    <img src="../edit.jpeg" alt="Edit" style="width: 25px;">
                                </a>

                                <a href="../crud.php?aksi=delete&id=<?= $order['ID_TRANSAKSI'] ?>&table=TRANSAKSI&redirect=admin/adminHome.php"
                                    onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    <img src="../trash.jpg" alt="Hapus" style="width: 20px;">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <br> <br>

        <a href="adminHome.php"> ← Kembali </a>
    </div>
</main>
</body>

</html>