<center>
    <?php
    include 'koneksiDB.php';
    ?>

    <body style="background-color: cornsilk;">

        <fieldset style="background-color: lavender; margin: 100px 400px;">
            <form action="" method="post">
                <h2> Tambah Mahasiswa </h2>

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
            $nama = $_POST['nama'];
            $nim = $_POST['nim'];
            $kelas = $_POST['kelas'];
            $username = $_POST['username'];
            $password = MD5($_POST['password']);

            $koneksi->query("INSERT INTO MAHASISWA (NAMA, NIM, KELAS, USERNAME, PASSWORD) 
                    VALUES ('$nama', '$nim', '$kelas', '$username', '$password')");

            header("Location: tampilMhs.php");
        } else if (isset($_POST['cancel'])) {
            header("Location: tampilMHS.php");
        }
        ?>

    </body>
</center>