<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../../../logout.php");
    exit();
}

$nisn = $_POST['nisn'];
$nama_siswa = $_POST['nama_siswa'];
$kelas = $_POST['kelas'];
$jurusan = $_POST['jurusan'];
$password = $_POST['password'];

$sql = "UPDATE siswa SET nama_siswa=?, kelas=?, id_jurusan=? WHERE nisn=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nama_siswa, $kelas, $jurusan, $nisn);

if ($stmt->execute()) {
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql_password = "UPDATE login_siswa SET password=? WHERE user_siswa=?";
        $stmt_password = $conn->prepare($sql_password);
        $stmt_password->bind_param("ss", $hashed_password, $nisn);
        $stmt_password->execute();
    }
    echo "Data siswa berhasil diperbarui!";
    header("Location: ../../../dashboard/dashboard-admin-siswa.php");
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();