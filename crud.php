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
    <img src="" alt="">
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

    <main class="main-content">
        <div class="checkout-container">
            <div class="checkout-form">
                <h2 class="checkout-title"> Form Pembelian </h2>
                <form id="paymentForm" method="post" action="shop.php">
                    <div class="form-group">
                        <label for="game"> Game </label>
                        <input type="text" id="game" name="game" placeholder="Mobile Legends" readonly>
                    </div>

                    <div class="form-group">
                        <label for="product"> Produk </label>
                        <input type="text" id="product" name="product" placeholder="Diamond Mobile Legends" readonly>
                    </div>

                    <div class="form-group">
                        <label for="price"> Harga </label>
                        <input type="text" id="price" name="price" placeholder="Rp 10.000" readonly>
                    </div>

                    <div class="form-group">
                        <label for="pembeliId"> ID Pembeli </label>
                        <input type="text" id="pembeliId" name="pembeliId" placeholder="Masukkan ID Pembeli" required
                            value="<?= htmlspecialchars($pembeliId) ?>">
                    </div>

                    <div class="form-group">
                        <label for="name"> Username Pembeli </label>
                        <input type="text" id="name" name="name" placeholder="Masukkan Nama Pembeli" required
                            value="<?= htmlspecialchars($name) ?>">
                    </div>

                    <div class="form-group">
                        <label for="paymentMethod"> Metode Pembayaran </label>
                        <select id="paymentMethod" name="paymentMethod" required>
                            <option value=""> Pilih Metode Pembayaran </option>
                            <option value="DANA" <?= $paymentMethod == 'DANA' ? 'selected' : '' ?>>DANA</option>
                            <option value="GoPay" <?= $paymentMethod == 'GoPay' ? 'selected' : '' ?>>GoPay</option>
                            <option value="OVO" <?= $paymentMethod == 'OVO' ? 'selected' : '' ?>>OVO</option>
                            <option value="Bank Transfer" <?= $paymentMethod == 'Bank Transfer' ? 'selected' : '' ?>>
                                Transfer
                                Bank</option>
                            <option value="QRIS" <?= $paymentMethod == 'QRIS' ? 'selected' : '' ?>>QRIS</option>
                        </select>
                    </div>

                    <input type="hidden" name="idToko" id="idToko">
                    <br>

                    <button type="submit" class="confirm-button"> Konfirmasi Pembayaran </button>
                    <button type="button" class="confirm-button" onclick="window.location.href='home.php'"> Batal
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>