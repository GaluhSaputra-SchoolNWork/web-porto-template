<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';
$sql = "SELECT p.*, s.nama_siswa FROM presensi p 
        JOIN siswa s ON p.nisn = s.nisn 
        ORDER BY p.id ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Query Error: " . $conn->error);
}
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
    <h2 class="mb-5">Presensi</h2>
    <table class="table table-hover table-light border border-black">
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama</th>
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
    <a class= "btn btn-primary" href="pages/create.php">Tambah Data Baru</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
$conn->close();
?>