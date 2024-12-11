<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

$nisn = $_GET['id'];

$sql_login = "DELETE FROM login_siswa WHERE user_siswa = ?";
$stmt_login = $conn->prepare($sql_login);
$stmt_login->bind_param("s", $nisn);

if ($stmt_login->execute()) {
    $sql = "DELETE FROM siswa WHERE nisn = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nisn);

    if ($stmt->execute()) {
        header("Location: ../../../dashboard/dashboard-admin-siswa.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Error: " . $stmt_login->error;
}

$conn->close();