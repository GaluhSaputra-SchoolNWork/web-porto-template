<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $nisn = $_SESSION['nisn'];

    if (empty($nisn)) {
        echo "NISN tidak terdeteksi. Pastikan Anda sudah login.";
        exit();
    }

    $tanggal = date('Y-m-d');
    $jam_masuk = date('H:i');

    $query = "INSERT INTO presensi (nisn, tanggal, jam_masuk, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $nisn, $tanggal, $jam_masuk, $status);

    if ($stmt->execute()) {
        echo "Data absen berhasil disimpan.";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

exit();