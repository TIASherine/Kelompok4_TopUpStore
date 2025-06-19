<?php
// checkout.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $game = htmlspecialchars($_POST['game']);
    $product = htmlspecialchars($_POST['product']);
    $price = htmlspecialchars($_POST['price']);
    $playerId = htmlspecialchars($_POST['playerId']);
    $playerName = htmlspecialchars($_POST['playerName']);
    $paymentMethod = htmlspecialchars($_POST['paymentMethod']);
    
    // Map payment method to display name
    $paymentMethods = [
        'dana' => 'DANA',
        'gopay' => 'GoPay',
        'ovo' => 'OVO',
        'bank_transfer' => 'Transfer Bank',
        'qris' => 'QRIS'
    ];
    $paymentDisplay = $paymentMethods[$paymentMethod] ?? 'Metode tidak dikenal';
    
    // Display the result
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Konfirmasi Pembayaran</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <a href="home.html" class="logo">Bennet id</a>
            <nav>
                <a href="home.html">Home</a>
                <a href="Produk.html">Products</a>
                <a href="shop.html" class="navigation">Shop</a>
                <a href="about_us.html">About Us</a>
                <a href="#">Contact Us</a>
            </nav>
        </header>
        
        <main class="main-content">
            <div class="checkout-container" style="max-width: 800px; margin: 50px auto;">
                <div class="checkout-form" style="width: 100%;">
                    <h2 class="checkout-title">Konfirmasi Pembayaran</h2>
                    <div class="confirmation-details">
                        <div class="detail-item">
                            <span class="detail-label">Game:</span>
                            <span class="detail-value">$game</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Produk:</span>
                            <span class="detail-value">$product</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Harga:</span>
                            <span class="detail-value">$price</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">ID Player:</span>
                            <span class="detail-value">$playerId</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Nama Player:</span>
                            <span class="detail-value">$playerName</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Metode Pembayaran:</span>
                            <span class="detail-value">$paymentDisplay</span>
                        </div>
                        <div class="detail-item" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.2);">
                            <span class="detail-label" style="font-weight: bold; font-size: 1.2rem;">Total Pembayaran:</span>
                            <span class="detail-value" style="font-weight: bold; font-size: 1.2rem; color: #4CAF50;">$price</span>
                        </div>
                    </div>
                    <div class="payment-instructions" style="margin-top: 30px; background: rgba(76, 175, 80, 0.1); padding: 20px; border-radius: 10px; border-left: 4px solid #4CAF50;">
                        <h3 style="margin-bottom: 15px; color: #4CAF50;">Instruksi Pembayaran</h3>
                        <p>Silakan lakukan pembayaran sesuai dengan metode yang Anda pilih:</p>
                        <ul style="margin-top: 10px; padding-left: 20px;">
                            <li>Untuk pembayaran via e-wallet, gunakan nomor 0812-3456-7890</li>
                            <li>Untuk transfer bank, gunakan rekening BCA 1234567890 a.n. Bennet Store</li>
                            <li>Untuk QRIS, scan kode yang akan dikirim via WhatsApp</li>
                        </ul>
                        <p style="margin-top: 15px; font-weight: bold;">Setelah pembayaran, konfirmasi ke WhatsApp 0812-3456-7890 dengan menyertakan bukti transfer.</p>
                    </div>
                    <a href="home.html" class="confirm-button" style="display: block; text-align: center; margin-top: 30px; text-decoration: none;">Kembali ke Beranda</a>
                </div>
            </div>
        </main>
    </body>
    </html>
HTML;
} else {
    // If someone tries to access this page directly without submitting the form
    header("Location: shop.html");
    exit();
}
?>