<?php
$servername = "localhost";
$database = "presensi-galuh";
$username = "root";
$password = "";

$conn = mysqli_connect("localhost", "root", "", "presensi-galuh");

if (!$conn) {
    die("Gagal menyambung ke database: " . mysqli_connect_error());
}
echo "";

return $conn;
// mysqli_close($conn);