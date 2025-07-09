<?php
include '../konekDatabase.php';

$db = new konekDatabase();
$koneksi = $db->getConnection();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$akun = $_SESSION['username'] ?? 'Login';

$game = $_POST['game'] ?? '';
$idToko = $_POST['idToko'] ?? '';
$produk = $_POST['product'] ?? '';
$harga = $_POST['price'] ?? '';
$pembeliId = $_POST['pembeliId'] ?? '';
$name = $_POST['name'] ?? '';
$paymentMethod = $_POST['paymentMethod'] ?? '';

$hargaAngka = preg_replace('/\D/', '', $harga);
$tanggal = date('Y-m-d');
$status = 'Menunggu';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $pembeliId && $name && $paymentMethod) {
    $stmt = $koneksi->prepare("CALL INSERT_DATA(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssisss",
        $pembeliId,
        $name,
        $akun,
        $idToko,
        $game,
        $produk,
        $hargaAngka,
        $paymentMethod,
        $tanggal,
        $status
    );
    $stmt->execute();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analog Store</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        @import url(https://images.pexels.com/photos/3165335/pexels-photo-3165335.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2);

        .main-content {
            padding: 20px 5% 40px;
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

                    <button type="submit" class="confirm-button" id="kirim"> Konfirmasi Pembayaran </button>
                    <button type="button" class="confirm-button" onclick="window.location.href='home.php'"> Kembali
                    </button>
                </form>
            </div>

            <div class="order-summary">
                <h3> Struk Pemesanan </h3>

                <br>

                <div class="summary-item">
                    <span>Game: &nbsp; </span>
                    <span id="summary-game"><?= htmlspecialchars($game) ?></span>
                </div>

                <div class="summary-item">
                    <span>Produk: &nbsp; </span>
                    <span id="summary-product"><?= htmlspecialchars($produk) ?></span>
                </div>

                <div class="summary-total">
                    <span>Total Pembayaran: &nbsp; </span>
                    <span id="summary-total"><?= htmlspecialchars($harga) ?></span>
                </div>

                <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                    <?php
                    $paymentMethods = [
                        'DANA' => 'DANA',
                        'GoPay' => 'GoPay',
                        'OVO' => 'OVO',
                        'Bank Transfer' => 'Transfer Bank',
                        'QRIS' => 'QRIS'
                    ];
                    $paymentDisplay = $paymentMethods[$paymentMethod] ?? 'Metode tidak dikenal';
                    ?>

                    <div class="customer-details"
                        style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 20px;">
                        <h3 style="margin-bottom: 15px;"> Detail Pembeli </h3>
                        <div class="detail-item">
                            <span> ID Player: </span>
                            <span><?= htmlspecialchars($pembeliId) ?></span>
                        </div>

                        <div class="detail-item">
                            <span> Nama Player: </span>
                            <span><?= htmlspecialchars($name) ?></span>
                        </div>

                        <div class="detail-item">
                            <span> Metode Pembayaran: </span>
                            <span><?= htmlspecialchars($paymentDisplay) ?></span>
                        </div>

                        <div class="payment-instructions"
                            style="margin-top: 20px; background: rgba(76, 175, 80, 0.1); padding: 15px; border-radius: 8px; border-left: 3px solid #4CAF50;">

                            <h4 style="color: #4CAF50; margin-bottom: 10px;"> Instruksi Pembayaran: </h4>

                            <?php
                            switch ($paymentMethod) {
                                case 'DANA':
                                case 'GoPay':
                                case 'OVO':
                                    echo '<p>Silakan transfer ke nomor: <strong>082169949018</strong></p>';
                                    break;
                                case 'Bank Transfer':
                                    echo '<p>Silakan transfer ke rekening:<br><strong>Bank BCA: 55423451 a.n. Bennet id</strong></p>';
                                    break;
                                case 'QRIS':
                                    echo '<p>Scan QR code yang akan dikirim via WhatsApp setelah konfirmasi</p>';
                                    break;
                                default:
                                    echo '<p>Silakan pilih metode pembayaran untuk melihat instruksi</p>';
                            }
                            ?>

                            <p style="margin-top: 10px; font-size: 0.9em;"> Setelah pembayaran, harap konfirmasi ke
                                WhatsApp:
                                <strong>
                                    <a href="https://wa.me/+6282169949018" style="color: white;"> Bennett id </a></strong>
                                dengan menyertakan bukti transfer.
                            </p>

                            <?php ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const produkData = localStorage.getItem("produkDipilih");

            const isDisabled = localStorage.getItem("submitDisabled") === "true";
            const submitButton = document.getElementById('kirim');
            if (isDisabled) {
                submitButton.disabled = true;
                submitButton.textContent = 'Sudah Dikonfirmasi';
                submitButton.style.opacity = '0.6';
            }

            if (produkData) {
                const produk = JSON.parse(produkData);

                function formatHarga(harga) {
                    return 'Rp ' + parseInt(harga).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }

                document.getElementById('game').value = produk.game;
                document.getElementById('product').value = produk.produk;
                document.getElementById('price').value = formatHarga(produk.harga);

                document.getElementById('summary-game').textContent = produk.game;
                document.getElementById('summary-product').textContent = produk.produk;
                document.getElementById('summary-total').textContent = formatHarga(produk.harga);

                let id_Toko = '';
                switch (produk.game) {
                    case 'Mobile Legends': id_Toko = '229811ML'; break;
                    case 'Free Fire': id_Toko = '199233FF'; break;
                    case 'PUBG Mobile': id_Toko = '009231PM'; break;
                    case 'Valorant': id_Toko = '298003V'; break;
                    case 'Genshin Impact': id_Toko = '100991GI'; break;
                    case 'Wuthering Waves': id_Toko = '200192WW'; break;
                    case 'Zenless Zone Zero': id_Toko = '112256ZZZ'; break;
                    case 'Roblox': id_Toko = '8901922R'; break;
                    case 'Honor of Kings': id_Toko = '889183HOK'; break;
                }

                document.getElementById('idToko').value = id_Toko;
            }

            document.getElementById('paymentForm').addEventListener('submit', function () {
                const submitButton = document.getElementById('kirim');
                submitButton.disabled = true;
                submitButton.textContent = 'Memproses...';
                submitButton.style.opacity = '0.6';

                localStorage.setItem("submitDisabled", "true");

                localStorage.removeItem("produkDipilih");
            });

            document.querySelector('button[onclick*="home.php"]').addEventListener('click', function () {
                localStorage.removeItem("submitDisabled");
            });
        });
    </script>

</body>

</html>