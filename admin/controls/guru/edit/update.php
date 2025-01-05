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

$sql = "UPDATE guru SET nama_guru=?, id_jurusan=? WHERE nip=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $nama_guru, $jurusan, $nip);

if ($stmt->execute()) {
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql_password = "UPDATE login_guru SET pw_guru=? WHERE user_guru=?";
        $stmt_password = $conn->prepare($sql_password);
        $stmt_password->bind_param("ss", $hashed_password, $nip);
        $stmt_password->execute();
    }
    echo "Data guru berhasil diperbarui!";
    header("Location: ../../../dashboard/dashboard-admin-guru.php");
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();