<?php
include 'konekDatabase.php';

$table = $_GET['table'] ?? 'TRANSAKSI';
$aksi = $_GET['aksi'] ?? '';
$id = $_GET['id'] ?? '';
$back = $_GET['redirect'] ?? $_SERVER['HTTP_REFERER'] ?? 'home.php';

$data = [];

// Tampilkan (untuk update)
if ($aksi == 'update') {
    $query = mysqli_query($koneksi, "SELECT * FROM $table WHERE ID_$table = '$id'");
    $data = mysqli_fetch_assoc($query);
}

// Hapus
if ($aksi == 'hapus') {
    mysqli_query($koneksi, "DELETE FROM $table WHERE ID_$table = '$id'");
    header("Location: $back");
    exit;
}

// Simpan ke db
if (isset($_POST['submit'])) {
    if ($aksi == 'update') {
        $id_field = "ID_$table";
        $id_val = $_POST[$id_field];
        unset($_POST[$id_field]);

        $sets = [];
        foreach ($_POST as $key => $val) {
            $sets[] = "$key = '$val'";
        }
        $sql = "UPDATE $table SET " . implode(", ", $sets) . " WHERE $id_field = '$id_val'";
    } else {
        $columns = implode(", ", array_keys($_POST));
        $values = "'" . implode("', '", array_values($_POST)) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    }

    mysqli_query($koneksi, $sql);
    header("Location: $back");
    exit;
}

$columns = [];
$cols = mysqli_query($koneksi, "SHOW COLUMNS FROM $table");
while ($c = mysqli_fetch_assoc($cols)) {
    $columns[] = $c['Field'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title><?= ucfirst($aksi ?: 'tambah') ?> <?= ucfirst(strtolower($table)) ?></title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }

        fieldset {
            margin: 60px auto;
            width: 50%;
            padding: 20px;
            background: white;
        }

        table td {
            padding: 8px;
        }

        input {
            width: 100%;
            padding: 5px;
        }

        .btn {
            margin-top: 15px;
            padding: 8px 20px;
        }
    </style>
</head>

<body>
    <?php if ($back == 'shop.php'):
        $game = $_POST['game'];
        $product = $_POST['product'];
        $price = preg_replace('/\D/', '', $_POST['price']);
        $playerId = $_POST['playerId'];
        $playerName = $_POST['playerName'];
        $paymentMethod = $_POST['paymentMethod'];
        $tanggal = date('Y-m-d');
        $redirect = $_POST['redirect'] ?? 'home.php';

        mysqli_query($koneksi, "INSERT IGNORE INTO PEMBELI (ID_PLAYER, USERNAME) VALUES ('$playerId', '$playerName')");

        mysqli_query($koneksi, "INSERT INTO TRANSAKSI (ID_TOKO_TR, ID_PLAYER_TR, PRODUK_TRANSAKSI, HARGA, METODE_PEMBAYARAN, WAKTU_TR, STATUS) 
                VALUES ('TOKO001', '$playerId', '$product', '$price', '$paymentMethod', '$tanggal', 'Menunggu')");

        header("Location: $back");
        exit;
    endif; ?>
</body>

</html>