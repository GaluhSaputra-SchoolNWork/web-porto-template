<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

$nama_guru_filter = isset($_GET['nama_guru']) ? $_GET['nama_guru'] : '';
$nip_filter = isset($_GET['nip']) ? $_GET['nip'] : '';
$jurusan_filters = isset($_GET['jurusan']) ? $_GET['jurusan'] : [];

$sql = "SELECT * FROM guru g LEFT JOIN jurusan j ON g.id_jurusan = j.id_jurusan LEFT JOIN login_guru l ON l.user_guru = g.nip";

$conditions = [];
$params = [];

if (!empty($nama_guru_filter)) {
    $conditions[] = "g.nama_guru LIKE ?";
    $params[] = '%' . $nama_guru_filter . '%';
}

if (!empty($nip_filter)) {
    $conditions[] = "g.nip LIKE ?";
    $params[] = '%' . $nip_filter . '%';
}

if (!empty($jurusan_filters)) {
    $placeholders = implode(',', array_fill(0, count($jurusan_filters), '?'));
    $conditions[] = "g.id_jurusan IN ($placeholders)";
    $params = array_merge($params, $jurusan_filters);
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " ORDER BY g.nama_guru ASC";

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
                        <a class="navbar-brand text-light" href="">
                            <img src="../../starlightlogo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                            Starlight
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
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
                                    <a class="nav-link text-light" href="dashboard-admin-siswa.php">Siswa</a>
                                </li>
                                <li class ="nav-item">
                                    <a class="nav-link text-light active" aria-current="page" href="">Guru</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="app-header-actions">
                <span>
                    <form action="../../logout.php" method="post" class="mt-3">
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
                    <a class= "btn btn-primary" href="../controls/guru/tambah/add.php">Tambah Data Baru</a><br><br>
                </div><br>

                <form method="GET" action="" class="mb-4">
                    <div class="row p-1">
                        <div class="col d-flex gap-3">
                            <h5>Filter berdasarkan Jurusan:</h5>
                            <?php foreach ($jurusan_options as $jurusan): ?>
                                <div class="form-check">
                                    <div class="col">
                                        <input class="form-check-input" type="checkbox" name="jurusan[]" value="<?php echo $jurusan['id_jurusan']; ?>" id="jurusan-<?php echo $jurusan['id_jurusan']; ?>" 
                                        <?php if (in_array($jurusan['id_jurusan'], $jurusan_filters)) echo 'checked'; ?>>
                                        <label class="form-check-label" for="jurusan-<?php echo $jurusan['id_jurusan']; ?>">
                                            <?php echo $jurusan['jurusan']; ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col">
                            <h6>Cari Nama Guru:</h6>
                            <input type="text" name="nama_guru" class="form-control" value="<?php echo isset($_GET['nama_guru']) ? htmlspecialchars($_GET['nama_guru']) : ''; ?>">
                        </div>
                        <div class="col">
                            <h6>Cari NIP:</h6>
                                <input type="text" name="nip" class="form-control" value="<?php echo isset($_GET['nip']) ? htmlspecialchars($_GET['nip']) : ''; ?>">
                        </div>
                    </div>

                    <div class="row p-1">
                        <div class="col">
                            <button type="submit" class="btn btn-primary mt-2 mw-250">Filter</button>
                        </div>
                        <div class="col">
                            <a href="dashboard-admin-guru.php" class="btn btn-primary mt-2 mw-250">Reset</a>
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
                        echo '<h4 class="mb-5">Data Guru</h4>';
                        echo '<div class="card-container">';
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $src = $row['foto_guru'] === NULL ? 'group_4.png' : $row['foto_guru'];
                                echo '<div class="card text-bg-dark mb-3">';
                                echo '<img src="../img/fotoguru/' . $src . '" class="card-img-top" alt="' . htmlspecialchars($row['nama_guru']) . '">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . htmlspecialchars($row['nama_guru']) . '</h5>';
                                echo '<p class="card-text">NIP: ' . htmlspecialchars($row['nip']) . '</p>';
                                echo '<p class="card-text">Jurusan: ' . htmlspecialchars($row['jurusan']) . '</p>';
                                echo '<p class="card-text">Password: ' . htmlspecialchars($row['pw_guru']) . '</p>';
                                echo '<a href="../controls/guru/edit/edit.php?id=' . $row['nip'] . '" class="btn btn-success btn-sm">Edit</a> <br><br>';
                                echo '<a href="../controls/guru/hapus/delete.php?id=' . $row['nip'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini?\');">Hapus</a>';echo '</div>';
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