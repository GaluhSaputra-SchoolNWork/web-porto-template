<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

$input = $_POST['nisn'];
$nisn = null;

if (is_numeric($input) && strlen($input) == 10) {
    $nisn = $input;
} else {
    $nama = $input;
    $sql = "SELECT nisn FROM siswa WHERE nama_siswa = '$nama'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nisn = $row['nisn'];
    } else {
        echo "Nama tidak ditemukan!";
        exit;
    }
}

if ($nisn === null) {
    echo "NISN tidak valid!";
    exit;
}

$status = $_POST['status'];
$tanggal = $_POST['tanggal'];
$jam_masuk = $_POST['jam_masuk'];
$keterangan = $_POST['keterangan'];

$sql = "INSERT INTO presensi (nisn, status, tanggal, jam_masuk, keterangan) VALUES ('$nisn', '$status', '$tanggal', '$jam_masuk', '$keterangan')";
if ($conn->query($sql) === TRUE) {
    header("Location: ../../../dashboard/dashboard-admin-presensi.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();