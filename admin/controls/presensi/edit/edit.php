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

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM presensi WHERE id = $id");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- <link rel="stylesheet" href="css/card.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../css/dashboard-admin.css">
    <link rel="stylesheet" href="css/card.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    <div class="app">

        <div class="app-body">
            <div class="app-body-main-content">

                <section class="service-section">
                    <h2>Edit Data</h2>
                </section>

                <div class="service-section-header">
                </div><br>

                <form action="update.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <label for="judul">NISN :</label>
                    <input class="form-control" type="text" id="nisn" name="nisn" value="<?php echo $row['nisn']; ?>" required><br>

                    <label for="status">Status :</label><br>
                    <select class="form-control" id="status" name="status" value="<?php echo $row['status']; ?>" required>
                        <option value="Hadir">Hadir</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                        <option value="Alfa">Alfa</option>
                    </select><br>

                    <label for="tanggal">Tanggal :</label><br>
                    <input class="form-control" type="date" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>" required><br>
                    
                    <label for="jam_masuk">Jam Masuk :</label><br>
                    <input class="form-control" type="time" id="jam_masuk" name="jam_masuk" value="<?php echo $row['jam_masuk']; ?>"><br>
                    
                    <label for="keterangan">Keterangan :
                    </label><br>
                    <textarea class="form-control" type="text" id="keterangan" name="keterangan" value="<?php echo $row['keterangan']; ?>" required></textarea><br>
                    
                    <a href="../../../dashboard/dashboard-admin-presensi.php" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-secondary" type="reset">Reset</button>
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>