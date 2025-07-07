<?php
include 'konekDatabase.php';

// Fungsi untuk mendapatkan semua pesanan
function getPembeli($conn, $search = null, $status_filter = null)
{
    $sql = "SELECT * FROM PEMBELI WHERE 1 = 1";
    $params = [];
    $types = "";

    if ($search) {
        $sql .= " AND (ID_PLAYER LIKE ? OR USERNAME LIKE ? OR METODE_PEMBAYARAN LIKE ?)";
        $search_term = "%$search%";
        $params = [$search_term, $search_term, $search_term];
        $types = "sss";
    }


    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $pembeli = [];
    while ($row = $result->fetch_assoc()) {
        $pembeli[] = $row;
    }

    return $pembeli;
}

// Proses hapus data
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    $stmt = $koneksi->prepare("DELETE FROM PEMBELI WHERE ID_PLAYER = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    header("Location: listPembeli.php");
    exit;
}

// Ambil parameter pencarian
$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : null;

$pembeli = getPembeli($koneksi, $search, $status_filter);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pembeli Bennett id </title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 350px;
    }

    table {
        margin: 0 auto 35px auto;
        border-collapse: collapse;
    }

    tr,
    td,
    th {
        text-align: center;
        width: 150px;
    }

    a {
        color: rgb(107, 228, 63);
        text-decoration: none;
    }
</style>

<body>
    <div class="admin-container">
        <h1> List Pembeli </h1>

        <br>

        <div class="search-bar">
            <form method="GET">
                <input type="text" name="search" placeholder="Cari Pembeli.."
                    value="<?php echo htmlspecialchars($search ?? ''); ?>"
                    style="height: 20px; width: 200px; margin: 10px 0;">

                <button type="submit" style="width: 50px;"> Cari </button>

            </form>
        </div>

        <br> <br>

        <table>
            <thead>
                <tr>
                    <th>ID Player</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($pembeli as $list): ?>
                    <tr>
                        <td><?= htmlspecialchars($list['ID_PLAYER']) ?></td>
                        <td><?= htmlspecialchars($list['USERNAME']) ?></td>
                        <td>
                            <a href="listPembeli.php?delete_id=<?= urlencode($list['ID_PLAYER']) ?>"
                                onclick="return confirm('Yakin ingin menghapus pembeli ini?')">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


        <a href="home.php"> Kembali </a>
    </div>
</body>

</html>