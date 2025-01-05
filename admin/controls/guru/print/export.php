<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';
require $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/vendor/autoload.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../../../logout.php");
    exit();
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$nama_guru_filter = isset($_GET['nama_guru']) ? $_GET['nama_guru'] : '';
$nip_filter = isset($_GET['nip']) ? $_GET['nip'] : '';
$jurusan_filters = isset($_GET['jurusan']) ? $_GET['jurusan'] : [];

$sql = "SELECT * FROM guru g 
        LEFT JOIN jurusan j ON g.id_jurusan = j.id_jurusan 
        LEFT JOIN login_guru l ON l.user_guru = g.nip";

$conditions = [];
$params = [];

if (!empty($nama_guru_filter)) {
    $conditions[] = "g.nama_guru LIKE ?";
    $params[] = '%' . $nama_guru_filter . '%';
}

if (!empty($nip_filter)) {
    $conditions[] = "g.nip LIKE ?";
    $params[] = '%' . $nip_filter . '%';
}

if (!empty($jurusan_filters)) {
    $placeholders = implode(',', array_fill(0, count($jurusan_filters), '?'));
    $conditions[] = "g.id_jurusan IN ($placeholders)";
    $params = array_merge($params, $jurusan_filters);
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " ORDER BY g.nama_guru ASC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Guru');

$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'NIP');
$sheet->setCellValue('C1', 'Nama');
$sheet->setCellValue('D1', 'Jurusan');
$sheet->setCellValue('E1', 'Password');

if ($result->num_rows > 0) {
    $no = 1;
    $rowNum = 2; 
    while($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNum, $no++);
        $sheet->setCellValue('B' . $rowNum, $row['nip']);
        $sheet->setCellValue('C' . $rowNum, $row['nama_guru']);
        $sheet->setCellValue('D' . $rowNum, $row['jurusan']);
        $sheet->setCellValue('E' . $rowNum, $row['pw_guru']);
        $rowNum++;
    }
}

// Buat file XLSX
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="data_guru.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;