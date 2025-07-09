<?php
include 'konekDatabase.php';

$db = new konekDatabase();
$koneksi = $db->getConnection();

$table = $_GET['table'] ?? 'TRANSAKSI';
$aksi = $_GET['aksi'] ?? '';
$id = $_GET['id'] ?? '';
$back = $_GET['redirect'] ?? $_SERVER['HTTP_REFERER'] ?? 'user/adminHome.php';

$data = [];

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
            if ($key === 'submit')
                continue;
            $sets[] = "$key = '$val'";
        }

        $sql = "UPDATE $table SET " . implode(", ", $sets) . " WHERE $id_field = '$id_val'";
    } else {
        $post_data = $_POST;
        unset($post_data['submit']);

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

// Tampilkan (untuk update)
if ($aksi == 'update') {
    $query = mysqli_query($koneksi, "SELECT * FROM $table WHERE ID_$table = '$id'");
    $data = mysqli_fetch_assoc($query);
}

?>

<!DOCTYPE html>
<html>
<title><?= ucfirst($aksi ?: 'tambah') ?> <?= ucfirst(strtolower($table)) ?></title>
<link rel="stylesheet" href="style.css">
<style>
    @import url(https://images.pexels.com/photos/3165335/pexels-photo-3165335.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2);

    .checkout-container {
        display: flex;
        align-items: center;
        max-width: 600px;
    }

    .checkout-form {
        padding: 50px;
    }

    table td {
        padding: 8px;
    }

    input[type="text"] {
        width: 90%;
        padding: 15px;
    }

    select {
        width: 100%;
    }

    .input-center {
        text-align: center;
        margin-top: 20px;
    }

    button {
        height: 43px;
        width: 60%;
        padding: 8px 20px;
        font-size: 1rem;
        color: white;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(0, 0, 0, 0.5);
    }
</style>

<body>
    <main class="main-content">
        <div class="checkout-container">
            <div class="checkout-form">
                <h2 class="checkout-title"> Form Pembelian </h2>
                <form method="POST" action="">
                    <?php foreach ($columns as $col): ?>
                        <?php if (strpos($col, 'ID_') === 0 && $aksi != 'update')
                            continue; ?>
                        <div class="form-group">
                            <label><?= $col ?></label>
                            <?php if ($col == 'STATUS'): ?>
                                <select name="STATUS" id="status">
                                    <option value="Menunggu" <?= (isset($data['STATUS']) && $data['STATUS'] === 'menunggu') ? 'selected' : '' ?>> Menunggu </option>
                                    <option value="Selesai" <?= (isset($data['STATUS']) && $data['STATUS'] === 'selesai') ? 'selected' : '' ?>> Selesai </option>
                                    <option value="Gagal" <?= (isset($data['STATUS']) && $data['STATUS'] === 'gagal') ? 'selected' : '' ?>> Gagal </option>
                                </select>
                            <?php else: ?>
                                <input type="text" name="<?= $col ?>" value="<?= htmlspecialchars($data[$col] ?? '') ?>">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <br> <br>

                    <div class="input-center">
                        <input type="submit" name="submit" value="<?= ucfirst($aksi ?: 'Simpan') ?>">
                        <br> <br>
                        <button type="button" onclick="window.location.href='<?= $back ?>'"> Batal </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>