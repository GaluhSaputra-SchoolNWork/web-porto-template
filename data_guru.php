<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';
$sql = "SELECT * FROM guru ORDER BY nip ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<!-- style="background-image: url('./img/bg.jpg');" -->
<body class="p-5">
<div class="row wide main-nav-wrap">
    <nav class="column lg-12 main-nav">
        <ul>
            <li><a href="data_presensi.php" class="home-link">Presensi</a></li>
            <li><a href="data_siswa.php" class="smoothscroll">Siswa</a></li>
        </ul>
    </nav>
</div>

    <h2 class="mb-5">Data Guru</h2>
    <table class="table table-hover table-light border border-black">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
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
                    echo "<td>" . $row['nip'] . "</td>";
                    echo "<td>" . $row['nama_guru'] . "</td>";
                    echo "<td> <button type=\"button\" class=\"btn btn-light btn-sm\"><a href='./pages/edit.php?id=" . $row['nip'] . "'>Edit</a></button> | ";
                    echo "<button type=\"button\" class=\"btn btn-light btn-sm\"><a href='./actions/delete.php?id=" . $row['nip'] . "' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\");'>Hapus</a></button> </td>";
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