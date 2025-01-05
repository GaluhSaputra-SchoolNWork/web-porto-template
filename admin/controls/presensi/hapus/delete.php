<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../../../logout.php");
    exit();
}

$id = $_GET['id'];
$sql = "DELETE FROM presensi WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    echo "Data berhasil dihapus!";
    header("Location: ../../../dashboard/dashboard-admin-presensi.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();