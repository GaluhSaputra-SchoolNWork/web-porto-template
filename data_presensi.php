<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

$jurusan_filters = isset($_GET['jurusan']) ? $_GET['jurusan'] : [];
$status_filters = isset($_GET['status']) ? $_GET['status'] : [];
$kelas_filters = isset($_GET['kelas']) ? $_GET['kelas'] : [];

$sql = "SELECT p.*, s.*, j.* FROM presensi p
        JOIN siswa s ON p.nisn = s.nisn
        JOIN jurusan j ON j.id_jurusan = s.id_jurusan";

$conditions = [];
$params = [];

// $result = $conn->query($sql);

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Presensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<!-- style="background-image: url('./img/bg.jpg');" -->
<body class="p-5">
<div class="row wide main-nav-wrap">
    <nav class="column lg-12 main-nav">
        <ul>
            <li><a href="data_guru.php" class="home-link">Guru</a></li>
            <li><a href="data_siswa.php" class="smoothscroll">Siswa</a></li>
        </ul>
    </nav>
</div>

    <header>
        <h2 class="mb-5">Presensi</h2>
    </header>

    <form method="GET" action="" class="mb-4 d-flex">
    <div class="me-4"> <!-- Container untuk jurusan -->
        <h5>Filter berdasarkan Jurusan:</h5>
        <?php foreach ($jurusan_options as $jurusan): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="jurusan[]" value="<?php echo $jurusan['id_jurusan']; ?>" id="jurusan-<?php echo $jurusan['id_jurusan']; ?>" 
                <?php if (in_array($jurusan['id_jurusan'], $jurusan_filters)) echo 'checked'; ?>>
                <label class="form-check-label" for="jurusan-<?php echo $jurusan['id_jurusan']; ?>">
                    <?php echo $jurusan['jurusan']; ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <div> <!-- Container untuk status -->
        <h5>Filter berdasarkan Status:</h5>
        <?php foreach ($status_options as $status): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="status[]" value="<?php echo $status; ?>" id="status-<?php echo $status; ?>" 
                <?php if (in_array($status, $status_filters)) echo 'checked'; ?>>
                <label class="form-check-label" for="status-<?php echo $status; ?>">
                    <?php echo $status; ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-primary mt-2">Filter</button>
    </form>

    <a class= "btn btn-primary" href="pages/create.php">Tambah Data Baru</a><br><br>

    <table class="table table-hover table-light border border-black">
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Jam Masuk</th>
                <th>Atur</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                // Looping data dari database
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['nisn'] . "</td>";
                    echo "<td>" . $row['nama_siswa'] . "</td>";
                    echo "<td>" . $row['kelas'] . "</td>";
                    echo "<td>" . $row['jurusan'] . "</td>";
                    echo "<td>" . $row['tanggal'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['keterangan'] . "</td>";
                    echo "<td>" . $row['jam_masuk'] . "</td>";
                    echo "<td> <button type=\"button\" class=\"btn btn-light btn-sm\"><a href='./pages/edit.php?id=" . $row['id'] . "'>Edit</a></button> | ";
                    echo "<button type=\"button\" class=\"btn btn-light btn-sm\"><a href='./actions/delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\");'>Hapus</a></button> </td>";
                    echo "</td>";
                    echo "</tr>";
               }
            } else {
                echo "<tr><td colspan='5'>Belum ada data.</td></tr>";
            }
            ?>
        </tbody>
    </table> <br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
$conn->close();
?>