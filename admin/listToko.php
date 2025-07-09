<?php
include '../konekDatabase.php';

$db = new konekDatabase();
$koneksi = $db->getConnection();

// Fungsi untuk mendapatkan semua pesanan
function getToko($conn, $search = null)
{
    $sql = "SELECT * FROM TOKO WHERE 1 = 1";
    $params = [];
    $types = "";

    if ($search) {
        $sql .= " AND (ID_TOKO LIKE ? OR NAMA_GAME LIKE ?)";
        $search_term = "%$search%";
        $params = [$search_term, $search_term];
        $types = "ss";
    }


    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $toko = [];
    while ($row = $result->fetch_assoc()) {
        $toko[] = $row;
    }

    return $toko;
}

// Proses hapus data
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    $stmt = $koneksi->prepare("DELETE FROM TOKO WHERE ID_TOKO = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    header("Location: listToko.php");
    exit;
}

// Ambil parameter pencarian
$search = isset($_GET['search']) ? trim($_GET['search']) : null;

$toko = getToko($koneksi, $search);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Toko Bennett id </title>
    <link rel="stylesheet" href="../style.css">
</head>

<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 350px;
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
</style>

<body>
    <div class="admin-container">
        <h1> List Toko </h1>

        <br>
    
        <div class="search-bar">
            <form method="GET">
                <input type="text" name="search" placeholder="Cari Toko .."
                    value="<?php echo htmlspecialchars($search ?? ''); ?>"
                    style="height: 20px; width: 200px; margin: 10px 0;">

                <button type="submit" style="width: 50px;"> Cari </button>

            </form>
        </div>

        <br> <br>

        <table>
            <thead>
                <tr>
                    <th> ID Toko </th>
                    <th> Nama Game </th>
                    <th> Produk </th>
                    <th> Harga </th>
                    <th> Aksi </th>
                </tr>
            </thead>

            <tbody>
            <tbody>
                <?php if (empty($toko)): ?>
                    <tr>
                        <td colspan="5"> Data toko tidak ditemukan. </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($toko as $list): ?>
                        <?php $hargaAngka = preg_replace('/\D/', '', $list['HARGA']); ?>
                        <tr>
                            <td><?= htmlspecialchars($list['ID_TOKO']) ?></td>
                            <td><?= htmlspecialchars($list['NAMA_GAME']) ?></td>
                            <td><?= htmlspecialchars($list['PRODUK']) ?></td>
                            <td><?= htmlspecialchars($list['HARGA']) ?></td>
                            <td>
                                <a href="../crud.php?aksi=hapus&id=<?= $order['ID_TOKO'] ?>&table=TOKO&redirect=listToko.php"
                                    onclick="return confirm('Yakin ingin menghapus toko ini?')">
                                    <img src="../trash.jpg" alt="Hapus" width="20">
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
</body>

</html>