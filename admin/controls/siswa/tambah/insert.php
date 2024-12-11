<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

$nisn = $_POST['nisn'];
$nama_siswa = $_POST['nama_siswa'];
$kelas = $_POST['kelas'];
$jurusan = $_POST['jurusan'];
$password = $_POST['password'];

$sql_check = "SELECT * FROM siswa WHERE nisn = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $nisn);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "NISN sudah terdaftar!";
    exit;
}

$sql_insert = "INSERT INTO siswa (nisn, nama_siswa, kelas, id_jurusan) VALUES (?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("sssi", $nisn, $nama_siswa, $kelas, $jurusan);

if ($stmt_insert->execute()) {
    $sql_login = "INSERT INTO login_siswa (user_siswa, pw_siswa) VALUES (?, ?)";
    $stmt_login = $conn->prepare($sql_login);
    $stmt_login->bind_param("ss", $nisn, $password);
    $stmt_login->execute();

    header("Location: ../../../dashboard/dashboard-admin-siswa.php");
    exit;
} else {
    echo "Error: " . $stmt_insert->error;
}

$conn->close();