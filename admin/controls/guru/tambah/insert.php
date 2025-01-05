<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../../../logout.php");
    exit();
}

$nip = $_POST['nip'];
$nama_guru = $_POST['nama_guru'];
$jurusan = $_POST['jurusan'];
$password = $_POST['password'];

$sql_check = "SELECT * FROM guru WHERE nip = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $nip);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "NIP sudah terdaftar!";
    exit;
}

$sql_insert = "INSERT INTO guru (nip, nama_guru, id_jurusan) VALUES (?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("ssi", $nip, $nama_guru, $jurusan);

if ($stmt_insert->execute()) {
    $sql_login = "INSERT INTO login_guru (user_guru, pw_guru) VALUES (?, ?)";
    $stmt_login = $conn->prepare($sql_login);
    $stmt_login->bind_param("ss", $nip, $password);
    $stmt_login->execute();

    header("Location: ../../../dashboard/dashboard-admin-guru.php");
    exit;
} else {
    echo "Error: " . $stmt_insert->error;
}

$conn->close();