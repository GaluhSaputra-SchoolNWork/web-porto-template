<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../../../../login.php");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

$nip = $_GET['id'];
$result = $conn->query("SELECT g.*, j.jurusan FROM guru g JOIN jurusan j ON g.id_jurusan = j.id_jurusan WHERE g.nip = '$nip'");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../css/dashboard-admin.css">
</head>
<body>
    <div class="app">
        <div class="app-body">
            <div class="app-body-main-content">
                <section class="service-section">
                    <h2>Edit Data Guru</h2>
                </section>

                <form action="update.php" method="POST">
                    <input type="hidden" name="nip" value="<?php echo $row['nip']; ?>">
                    
                    <label for="nama_guru">Nama Guru:</label>
                    <input class="form-control" type="text" id="nama_guru" name="nama_guru" value="<?php echo $row['nama_guru']; ?>" required><br>

                    <label for="jurusan">Jurusan:</label>
                    <select class="form-control" name="jurusan" id="jurusan" required>
                        <?php
                        $jurusan_sql = "SELECT * FROM jurusan";
                        $jurusan_result = $conn->query($jurusan_sql);
                        while ($jurusan_row = $jurusan_result->fetch_assoc()) {
                            echo '<option value="' . $jurusan_row['id_jurusan'] . '" ' . ($row['id_jurusan'] == $jurusan_row['id_jurusan'] ? 'selected' : '') . '>' . $jurusan_row['jurusan'] . '</option>';
                        }
                        ?>
                    </select><br>

                    <label for="password">Password:</label>
                    <input class="form-control" type="password" id="password" name="password" placeholder="Masukkan Password Baru (Kosongkan jika tidak ingin mengubah)"><br>

                    <a href="../../../dashboard/dashboard-admin-guru.php" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-secondary" type="reset">Reset</button>
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>