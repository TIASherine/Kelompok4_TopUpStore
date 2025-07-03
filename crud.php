<?php
include 'konekDatabase.php';

$aksi = $_GET['aksi'] ?? '';
$id = $_GET['id'] ?? '';

if ($aksi == 'hapus') {
    $koneksi->query("DELETE FROM TRANSAKSI WHERE ID_TRANSAKSI = '$id'");
    header("Location: transaksi.php");
    exit();
}

if ($aksi == 'update') {
    $query = mysqli_query($koneksi, "SELECT * FROM TRANSAKSI WHERE ID_TRANSAKSI = '$id'");
    $data = mysqli_fetch_array($query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= ucfirst($aksi) ?> Data Transaksi</title>
    <style>
        table, fieldset {
            font-size: 18px;
        }
        body {
            background-color: blanchedalmond;
        }
        fieldset {
            background-color: <?= $aksi == 'tambah' ? 'lavender' : 'khaki' ?>;
            margin: 100px auto;
            width: 50%;
        }
        td {
            padding: 8px;
        }
    </style>
</head>
<body>

<fieldset>
    <form action="" method="post">
        <h2><?= ucfirst($aksi) ?> Transaksi</h2>
        <hr>
        <table>
            <?php if ($aksi == 'update'): ?>
                <tr>
                    <td>ID TRANSAKSI</td>
                    <td>: <?= $data['ID_TRANSAKSI'] ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td>ID TRANSAKSI</td>
                    <td>: <input type="text" name="ID_TRANSAKSI" required></td>
                </tr>
            <?php endif; ?>

            <tr>
                <td>ID TOKO</td>
                <td>: <input type="text" name="ID_TOKO_TR" value="<?= $data['ID_TOKO_TR'] ?? '' ?>" required></td>
            </tr>
            <tr>
                <td>ID PLAYER</td>
                <td>: <input type="text" name="ID_PLAYER_TR" value="<?= $data['ID_PLAYER_TR'] ?? '' ?>" required></td>
            </tr>
            <tr>
                <td>PRODUK</td>
                <td>: <input type="text" name="PRODUK_TRANSAKSI" value="<?= $data['PRODUK_TRANSAKSI'] ?? '' ?>" required></td>
            </tr>
            <tr>
                <td>HARGA</td>
                <td>: <input type="text" name="HARGA" value="<?= $data['HARGA'] ?? '' ?>" required></td>
            </tr>
            <tr>
                <td>WAKTU TRANSAKSI</td>
                <td>: <input type="datetime-local" name="WAKTU_TR" value="<?= $data['WAKTU_TR'] ?? '' ?>" required></td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="submit" value="<?= ucfirst($aksi) ?>" style="margin-top: 10px;">
                    <input type="submit" name="cancel" value="Batal" style="margin-top: 10px;">
                </td>
            </tr>
        </table>
    </form>
</fieldset>

</body>
</html>

<?php
if (isset($_POST['cancel'])) {
    header("Location: transaksi.php");
    exit();
}

if (isset($_POST['submit'])) {
    $idTransaksi = 'ID_TRANSAKSI';
    $idToko = $_POST['ID_TOKO_TR'];
    $idPlayer = $_POST['ID_PLAYER_TR'];
    $produk = $_POST['PRODUK_TRANSAKSI'];
    $harga = $_POST['HARGA'];
    $waktu = $_POST['WAKTU_TR'];

    if ($aksi == 'tambah') {
        $sql = "INSERT INTO TRANSAKSI (ID_TRANSAKSI, ID_TOKO_TR, ID_PLAYER_TR, PRODUK_TRANSAKSI, HARGA, WAKTU_TR)
                VALUES ('$idTransaksi', '$idToko', '$idPlayer', '$produk', '$harga', '$waktu')";
    } elseif ($aksi == 'update') {
        $sql = "UPDATE TRANSAKSI SET 
                    ID_TOKO_TR = '$idToko',
                    ID_PLAYER_TR = '$idPlayer',
                    PRODUK_TRANSAKSI = '$produk',
                    HARGA = '$harga',
                    WAKTU_TR = '$waktu'
                WHERE ID_TRANSAKSI = '$idTransaksi'";
    }

    if (isset($sql)) {
        $koneksi->query($sql);
        header("Location: transaksi.php");
        exit();
    }
}
?>
