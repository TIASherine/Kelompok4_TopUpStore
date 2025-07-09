<?php
class konekDatabase
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "topupstore";
    private $koneksi;
    function __construct()
    {
        $this->koneksi = mysqli_connect(
            $this->servername,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->koneksi->connect_error) {
            die("Gagal");
        }
    }

    public function execute($sql)
    {
        $result = mysqli_query($this->koneksi, $sql);
        $data = [];

        while ($row = mysqli_fetch_array($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function delete($table, $where)
    {
        $status = false;
        $query = "DELETE FROM $table 
                  WHERE $where";

        $result = mysqli_query($this->koneksi, $query);

        if ($result) {
            $affectedRows = mysqli_affected_rows($this->koneksi);

            if ($affectedRows > 0) {
                $status = true;
            }
        } else {
            $status = false;
        }
        return $status;
    }

    public function insert($table, $col, $values)
    {
        $status = false;
        $f = "";

        foreach ($col as $val) {
            $f .= $val . ',';
        }
        $f = rtrim($f, ",");

        $v = "";
        foreach ($values as $val) {
            $escapedVal = mysqli_real_escape_string($this->koneksi, $val);
            $v .= "'" . $escapedVal . "', ";
        }
        $v = rtrim($v, ", ");

        $query = "INSERT INTO $table ($f) VALUES ($v)";
        $result = mysqli_query($this->koneksi, $query);

        if ($result && mysqli_affected_rows($this->koneksi) > 0) {
            $status = true;
        }
        return $status;
    }

    public function exists($table, $column, $value)
    {
        $stmt = mysqli_prepare($this->koneksi, "SELECT COUNT(*) FROM $table WHERE $column = ?");

        mysqli_stmt_bind_param($stmt, "s", $value);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $count > 0;
    }

    public function getConnection()
    {
        return $this->koneksi;
    }
}
