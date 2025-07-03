<?php
include 'konekDatabase.php';

// Fungsi untuk mendapatkan semua pesanan
function getOrders($conn, $search = null, $status_filter = null)
{
    $sql = "SELECT * FROM transaksi WHERE 1=1";
    $params = [];
    $types = "";

    if ($search) {
        $sql .= " AND (ID_TRANSAKSI LIKE ? OR ID_TOKO_TR LIKE ? OR ID_PLAYER_TR	 LIKE ? OR PRODUK_TRANSAKSI LIKE ?) OR HARGA LIKE ? OR WAKTU_TR LIKE ?";
        $search_term = "%$search%";
        $params = array_fill(0, 4, $search_term);
        $types = "ssss";
    }

    if ($status_filter) {
        $sql .= " AND status = ?";
        $params[] = $status_filter;
        $types .= "s";
    }

    $sql .= " ORDER BY WAKTU_TR ASC";

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}

// Proses update status
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['ID_TRANSAKSI']);
    $new_status = in_array($_POST['new_status'], ['pending', 'selesai', 'gagal']) ? $_POST['new_status'] : 'pending';

    $stmt = $koneksi->prepare("UPDATE TRANSAKSI SET STATUS = ? WHERE ID_TRANSAKSI = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.php");
    exit;
}

// Proses hapus pesanan
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    $stmt = $koneksi->prepare("DELETE FROM TRANSAKSI WHERE ID_TRANSAKSI = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.php");
    exit;
}

// Ambil parameter pencarian
$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : null;

$orders = getOrders($koneksi, $search, $status_filter);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Analog Store</title>
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
        color: red;
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
                    style="height: 25px; width: 200px; margin: 10px 0;">

                <br>

                <select name="status_filter">
                    <option value=""> Tampilkan Semua </option>
                    <option value="pending" <?php echo ($status_filter == 'pending') ? 'selected' : ''; ?>> Pending
                    </option>
                    <option value="selesai" <?php echo ($status_filter == 'completed') ? 'selected' : ''; ?>> Selesai
                    </option>
                    <option value="gagal" <?php echo ($status_filter == 'failed') ? 'selected' : ''; ?>> Gagal </option>
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
                
                <tr>
                    <a href="crud.php?aksi=tambah&id=<?= isset($_GET['id']) ? $_GET['id'] : '' ?>"> Tambah </a> &nbsp;
                    <a href="crud.php?aksi=update&id=<?= isset($_GET['id']) ? $_GET['id'] : '' ?>"> Edit </a>
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
                        <table>
                            <tr>
                                <td><?php echo htmlspecialchars($order['ID_TRANSAKSI']); ?></td>
                                <td><?php echo htmlspecialchars($order['ID_TOKO_TR']); ?></td>
                                <td><?php echo htmlspecialchars($order['ID_PLAYER_TR']); ?></td>
                                <td><?php echo htmlspecialchars($order['PRODUK_TRANSAKSI']); ?></td>
                                <td>Rp <?php echo number_format($order['HARGA'], 0, ',', '.'); ?></td>
                                <td><?php echo date('Y M d', strtotime($order['WAKTU_TR'])); ?></td>
                                <td><?php echo htmlspecialchars($order['STATUS']); ?></td>

                                <td class="actions">
                                    <a href="crud.php?aksi=update&id=<?= $order['ID_TRANSAKSI'] ?>">
                                        <img src="edit.jpeg" alt="Lihat" style="width: 30px; height: 20px;">
                                    </a>

                                    <a href="crud.php?aksi=hapus&id=<?= $order['ID_TRANSAKSI'] ?>"
                                        onclick="return confirm('Yakin Ingin Menghapus Riwayat?')">
                                        <img src="trash.jpg" alt="Hapus" style="width: 25px; height: 20px;">
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="home.php"> Kembali </a>
    </div>
</body>

</html>