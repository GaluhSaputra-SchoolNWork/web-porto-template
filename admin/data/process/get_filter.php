<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

$type = isset($_GET['type']) ? $_GET['type'] : '';

switch ($type) {
    case 'presensi':
        $sql = "SELECT p.*, s.nama_siswa, s.kelas, j.jurusan FROM presensi p
                JOIN siswa s ON p.nisn = s.nisn
                JOIN jurusan j ON j.id_jurusan = s.id_jurusan";
        break;
    case 'siswa':
        $sql = "SELECT s.*, j.* FROM siswa s JOIN jurusan j ON s.id_jurusan = j.id_jurusan ORDER BY nisn ASC";
        break;
    case 'guru':
        $sql = "SELECT * FROM guru";
        break;
    default:
        echo "<span>Invalid data type.</span>";
        exit;
}

$result = $conn->query($sql);

if ($type === 'presensi') {
    $jurusan_filters = isset($_GET['jurusan']) ? $_GET['jurusan'] : [];
    $status_filters = isset($_GET['status']) ? $_GET['status'] : [];
    $kelas_filters = isset($_GET['kelas']) ? $_GET['kelas'] : [];

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
        $conditions[] = "p.status IN ($placeholders)";
        $params = array_merge($params, $kelas_filters);
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

    if (!$result) {
        die("Query Error: " . $conn->error);
    }

    $jurusan_sql = "SELECT * FROM jurusan";
    $jurusan_result = $conn->query($jurusan_sql);
    $jurusan_options = [];
    while ($jurusan_row = $jurusan_result->fetch_assoc()) {
        $jurusan_options[] = $jurusan_row;
    }

    $status_options = ['Hadir', 'Sakit', 'Izin', 'Alfa'];

    $kelas_options = ['X', 'XI', 'XII'];

    echo '<form method="GET" action="" class="mb-4">';
        echo '<div class="me-4">';
        echo '<h5>Filter berdasarkan Jurusan:</h5>';
        foreach ($jurusan_options as $jurusan) {
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" name="jurusan[]" value="' . $jurusan['id_jurusan'] . '" id="jurusan-' . $jurusan['id_jurusan'] . '"';
            if (in_array($jurusan['id_jurusan'], $jurusan_filters)) {
                echo 'checked';
            }
            echo '>';
            echo '<label class="form-check-label" for="jurusan-' . $jurusan['id_jurusan'] . '">';
            echo '' . $jurusan['jurusan'] . '';
            echo '</label>';
            echo '</div>';
        }
        echo '</div><br>';

        echo '<div>';
        echo '<h5>Filter berdasarkan Status:</h5>';
        foreach ($status_options as $status) {
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" name="status[]" value="' . $status . '" id="status-' . $status . '"';
            if (in_array($status, $status_filters)) {
                echo ' checked';
            }
            echo '>';
            echo '<label class="form-check-label" for="status-' . $status . '">';
            echo '' . $status . '';
            echo '</label>';
            echo '</div>';
        }
        echo '</div><br>';

        echo '<button type="submit" class="btn btn-primary mt-2">Filter</button>';
    echo '</form>';
} elseif ($type === 'siswa') {
    echo '<span>';
	echo '<form action="" method="post" class="mt-3">';
	echo '<button type="submit" class="btn btn-primary">Test</button>';
	echo '</form>';
	echo '</span>';
    echo '<span>';
	echo '<p>';
	echo 'Siswa';
	echo '</p>';
	echo '</span>';
} elseif ($type === 'guru') {
    echo '<span>';
	echo '<form action="" method="post" class="mt-3">';
	echo '<button type="submit" class="btn btn-primary">Test</button>';
	echo '</form>';
	echo '</span>';
    echo '<span>';
	echo '<p>';
	echo 'Presensi';
	echo '</p>';
	echo '</span>';
} else {
    echo "<div class='col-12'>Belum ada filter</div>";
}
?>