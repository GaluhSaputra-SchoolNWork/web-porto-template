<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="p-5">
    <h2>Tambah Data Presensi Baru</h2>
    <form action="../actions/store.php" method="POST">
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
        
        <a href="../data_presensi.php" class="btn btn-secondary">Kembali</a>
        <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
        // Mengatur input tanggal ke tanggal saat ini
        document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];

        // Mengatur input jam masuk ke waktu saat ini
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('jam_masuk').value = `${hours}:${minutes}`
    </script>
</body>

</html>