<center>
<?php
include 'KonekDatabase.php';

$id = $_GET['ID_TRANSAKSI'];

$query = mysqli_query($koneksi, "SELECT*FROM TRANSAKSI WHERE ID_TRANSAKSI = $id");
$data = mysqli_fetch_array($query);
?>

<style>
    table, fieldset {
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
                <td> <input type="text" name="nama" id="" value="<?php print $data['NAMA'] ?>"> </td>
            </tr>

            <tr>
                <td> ID TOKO </td>
                <td> : </td>
                <td> <input type="text" name="nim" id="" value="<?php print $data['NIM'] ?>"> </td>
            </tr>

            <tr>
                <td> ID PLAYER </td>
                <td> : </td>
                <td> <input type="text" name="kelas" id="" value="<?php print $data['KELAS'] ?>"> </td>
            </tr>

            <tr>
                <td> PRODUK TRANSAKSI </td>
                <td> : </td>
                <td> <input type="text" name="username" id="" value="<?php print $data['USERNAME'] ?>"> </td>
            </tr>

            <tr>
                <td> HARGA </td>
                <td> : </td>
                <td> <input type="password" name="password" id="" value="<?php print $data['PASSWORD'] ?>"> </td>
            </tr>

            <tr>
                <td> WAKTU TRANSAKSI </td>
                <td> : </td>
                <td> <input type="password" name="password" id="" value="<?php print $data['PASSWORD'] ?>"> </td>
            </tr>

            <tr>
                <td colspan="3" align="center"> <input type="submit" name="submit" value="Update" style="margin-top: 10px;"> </td>
            </tr>

            <tr>
                <td colspan="3" align="center"> <input type="submit" name="cancel" value="Batal" style="margin-top: 10px;"> </td>
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
?>    

</body>
</center>