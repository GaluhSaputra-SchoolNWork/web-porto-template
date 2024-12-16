<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';
require $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$jurusan_filters = isset($_GET['jurusan']) ? $_GET['jurusan'] : [];
$status_filters = isset($_GET['status']) ? $_GET['status'] : [];
$kelas_filters = isset($_GET['kelas']) ? $_GET['kelas'] : [];
$nama_siswa_filter = isset($_GET['nama_siswa']) ? $_GET['nama_siswa'] : '';
$nisn_filter = isset($_GET['nisn']) ? $_GET['nisn'] : '';
$keterangan_filter = isset($_GET['keterangan']) ? $_GET['keterangan'] : '';

$sql = "SELECT p.*, s.*, j.* FROM presensi p
        JOIN siswa s ON p.nisn = s.nisn
        JOIN jurusan j ON j.id_jurusan = s.id_jurusan";

$conditions = [];
$params = [];

if (!empty($jurusan_filters)) {
    $placeholders = implode(',', array_fill(0, count($jurusan_filters), '?'));
    $conditions[] = "j.id_jurusan IN ($placeholders)";
    $params = array_merge($params, $jurusan_filters);
}

if (!empty($status_filters)) {
    $placeholders = implode(',', array_fill(0, count($status_filters), '?'));
    $conditions[] = "p.status IN ($placeholders)";
    $params = array_merge($params, $status_filters);
}

if (!empty($kelas_filters)) {
    $placeholders = implode(',', array_fill(0, count($kelas_filters), '?'));
    $conditions[] = "s.kelas IN ($placeholders)";
    $params = array_merge($params, $kelas_filters);
}

if (!empty($nama_siswa_filter)) {
    $conditions[] = "s.nama_siswa LIKE ?";
    $params[] = '%' . $nama_siswa_filter . '%';
}

if (!empty($nisn_filter)) {
    $conditions[] = "s.nisn LIKE ?";
    $params[] = '%' . $nisn_filter . '%';
}

if (!empty($keterangan_filter)) {
    $conditions[] = "p.keterangan LIKE ?";
    $params[] = '%' . $keterangan_filter . '%';
}

if (!empty($_GET['tanggal_dari'])) {
    $conditions[] = "p.tanggal >= ?";
    $params[] = $_GET['tanggal_dari'];
}

if (!empty($_GET['tanggal_sampai'])) {
    $conditions[] = "p.tanggal <= ?";
    $params[] = $_GET['tanggal_sampai'];
}

if (!empty($_GET['jam_dari'])) {
    $conditions[] = "p.jam_masuk >= ?";
    $params[] = $_GET['jam_dari'];
}

if (!empty($_GET['jam_sampai'])) {
    $conditions[] = "p.jam_masuk <= ?";
    $params[] = $_GET['jam_sampai'];
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " ORDER BY p.id ASC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Presensi');

$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'NISN');
$sheet->setCellValue('C1', 'Nama');
$sheet->setCellValue('D1', 'Kelas');
$sheet->setCellValue('E1', 'Jurusan');
$sheet->setCellValue('F1', 'Tanggal');
$sheet->setCellValue('G1', 'Status');
$sheet->setCellValue('H1', 'Keterangan');
$sheet->setCellValue('I1', 'Jam Masuk');


if ($result->num_rows > 0) {
    $no = 1;
    $rowNum = 2; 
    while($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNum, $no++);
        $sheet->setCellValue('B' . $rowNum, $row['nisn']);
        $sheet->setCellValue('C' . $rowNum, $row['nama_siswa']);
        $sheet->setCellValue('D' . $rowNum, $row['kelas']);
        $sheet->setCellValue('E' . $rowNum, $row['jurusan']);
        $sheet->setCellValue('F' . $rowNum, $row['tanggal']);
        $sheet->setCellValue('G' . $rowNum, $row['status']);
        $sheet->setCellValue('H' . $rowNum, $row['keterangan']);
        $sheet->setCellValue('I' . $rowNum, $row['jam_masuk']);
        $rowNum++;
    }
}

// Buat file XLSX
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="data_presensi.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;