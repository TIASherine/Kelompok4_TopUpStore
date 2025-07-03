<?php
include 'konekDatabase.php';

$aksi = $_GET['aksi'];
$id = $_GET['id'];

if ($aksi == 'hapus') {
    $koneksi->query("DELETE FROM topupstore WHERE id = $id");

    header("Location: Admin.php");
} else if ($aksi == 'update') {

    $id = $_GET['ID_TRANSAKSI'];

    $query = mysqli_query($koneksi, "SELECT*FROM TRANSAKSI WHERE ID_TRANSAKSI = $id");
    $data = mysqli_fetch_array($query);
    ?>

        <style>
            table,
            fieldset {
                font-size: 20px;
            }
        </style>

        <body style="background-color: blanchedalmond;">

            <fieldset style="background-color: khaki; margin: 100px 400px;">
                <form action="" method="post">
                    <h2> Update History </h2>

                    <hr>

                    <table>
                        <tr>
                            <td> ID TRANSAKSI </td>
                            <td> : </td>
                            <td> <input type="text" name="nama" id="nama" value="<?php print $data['nama'] ?>"> </td>
                        </tr>

                        <tr>
                            <td> ID TOKO </td>
                            <td> : </td>
                            <td> <input type="text" name="idToko" id="idToko" value="<?php print $data['idToko'] ?>"> </td>
                        </tr>

                        <tr>
                            <td> ID PLAYER </td>
                            <td> : </td>
                            <td> <input type="text" name="idPlayer" id="idPlayer" value="<?php print $data['idPlayer'] ?>"> </td>
                        </tr>

                        <tr>
                            <td> PRODUK TRANSAKSI </td>
                            <td> : </td>
                            <td> <input type="text" name="produk" id="produk" value="<?php print $data['produk'] ?>"> </td>
                        </tr>

                        <tr>
                            <td> HARGA </td>
                            <td> : </td>
                            <td> <input type="text" name="harga" id="harga" value="<?php print $data['harga'] ?>"> </td>
                        </tr>

                        <tr>
                            <td> WAKTU TRANSAKSI </td>
                            <td> : </td>
                            <td> <input type="datetime-local" name="waktuTr" id="waktuTr" value="<?php print $data['waktuTr'] ?>"> </td>
                        </tr>

                        <tr>
                            <td colspan="3" align="center"> <input type="submit" name="submit" value="Update"
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
                $nama = $_POST['nama'];
                $nim = $_POST['nim'];
                $kelas = $_POST['kelas'];
                $username = $_POST['username'];
                $password = MD5($_POST['password']);

                $koneksi->query("UPDATE topupstore SET NAMA='$nama', NIM='$nim', KELAS='$kelas', USERNAME='$username', PASSWORD='$password' WHERE ID = $id");

                header("Location: Admin.php");
            } else if (isset($_POST['cancel'])) {
                header("Location: Admin.php");
            }

} else if ($aksi == 'tambah') {

    ?>

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

}
?>