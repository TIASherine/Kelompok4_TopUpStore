<?php
include 'konekDatabase.php';

$aksi = $_GET['aksi'] ?? '';
$id = $_GET['id'] ?? '';
$data = [];

if ($aksi === 'hapus') {
    $koneksi->query("DELETE FROM TRANSAKSI WHERE ID_TRANSAKSI = '$id'");
    header("Location: transaksi.php");
    exit;
}

if ($aksi === 'update') {
    $result = $koneksi->query("SELECT * FROM TRANSAKSI WHERE ID_TRANSAKSI = '$id'");
    $data = $result->fetch_assoc();
}

$waktu_tr_raw = $order['WAKTU_TR'] ?? '';
$waktu_tr_formatted = $waktu_tr_raw ? date('Y-m-d\TH:i', strtotime($waktu_tr_raw)) : '';

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">

    <title><?= ucfirst($aksi) ?> Transaksi</title>

    <style>
        @import url(https://images.pexels.com/photos/3165335/pexels-photo-3165335.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2);

        body {
            background-color: blanchedalmond;
            font-family: 'Times New Roman', Times, serif;
        }

        fieldset {
            background-color: rgba(70, 78, 110, 0.5);
            margin: 100px auto;
            width: 50%;
            padding: 20px;
            border: none;
        }

        table {
            width: 100%;
            font-size: 16px;
        }

        td {
            padding: 6px;
        }

        h2 {
            text-align: center;
        }

        input[type="text"],
        input[type="datetime-local"],
        select {
            width: 60%;
            padding: 6px;
            font-size: 14px;
            margin-left: 10px;
        }
        
        select {
            width: 64%;
        }

        input[type="submit"], 
        input[type="button"] {
            min-width: 70px;
            margin-top: 10px;
            padding: 6px 12px;
        }
    </style>
</head>

<body>

    <fieldset>
        <form method="post">
            <h2><?= ucfirst($aksi) ?> Transaksi</h2>

            <br>

            <table>
                <?php if ($aksi !== 'update'): ?>
                    <tr>
                        <td>ID TRANSAKSI</td>
                        <td> : <input type="text" name="ID_TRANSAKSI"></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td>ID TRANSAKSI</td>
                        <td> : <?= $data['ID_TRANSAKSI'] ?></td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td>ID TOKO</td>
                    <td> : <input type="text" name="ID_TOKO_TR" value="<?= $data['ID_TOKO_TR'] ?? '' ?>"></td>
                </tr>
                <tr>
                    <td>ID PLAYER</td>
                    <td> : <input type="text" name="ID_PLAYER_TR" value="<?= $data['ID_PLAYER_TR'] ?? '' ?>">
                    </td>
                </tr>
                <tr>
                    <td>PRODUK</td>
                    <td>:
                        <select id="PRODUK_TRANSAKSI" name="PRODUK_TRANSAKSI" onchange="updateHarga()" required>
                            <option value=""> Pilih Produk </option>
                            <option value="diamondML"> Diamond - Mobile Legends </option>
                            <option value="diamondFF"> Diamond - Free Fire </option>
                            <option value="UC"> UC - PUBG </option>
                            <option value="points"> Points - Valorant </option>
                            <option value="primogem"> Primogem - Genshin Impact </option>
                            <option value="lunite"> Lunite - Wuthering Waves </option>
                            <option value="monochrome"> Monochrome - Zenless Zone Zero </option>
                            <option value="robux"> Robux - Roblox </option>
                            <option value="token"> Token - Honor of Kings </option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>HARGA</td>
                    <td>:
                        <input type="text" id="harga" name="HARGA" value="<?= $data['HARGA'] ?? '10000' ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>WAKTU TRANSAKSI</td>
                    <td> : <input type="datetime-local" name="WAKTU_TR" value="<?= $order['WAKTU_TR'] ?? '' ?>">
                    </td>
                </tr>

                <tr>
                    <td> METODE PEMBAYARN </td>
                    <td> :
                        <select id="paymentMethod" name="paymentMethod" onchange="paymentMethod()" required>
                            <option value=""> Pilih Metode Pembayaran </option>
                            <option value="dana"> DANA </option>
                            <option value="gopay"> GoPay </option>
                            <option value="ovo"> OVO </option>
                            <option value="bank"> Transfer Bank </option>
                            <option value="qris"> QRIS </option>
                        </select>
                    </td>
                </tr>
            </table>

            <br>

            <div style="text-align: center;">
                <input type="submit" name="submit" value="<?= ucfirst($aksi) ?>">
                <a href="transaksi.php"> <input type="button" name="cancel" value="Batal"> </a>
            </div>
        </form>
    </fieldset>

</body>

</html>

<?php
if (isset($_POST['cancel'])) {
    header("Location: transaksi.php");
    exit;
}

if (isset($_POST['submit'])) {
    $idTransaksi = $_POST['ID_TRANSAKSI'] ?? $data['ID_TRANSAKSI'];
    $idToko = $_POST['ID_TOKO_TR'];
    $idPlayer = $_POST['ID_PLAYER_TR'];
    $produk = $_POST['PRODUK_TRANSAKSI'];
    $harga = $_POST['HARGA'];
    $waktu = $_POST['WAKTU_TR'];

    if ($aksi === 'tambah') {
        $sql = "INSERT INTO TRANSAKSI VALUES ('$idTransaksi', '$idToko', '$idPlayer', '$produk', '$harga', '$waktu')";
    } elseif ($aksi === 'update') {
        $sql = "UPDATE TRANSAKSI SET 
                    ID_TOKO_TR = '$idToko',
                    ID_PLAYER_TR = '$idPlayer',
                    PRODUK_TRANSAKSI = '$produk',
                    HARGA = '$harga',
                    WAKTU_TR = '$waktu'
                WHERE ID_TRANSAKSI = '$idTransaksi'";
    }

    $koneksi->query($sql);
    header("Location: transaksi.php");
    exit;
}
?>

<script>
    function updateHarga() {
        const hargaMap = {
            diamondML: 10000,
            diamondFF: 15000,
            UC: 20000,
            points: 25000,
            primogem: 40000,
            lunite: 30000,
            monochrome: 30000,
            robux: 30000,
            token: 30000
        };

        const selectedProduk = document.getElementById('PRODUK_TRANSAKSI').value;
        const hargaInput = document.getElementById('harga');
        hargaInput.value = hargaMap[selectedProduk] ?? '';
    }
</script>