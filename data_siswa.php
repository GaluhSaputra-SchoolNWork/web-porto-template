<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';
$sql = "SELECT s.*, j.* FROM siswa s JOIN jurusan j ON s.id_jurusan = j.id_jurusan ORDER BY nisn ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<!-- style="background-image: url('./img/bg.jpg');" -->
<body class="p-5">
<div class="row wide main-nav-wrap">
    <nav class="column lg-12 main-nav">
        <ul>
            <li><a href="data_guru.php" class="home-link">Guru</a></li>
            <li><a href="data_presensi.php" class="smoothscroll">Presensi</a></li>
        </ul>
    </nav>
</div>

    <h2 class="mb-5">Data Siswa</h2>

    <a class= "btn btn-primary" href="pages/create.php">Tambah Data Baru</a>

    <div class="card-container">
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                // Looping data dari database
                while ($row = $result->fetch_assoc()) {
                    if ($row['foto_siswa'] === NULL ) {
                        $src = 'group_4.png';
                    } else {
                        $src = $row['foto_siswa'];
                    }

                    echo '<div class="card">';
                    echo '<img src="fotosiswa/' . $src . '" class="card-img-top" alt="' . $row['nama_siswa'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['nama_siswa'] . '</h5>';
                    echo '<p class="card-text">NISN: ' . $row['nisn'] . '</p>';
                    echo '<p class="card-text">Kelas: ' . $row['kelas'] . '</p>';
                    echo '<p class="card-text">Jurusan: ' . $row['jurusan'] . '</p>';
                    echo '<a href="./pages/edit.php?id=' . $row['nisn'] . '" class="btn btn-success btn-sm">Edit</a>';
                    echo '<a href="./actions/delete.php?id=' . $row['nisn'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini?\');">Hapus</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<div class='col-12'>Belum ada data.</div>";
            }
            ?>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
$conn->close();
?>