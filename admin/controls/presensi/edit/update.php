<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../../../logout.php");
    exit();
}

$id = $_POST['id'];
$nisn = $_POST['nisn'];
$status = $_POST['status'];
$tanggal = $_POST['tanggal'];
$jam_masuk = $_POST['jam_masuk'];
$keterangan = $_POST['keterangan'];
$sql = "UPDATE presensi SET nisn='$nisn', status='$status', tanggal='$tanggal', jam_masuk='$jam_masuk', keterangan='$keterangan' WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    echo "Catatan berhasil diperbarui!";
    header("Location: ../../../dashboard/dashboard-admin-presensi.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();