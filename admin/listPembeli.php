<?php
include '../konekDatabase.php';

$db = new konekDatabase();
$koneksi = $db->getConnection();

// Fungsi untuk mendapatkan semua pesanan
function getPembeli($conn, $search = null)
{
    $sql = "SELECT * FROM PEMBELI WHERE 1 = 1";
    $params = [];
    $types = "";

    if ($search) {
        $sql .= " AND (ID_PEMBELI LIKE ? OR USERNAME LIKE ? OR AKUN_WEBSITE LIKE ?)";
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

// Ambil parameter pencarian
$search = isset($_GET['search']) ? trim($_GET['search']) : null;

$pembeli = getPembeli($koneksi, $search);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pembeli Bennett id </title>
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
                    <th> UID </th>
                    <th> Username </th>
                    <th> Akun </th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($pembeli)): ?>
                    <tr>
                        <td colspan="3"> Data pembeli tidak ditemukan. </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pembeli as $list): ?>
                        <tr>
                            <td><?= htmlspecialchars($list['ID_PEMBELI']) ?></td>
                            <td><?= htmlspecialchars($list['USERNAME']) ?></td>
                            <td><?= htmlspecialchars($list['AKUN_WEBSITE']) ?></td>
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