<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';
require $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/vendor/autoload.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../../../logout.php");
    exit();
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$nama_siswa_filter = isset($_GET['nama_siswa']) ? $_GET['nama_siswa'] : '';
$nisn_filter = isset($_GET['nisn']) ? $_GET['nisn'] : '';
$kelas_filters = isset($_GET['kelas']) ? $_GET['kelas'] : [];
$jurusan_filters = isset($_GET['jurusan']) ? $_GET['jurusan'] : [];

$sql = "SELECT s.*, j.*, l.* FROM siswa s 
        JOIN jurusan j ON s.id_jurusan = j.id_jurusan 
        JOIN login_siswa l ON l.user_siswa = s.nisn ";

$conditions = [];
$params = [];

if (!empty($nama_siswa_filter)) {
    $conditions[] = "s.nama_siswa LIKE ?";
    $params[] = '%' . $nama_siswa_filter . '%';
}

if (!empty($nisn_filter)) {
    $conditions[] = "s.nisn LIKE ?";
    $params[] = '%' . $nisn_filter . '%';
}

if (!empty($kelas_filters)) {
    $placeholders = implode(',', array_fill(0, count($kelas_filters), '?'));
    $conditions[] = "s.kelas IN ($placeholders)";
    $params = array_merge($params, $kelas_filters);
}

if (!empty($jurusan_filters)) {
    $placeholders = implode(',', array_fill(0, count($jurusan_filters), '?'));
    $conditions[] = "j.id_jurusan IN ($placeholders)";
    $params = array_merge($params, $jurusan_filters);
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " ORDER BY s.nama_siswa ASC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Siswa');

$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'NISN');
$sheet->setCellValue('C1', 'Nama');
$sheet->setCellValue('D1', 'Kelas');
$sheet->setCellValue('E1', 'Jurusan');
$sheet->setCellValue('F1', 'Password');

if ($result->num_rows > 0) {
    $no = 1;
    $rowNum = 2; 
    while($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNum, $no++);
        $sheet->setCellValue('B' . $rowNum, $row['nisn']);
        $sheet->setCellValue('C' . $rowNum, $row['nama_siswa']);
        $sheet->setCellValue('D' . $rowNum, $row['kelas']);
        $sheet->setCellValue('E' . $rowNum, $row['jurusan']);
        $sheet->setCellValue('F' . $rowNum, $row['pw_siswa']);
        $rowNum++;
    }
}

// Buat file XLSX
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="data_siswa.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;