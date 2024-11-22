<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';
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
    <title>Edit Data Presensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="p-5">
    <h2>Edit Data Presensi</h2>
    <form action="../actions/update.php" method="POST">
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
        <input class="form-control" type="time" id="jam_masuk" name="jam_masuk" value="<?php echo $row['jam_masuk']; ?>" required><br>
        
        <label for="keterangan">Keterangan :
        </label><br>
        <textarea class="form-control" type="text" id="keterangan" name="keterangan" value="<?php echo $row['keterangan']; ?>" required></textarea><br>
        
        <a href="../data_presensi.php" class="btn btn-secondary">Kembali</a>
        <button class="btn btn-secondary" type="reset">Reset</button>
        <button class="btn btn-primary" type="submit">Update</button>
    </form>
</body>
</html>