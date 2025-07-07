<?php
include 'header.php';
?>

<main class="main-content">
    <div class="checkout-container">
        <div class="checkout-form">
            <h2 class="checkout-title"> Form Pembelian </h2>
            <form id="paymentForm" method="post" action="crud.php?table=TRANSAKSI&redirect=shop.php">
                <div class="form-group">
                    <label for="product"> Game </label>
                    <input type="text" id="game" name="game" placeholder="Mobile Legends" readonly>
                </div>

                <input type="hidden" id="idToko" name="idToko">

                <div class="form-group">
                    <label for="product"> Produk </label>
                    <input type="text" id="product" name="product" placeholder="Diamond Mobile Legends" readonly>
                </div>

                <div class="form-group">
                    <label for="price"> Harga </label>
                    <input type="text" id="price" name="price" placeholder="Rp 10.000" readonly>
                </div>

                <div class="form-group">
                    <label for="playerId"> ID Player </label>
                    <input type="text" id="playerId" name="playerId" placeholder="Masukkan ID Player" required
                        value="<?php echo isset($_POST['playerId']) ? htmlspecialchars($_POST['playerId']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="playerName"> Nama Player </label>
                    <input type="text" id="playerName" name="playerName" placeholder="Masukkan Nama Player" required
                        value="<?php echo isset($_POST['playerName']) ? htmlspecialchars($_POST['playerName']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="paymentMethod"> Metode Pembayaran </label>
                    <select id="paymentMethod" name="paymentMethod" required>
                        <option value=""> Pilih Metode Pembayaran </option>
                        <option value="dana" <?php echo (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] == 'dana') ? 'selected' : ''; ?>>DANA</option>
                        <option value="gopay" <?php echo (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] == 'gopay') ? 'selected' : ''; ?>>GoPay</option>
                        <option value="ovo" <?php echo (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] == 'ovo') ? 'selected' : ''; ?>>OVO</option>
                        <option value="bank_transfer" <?php echo (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] == 'bank_transfer') ? 'selected' : ''; ?>>Transfer Bank</option>
                        <option value="qris" <?php echo (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] == 'qris') ? 'selected' : ''; ?>>QRIS</option>
                    </select>
                </div>

                <br>

                <button type="submit" class="confirm-button"> Konfirmasi Pembayaran
                </button>
            </form>
        </div>

        <div class="order-summary">
            <h3> Struk Pemesanan </h3>

            <br>

            <div class="summary-item">
                <span>Game: &nbsp; </span>
                <span id="summary-game"> <?php echo $_POST['game'] ?? '' ?> </span>
            </div>
            <div class="summary-item">
                <span>Produk: &nbsp; </span>
                <span id="summary-product"> <?php echo $_POST['product'] ?? '' ?> </span>
            </div>
            <div class="summary-total">
                <span>Total Pembayaran: &nbsp; </span>
                <span id="summary-total"> <?php echo $_POST['price'] ?? '' ?> </span>
            </div>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $paymentMethods = [
                    'dana' => 'DANA',
                    'gopay' => 'GoPay',
                    'ovo' => 'OVO',
                    'bank_transfer' => 'Transfer Bank',
                    'qris' => 'QRIS'
                ];
                $paymentDisplay = isset($paymentMethods[$paymentMethod]) ? $paymentMethods[$paymentMethod] : 'Metode tidak dikenal';

                echo '<div class="customer-details" style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 20px;">';
                echo '<h3 style="margin-bottom: 15px;">Detail Pembeli</h3>';
                echo '<div class="detail-item"><span>ID Player:</span><span>' . $playerId . '</span></div>';
                echo '<div class="detail-item"><span>Nama Player:</span><span>' . $playerName . '</span></div>';
                echo '<div class="detail-item"><span>Metode Pembayaran:</span><span>' . $paymentDisplay . '</span></div>';


                echo '<div class="payment-instructions" style="margin-top: 20px; background: rgba(76, 175, 80, 0.1); padding: 15px; border-radius: 8px; border-left: 3px solid #4CAF50;">';
                echo '<h4 style="color: #4CAF50; margin-bottom: 10px;">Instruksi Pembayaran:</h4>';

                switch ($paymentMethod) {
                    case 'dana':
                    case 'gopay':
                    case 'ovo':
                        echo '<p>Silakan transfer ke nomor: <strong>082169949018</strong></p>';
                        break;
                    case 'bank_transfer':
                        echo '<p>Silakan transfer ke rekening:<br><strong>Bank BCA: 55423451 a.n. Bennet id</strong></p>';
                        break;
                    case 'qris':
                        echo '<p>Scan QR code yang akan dikirim via WhatsApp setelah konfirmasi</p>';
                        break;
                    default:
                        echo '<p>Silakan pilih metode pembayaran untuk melihat instruksi</p>';
                }

                echo '<p style="margin-top: 10px; font-size: 0.9em;">Setelah pembayaran, harap konfirmasi ke WhatsApp: <strong> <a href="https://wa.me/+6282169949018" style="color: white;"> Bennett id </a> </strong> dengan menyertakan bukti transfer.</p>';
                echo '</div>';
                echo '</div>';

                echo '<script>
                setTimeout(function() {window.location.href = "home.php";}, 2000);
                </script>';
            }
            ?>
        </div>
    </div>
</main>

<?php
$game = htmlspecialchars('game');
$idToko = '';
$produk = htmlspecialchars('product');
$price = htmlspecialchars('price');
$playerId = htmlspecialchars('playerId');
$playerName = htmlspecialchars('playerName');
$paymentMethod = htmlspecialchars('paymentMethod');
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const produkData = localStorage.getItem("produkDipilih");

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
            document.getElementById('summary-price').textContent = formatHarga(produk.harga);
            document.getElementById('summary-total').textContent = formatHarga(produk.harga);

            localStorage.removeItem("produkDipilih");
        }

        const idToko = "null";
        switch (produk.game) {
            case 'Mobile Legends':
                idToko = '229811ML';
                break;
            case 'Free Fire':
                idToko = '199233FF';
                break;
            case 'PUBG Mobile':
                idToko = '009231PM';
                break;
            case 'Valorant':
                idToko = '298003V';
                break;
            case 'Genshin Impact':
                idToko = '100991GI';
                break;
            case 'Wuthering Waves':
                idToko = '200192WW';
                break;
            case 'Zenless Zone Zero':
                idToko = '112256ZZZ';
                break;
            case 'Roblox':
                idToko = '8901922R';
                break;
            case 'Honor of Kings':
                idToko = '889183HOK';
                break;
        }
        document.getElementById('idToko').value = idToko;

    });
</script>

</body>

</html>