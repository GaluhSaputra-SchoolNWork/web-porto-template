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
        $sql = "SELECT * FROM guru"; // Ganti dengan query yang sesuai
        break;
    default:
        echo "<span>Invalid data type.</span>";
        exit;
}

$result = $conn->query($sql);

if ($type === 'presensi') {
    // Tampilkan data presensi dalam tabel
    echo '<h2 class="mb-5">Presensi</h2>';
    echo '<table class="table table-dark">
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
            <tbody>';
    
    if ($result->num_rows > 0) {
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . htmlspecialchars($row['nisn']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nama_siswa']) . "</td>";
            echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
            echo "<td>" . htmlspecialchars($row['jurusan']) . "</td>";
            echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
            echo "<td>" . htmlspecialchars($row['keterangan']) . "</td>";
            echo "<td>" . htmlspecialchars($row['jam_masuk']) . "</td>";
            echo "<td>
                    <button type=\"button\" class=\"btn btn-light btn-sm\">
                        <a href='./pages/edit.php?id=" . $row['id'] . "'>Edit</a>
                    </button> | 
                    <button type=\"button\" class=\"btn btn-light btn-sm\">
                        <a href='./actions/delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\");'>Hapus</a>
                    </button>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='10'>Belum ada data.</td></tr>";
    }
    echo '</tbody></table>';

} elseif ($type === 'siswa') {
    // Tampilkan data siswa dalam kartu
    echo '<h2 class="mb-5">Data Siswa</h2>';
    echo '<div class="card-container">';
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $src = $row['foto_siswa'] === NULL ? 'group_4.png' : $row['foto_siswa'];
            echo '<div class="card text-bg-dark mb-3">';
            echo '<img src="fotosiswa/' . $src . '" class="card-img-top" alt="' . htmlspecialchars($row['nama_siswa']) . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['nama_siswa']) . '</h5>';
            echo '<p class="card-text">NISN: ' . htmlspecialchars($row['nisn']) . '</p>';
            echo '<p class="card-text">Kelas: ' . htmlspecialchars($row['kelas']) . '</p>';
            echo '<p class="card-text">Jurusan: ' . htmlspecialchars($row['jurusan']) . '</p>';
            echo '<a href="./pages/edit.php?id=' . $row['nisn'] . '" class="btn btn-success btn-sm">Edit</a> <br><br>';
            echo '<a href="./actions/delete.php?id=' . $row['nisn'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini?\');">Hapus</a>';
            echo '</div>'; // Menutup div.card-body
            echo '</div>'; // Menutup div.card
        }
    } else {
        echo "<div class='col-12'>Belum ada data.</div>";
    }
    echo '</div>'; // Menutup div.card-container

} elseif ($type === 'guru') {
    // Tampilkan data guru dalam kartu
    echo '<h2 class="mb-5">Data Guru</h2>';
    echo '<div class="card-container">';
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $src = $row['foto_guru'] === NULL ? 'group_4.png' : $row['foto_guru'];
            echo '<div class="card text-bg-dark mb-3">';
            echo '<img src="fotoguru/' . $src . '" class="card-img-top" alt="' . htmlspecialchars($row['nama_guru']) . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['nama_guru']) . '</h5>';
            echo '<p class="card-text">NIP: ' . htmlspecialchars($row['nip']) . '</p>';
            echo '<p class="card-text">Nama: ' . htmlspecialchars($row['nama_guru']) . '</p>';
            echo '<a href="./pages/edit.php?id=' . $row['nip'] . '" class="btn btn-success btn-sm">Edit</a> <br><br>';
            echo '<a href="./actions/delete.php?id=' . $row['nip'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini?\');">Hapus</a>';
            echo '</div>'; // Menutup div.card-body
            echo '</div>'; // Menutup div.card
        }
    } else {
        echo "<div class='col-12'>Belum ada data.</div>";
    }
    echo '</div>'; // Menutup div.card-container
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/card.css">
</head>
<body>
    
</body>
</html>