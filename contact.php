<?php
$page = 'contact';
include 'header.php';
?>

<div class="center">
    <div class="contact" style="text-align: center; max-width: 500px;">
        <h1> Kontak Admin </h1>

        <br>
        
        <p>+62 821 6994 9018 (Benito Noel)</p>
        <p>+62 811 7606 065 (Sherine Niovanni)</p>
    </div>

    <div class="contact" style="text-align: center; max-width: 600px;">
        <h1> Hubungi Kami </h1>
        <div style="margin-top: 10px;">
            <input type="text" name="sender" id="sender" placeholder="Nama"> <br>
            <input type="email" name="email" id="email" placeholder="Email"> <br>
            <textarea name="pesan" id="pesan"> </textarea> <br>

            <button class="confirm-button" style="width: 100px; height: 50px;"> Kirim </button>
        </div>
    </div>
</div>


</body>

</html>