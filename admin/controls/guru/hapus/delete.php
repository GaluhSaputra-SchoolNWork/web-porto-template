<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

$nip = $_GET['id'];

$sql_login = "DELETE FROM login_guru WHERE user_guru = ?";
$stmt_login = $conn->prepare($sql_login);
$stmt_login->bind_param("s", $nip);
$stmt_login->execute();

$sql = "DELETE FROM guru WHERE nip = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nip);

if ($stmt->execute()) {
    echo "Data berhasil dihapus!";
    header("Location: ../../../dashboard/dashboard-admin-guru.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();