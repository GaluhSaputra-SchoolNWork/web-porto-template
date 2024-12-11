<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../css/dashboard-admin.css">
</head>
<body>
    <div class="app">
        <div class="app-body">
            <div class="app-body-main-content">
                <section class="service-section">
                    <h2>Tambah Data Siswa</h2>
                </section>

                <form action="insert.php" method="POST">
                    <label for="nisn">NISN:</label><br>
                    <input class="form-control" type="text" id="nisn" name="nisn" maxlength="10" required placeholder="Masukkan NISN"><br>

                    <label for="nama_siswa">Nama Siswa:</label><br>
                    <input class="form-control" type="text" id="nama_siswa" name="nama_siswa" required placeholder="Masukkan Nama Siswa"><br>

                    <label for="kelas">Kelas:</label><br>
                    <select class="form-control" name="kelas" id="kelas" required>
                        <option value="X">X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                    </select><br>

                    <label for="jurusan">Jurusan:</label><br>
                    <select class="form-control" name="jurusan" id="jurusan" required>
                        <?php
                        require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';
                        $jurusan_sql = "SELECT * FROM jurusan";
                        $jurusan_result = $conn->query($jurusan_sql);
                        while ($jurusan_row = $jurusan_result->fetch_assoc()) {
                            echo '<option value="' . $jurusan_row['id_jurusan'] . '">' . $jurusan_row['jurusan'] . '</option>';
                        }
                        ?>
                    </select><br>

                    <label for="password">Password:</label><br>
                    <input class="form-control" type="password" id="password" name="password" required placeholder="Masukkan Password"><br>

                    <a href="../../../dashboard/dashboard-admin-siswa.php" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>