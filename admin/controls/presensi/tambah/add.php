<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../../../../login.php");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../../../logout.php");
    exit();
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
                    <h2>Tambah Data</h2>
                </section>

                <div class="service-section-header">
                </div><br>

                <form action="insert.php" method="POST">
                    <label for="nisn">NISN/Nama :</label><br>
                    <input class="form-control" type="text" id="nisn" name="nisn" maxlength="50" required placeholder="Masukkan NISN atau Nama"><br>

                    <label for="status">Status :</label><br>
                    <select class="form-control" name="status" id="status">
                        <option value="Hadir">Hadir</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                        <option value="Alfa">Alfa</option>
                    </select><br>

                    <label for="tanggal">Tanggal :</label><br>
                    <input class="form-control" type="date" id="tanggal" name="tanggal" required></input><br>

                    <label for="jam_masuk">Jam Masuk :</label>
                    <input class="form-control" type="time" id="jam_masuk" name="jam_masuk"></input><br>

                    <label for="keterangan">Keterangan :</label>
                    <textarea class="form-control" type="text" id="keterangan" name="keterangan"></textarea><br>
                    
                    <a href="../../../dashboard/dashboard-admin-presensi.php" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </form>

                <script>
                    document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];

                    const now = new Date();
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    document.getElementById('jam_masuk').value = `${hours}:${minutes}`
                </script>
            </div>
        </div>
    </div>
</body>
</html>