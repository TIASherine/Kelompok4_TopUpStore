<center>
<?php
include 'koneksiDB.php';

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT*FROM MAHASISWA WHERE id = $id");
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
        <h2> Update Mahasiswa </h2>

        <hr>

        <table>
            <tr>
                <td> Nama </td>
                <td> : </td>
                <td> <input type="text" name="nama" id="" value="<?php print $data['NAMA'] ?>"> </td>
            </tr>

            <tr>
                <td> NIM </td>
                <td> : </td>
                <td> <input type="text" name="nim" id="" value="<?php print $data['NIM'] ?>"> </td>
            </tr>

            <tr>
                <td> Kelas </td>
                <td> : </td>
                <td> <input type="text" name="kelas" id="" value="<?php print $data['KELAS'] ?>"> </td>
            </tr>

            <tr>
                <td> Username </td>
                <td> : </td>
                <td> <input type="text" name="username" id="" value="<?php print $data['USERNAME'] ?>"> </td>
            </tr>

            <tr>
                <td> Password </td>
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

    $koneksi->query("UPDATE MAHASISWA SET NAMA='$nama', NIM='$nim', KELAS='$kelas', USERNAME='$username', PASSWORD='$password' WHERE ID = $id");

    header("Location: tampilMhs.php");
} else if (isset($_POST['cancel'])) {
    header("Location: tampilMHS.php");
}
?>    

</body>
</center>