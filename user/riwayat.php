<?php
include '../konekDatabase.php';

$db = new konekDatabase();
$koneksi = $db->getConnection();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$akun = $_SESSION['username'] ?? 'Login';

$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : null;

$sql = "SELECT * FROM TRANSAKSI_USER WHERE 1";
if ($status_filter) {
    $status_filter = mysqli_real_escape_string($koneksi, $status_filter);
    $sql .= " AND STATUS = '$status_filter'";
}

$sql .= " ORDER BY TANGGAL DESC";

$result = mysqli_query($koneksi, $sql);

$history = [];
while ($row = mysqli_fetch_assoc($result)) {
    $history[] = $row;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Transaksi Bennet id </title>
    <link rel="stylesheet" href="../style.css">
</head>

<style>
    table {
        margin-bottom: 15px;
        width: 100%;
        border-collapse: collapse;
    }

    tr,
    td,
    th {
        text-align: center;
        width: 200px;
        padding: 8px;
        border: 1px solid #ccc;
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
                    <option value="menunggu" <?php echo ($status_filter == 'menunggu') ? 'selected' : ''; ?>> Menunggu
                    </option>
                    <option value="selesai" <?php echo ($status_filter == 'selesai') ? 'selected' : ''; ?>> Selesai
                    </option>
                </select>

                <button type="submit" style="width: 50px;"> Filter </button>

            </form>
        </div>

        <br>

        <table>
            <thead>
                <tr>
                    <th> UID </th>
                    <th> Username </th>
                    <th> Nama Akun </th>
                    <th> Pembelian </th>
                    <th> Harga </th>
                    <th> Metode Pembayaran </th>
                    <th> Tanggal </th>
                    <th> Status </th>
                </tr>

            </thead>

            <br> <br>

            <tbody>
                <?php if (empty($history)): ?>
                    <tr>
                        <td colspan="8" class="no-orders"> Tidak Ada Riwayat </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($history as $list): ?>
                        <?php if ($list['AKUN'] == $akun): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($list['UID']); ?></td>
                                <td><?php echo htmlspecialchars($list['USERNAME']); ?></td>
                                <td><?php echo htmlspecialchars($list['AKUN']); ?></td>
                                <td><?php echo htmlspecialchars($list['PEMBELIAN']); ?></td>
                                <td><?php echo "Rp " . number_format($list['HARGA'], 0, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars($list['METODE_PEMBAYARAN']); ?></td>
                                <td><?php echo date('Y M d', strtotime($list['TANGGAL'])); ?></td>
                                <td><?php echo htmlspecialchars($list['STATUS']); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="home.php"> ← Kembali </a>
    </div>
</body>

</html>