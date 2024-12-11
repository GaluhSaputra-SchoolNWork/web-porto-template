<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

$sql = "SELECT * FROM guru";

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
    <link rel="stylesheet" href="../css/dashboard-admin.css">
    <link rel="stylesheet" href="../css/card.css">
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
                        <a class="navbar-brand text-light disabled" aria-disabled="true" href="">
                            <img src="../../starlightlogo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                            Starlight
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                            </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="dashboard-admin.php">Beranda</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="dashboard-admin-presensi.php">Presensi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light active" aria-current="page" href="">Siswa</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="dashboard-admin-guru.php">Guru</a>
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
                        </div>

                        <div class="col">
                        </div>
                    
                        <div class="col">
                        </div>

                        <div class="row p-2">
                        </div>

                        <div class="row p-2">
                        </div>

                        <div class="row p-2">
                        </div>
                    
                        <div cs="row">
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
                    <?php
                        echo '<h2 class="mb-5">Data Guru</h2>';
                        echo '<div class="card-container">';
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $src = $row['foto_guru'] === NULL ? 'group_4.png' : $row['foto_guru'];
                                echo '<div class="card text-bg-dark mb-3">';
                                echo '<img src="../img/fotoguru/' . $src . '" class="card-img-top" alt="' . htmlspecialchars($row['nama_guru']) . '">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . htmlspecialchars($row['nama_guru']) . '</h5>';
                                echo '<p class="card-text">NIP: ' . htmlspecialchars($row['nip']) . '</p>';
                                echo '<p class="card-text">Nama: ' . htmlspecialchars($row['nama_guru']) . '</p>';
                                echo '<a href="./pages/edit.php?id=' . $row['nip'] . '" class="btn btn-success btn-sm">Edit</a> <br><br>';
                                echo '<a href="./actions/delete.php?id=' . $row['nip'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini?\');">Hapus</a>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "<div class='col-12'>Belum ada data.</div>";
                        }
                        echo '</div>';
                    ?>
                </div>
            </section>
        </div>
    </div>
</body>
</html>