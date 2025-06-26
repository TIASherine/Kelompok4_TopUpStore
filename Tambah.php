<center>
    <?php
    include 'KonekDatabase.php';
    ?>

    <body style="background-color: cornsilk;">

        <fieldset style="background-color: lavender; margin: 100px 400px;">
            <form action="" method="post">
                <h2> Tambah </h2>

                <hr>

                <table>
                    <tr>
                        <td> Nama </td>
                        <td> : </td>
                        <td> <input type="text" name="nama" id=""> </td>
                    </tr>

                    <tr>
                        <td> NIM </td>
                        <td> : </td>
                        <td> <input type="text" name="nim" id=""> </td>
                    </tr>

                    <tr>
                        <td> Kelas </td>
                        <td> : </td>
                        <td> <input type="text" name="kelas" id=""> </td>
                    </tr>

                    <tr>
                        <td> Username </td>
                        <td> : </td>
                        <td> <input type="text" name="username" id=""> </td>
                    </tr>

                    <tr>
                        <td> Password </td>
                        <td> : </td>
                        <td> <input type="password" name="password" id=""> </td>
                    </tr>

                    <tr>
                        <td colspan="3" align="center"> <input type="submit" name="submit" value="Tambah"
                                style="margin-top: 10px;"> </td>

                    </tr>

                    <tr>
                        <td colspan="3" align="center"> <input type="submit" name="cancel" value="Batal"
                                style="margin-top: 10px;"> </td>
                    </tr>
                </table>

            </form>
        </fieldset>

        <?php
        if (isset($_POST['submit'])) {
            $idTransaksi = $_POST['ID_TRANSAKSI'];
            $idToko = $_POST['ID_TOKO_TR'];
            $idPlayer = $_POST['ID_PLAYER_TR'];
            $ProdukTr = $_POST['PRODUK_TRANSAKSI'];
            $harga = $_POST['HARGA'];
            $waktu_tr = $_POST['WAKTU_TR'];

            $koneksi->query("INSERT INTO TRANSAKSI (ID_TRANSAKSI, ID_TOKO_TR, ID_PLAYER_TR, PRODUK_TRANSAKSI, HARGA, WAKTU_TR) 
                    VALUES ('$idTransaksi', '$idToko', '$idPlayer', '$ProdukTr', '$harga', '$waktu_tr'");

            header("Location: Admin.php");
        } else if (isset($_POST['cancel'])) {
            header("Location: Admin.php");
        }
        ?>

    </body>
</center>