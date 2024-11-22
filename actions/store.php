<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';
$nisn = $_POST['nisn'];
$status = $_POST['status'];
$tanggal = $_POST['tanggal'];
$jam_masuk = $_POST['jam_masuk'];
$keterangan = $_POST['keterangan'];
$sql = "INSERT INTO presensi (nisn, status, tanggal, jam_masuk, keterangan) VALUES ('$nisn', '$status', '$tanggal', '$jam_masuk', '$keterangan')";
if ($conn->query($sql) === TRUE) {
    echo "Data berhasil ditambahkan!";
    header("Location: ../data_presensi.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();