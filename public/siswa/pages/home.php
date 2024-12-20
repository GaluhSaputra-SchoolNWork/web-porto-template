<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

$nisn = $_SESSION['nisn'];
$query = "SELECT nama_siswa FROM siswa WHERE nisn = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $nisn);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama_siswa = $row['nama_siswa'];
    $_SESSION['nama_siswa'] = $nama_siswa;
}

if (!isset($_SESSION['username'])) {
    header("Location: ../../../../login.php");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header("Location: ../../../logout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="css/card.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/home-siswa.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
<div class="app">

	<header class="app-header">

		<div class="app-header-logo">
		</div>

		<div class="app-header-navigation">
			<span>
				<?php
					if (isset($_SESSION['nama_siswa'])) {
						echo "<h5>Selamat datang kembali, " . htmlspecialchars($_SESSION['nama_siswa']) . "!</h5>";
					}
					?>
			</span>
		</div>

		<div class="app-header-actions">
			<span>
				<form action="../../../logout.php" method="post" class="mt-3">
					<button type="submit" class="btn btn-danger">Logout</button>
				</form>
			</span>
		</div>

		<div class="app-header-mobile">
		</div>

	</header>

	<div class="app-body">

		<div class="app-body-navigation">
		</div>

		<div class="app-body-main-content">
			<section class="service-section">
				<h2>Absen</h2>

				<div class="service-section-header">
					<div class="service-section-header">
						<form action="proses_absen.php" method="post">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="Hadir">
								<label class="form-check-label" for="inlineRadio1">Hadir</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="Sakit">
								<label class="form-check-label" for="inlineRadio2">Sakit</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="status" id="inlineRadio3" value="Izin">
								<label class="form-check-label" for="inlineRadio3">Izin</label>
							</div>
							<input type="submit" value="Kirim Absen" class="btn btn-primary">
						</form>
					</div>
				</div>
                
				<div class="service-section-footer">
				</div>
			</section>
			
			<section class="transfer-section">
				<div class="transfer-section-header">
					<h2>Data</h2>
				</div>
				<div class="transfers">
                    <span> Tidak ada Data </span>
				</div>
			</section>
		</div>

		<div class="app-body-sidebar">
		</div>

	</div>

</div>
</body>
</html>