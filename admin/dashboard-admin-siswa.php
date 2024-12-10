<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

$sql = "SELECT s.*, j.* FROM siswa s JOIN jurusan j ON s.id_jurusan = j.id_jurusan ORDER BY nisn ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- <link rel="stylesheet" href="css/card.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard-admin.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    <div class="app">

        <header class="app-header">

            <div class="app-header-logo">
                <span>
                    <?php
                        if (isset($_SESSION['username'])) {
                            echo "<h5>Selamat datang kembali, " . htmlspecialchars($_SESSION['username']) . "!</h5>";
                        }
                    ?>
                </span>
            </div>

            <div class="app-header-navigation">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <a class="navbar-brand text-light" href="#">
                            <img src="../starlightlogo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                            Starlight
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                            </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link text-light" aria-current="page" href="dashboard-admin.php">Beranda</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light active" href="dashboard-admin-presensi.php">Presensi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="#">Siswa</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light" aria-disabled="true">Guru</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                
            </div>

            <div class="app-header-actions">
                <span>
                    <form action="../logout.php" method="post" class="mt-3">
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </span>
            </div>

            <div class="app-header-mobile">
            </div>

        </header>

        <div class="app-body">
            <div class="app-body-main-content">

                <section class="service-section">
                    <h2>Kontrol Data</h2>
                </section>

                <div class="service-section-header">
                    <a class= "btn btn-primary" href="data/pages/tambah-presensi.php">Tambah Data Baru</a><br><br>
                </div><br>

                <form method="GET" action="" class="mb-4 d-flex">
                    <div class="row p-1">
                        <div class="col">
                            <div class="me-4">
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
                        </div>

                        <div class="col">
                            <div>
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
                        </div>
                    
                        <div class="col">
                            <div>
                                <h5>Filter berdasarkan Kelas:</h5>
                                <?php foreach ($kelas_options as $kelas): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kelas[]" value="<?php echo $kelas; ?>" id="kelas-<?php echo $kelas; ?>" 
                                        <?php if (in_array($kelas, $kelas_filters)) echo 'checked'; ?>>
                                        <label class="form-check-label" for="status-<?php echo $kelas; ?>">
                                            <?php echo $kelas; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="row p-2">
                            <div class="col">
                                <h6>Cari Nama Siswa:</h6>
                                <input type="text" name="nama_siswa" class="form-control" value="<?php echo isset($_GET['nama_siswa']) ? htmlspecialchars($_GET['nama_siswa']) : ''; ?>">
                            </div>

                            <div class="col">
                                <h6>Cari NISN:</h6>
                                <input type="text" name="nisn" class="form-control" value="<?php echo isset($_GET['nisn']) ? htmlspecialchars($_GET['nisn']) : ''; ?>">
                            </div>

                            <div class="col">
                                <h6>Cari Keterangan:</h6>
                                <input type="text" name="keterangan" class="form-control" value="<?php echo isset($_GET['keterangan']) ? htmlspecialchars($_GET['keterangan']) : ''; ?>">
                            </div>
                        </div>

                        <div class="row p-2">
                            <div class="col">
                                <h6>Dari Tanggal:</h6>
                                <input type="date" name="tanggal_dari" class="form-control" value="<?php echo isset($_GET['tanggal_dari']) ? htmlspecialchars($_GET['tanggal_dari']) : ''; ?>">
                            </div>

                            <div class="col">
                                <h6>Sampai Tanggal:</h6>
                                <input type="date" name="tanggal_sampai" class="form-control" value="<?php echo isset($_GET['tanggal_sampai']) ? htmlspecialchars($_GET['tanggal_sampai']) : ''; ?>">
                            </div>
                        </div>

                        <div class="row p-2">
                            <div class="col">
                                <h6>Dari Jam:</h6>
                                <input type="time" name="jam_dari" class="form-control" value="<?php echo isset($_GET['jam_dari']) ? htmlspecialchars($_GET['jam_dari']) : ''; ?>">
                            </div>

                            <div class="col">
                                <h6>Sampai Jam:</h6>
                                <input type="time" name="jam_sampai" class="form-control" value="<?php echo isset($_GET['jam_sampai']) ? htmlspecialchars($_GET['jam_sampai']) : ''; ?>">
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary mt-2 mw-250">Filter</button>
                            </div>
                            <div class="col">
                                <a href="dashboard-admin-presensi.php" class="btn btn-primary mt-2 mw-250">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="service-section-footer">
            </div>

            <section class="transfer-section">
                <div class="transfer-section-header">
                    <h2>Data</h2>
                </div>

                <div class="transfers">
                    <table class="table table-bordered table-dark">
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
                                        echo "<td> <button type=\"button\" class=\"btn btn-success btn-sm\"><a href='./pages/edit.php?id=" . $row['id'] . "'>Edit</a></button> | ";
                                        echo "<button type=\"button\" class=\"btn btn-danger btn-sm\"><a href='./actions/delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\");'>Hapus</a></button> </td>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Belum ada data.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table><br>
                </div>
            </section>
        </div>
    </div>
</body>
</html>