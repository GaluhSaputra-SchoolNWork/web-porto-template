<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
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
    <link rel="stylesheet" href="../css/dashboard-admin.css">
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
						<span class="navbar-toggler-icon">
						</span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav">
							<li class="nav-item">
								<a class="nav-link text-light active" aria-current="page" href="">Beranda</a>
							</li>
							<li class="nav-item">
								<a class="nav-link text-light" href="dashboard-admin-presensi.php">Presensi</a>
							</li>
							<li class="nav-item">
								<a class="nav-link text-light" href="dashboard-admin-siswa.php">Siswa</a>
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
				<h2>Dashboard</h2>
				<div class="service-section-header">
				</div>
				<div class="tiles">
					<article class="tile" data-type="presensi">
						<div class="tile-header">
							<i class="ph ph-note"></i>
							<h3>
								<?php
									$query = "SELECT COUNT(*) AS total FROM presensi";
									$result = $conn->query($query);

									if ($result && $row = $result->fetch_assoc()) {
										$jumlah_siswa = $row['total'];
									} else {
										$jumlah_siswa = 0;
									}
								?>

								<?php echo htmlspecialchars($jumlah_siswa); ?>

								<span>Data Presensi</span>
							</h3>
						</div>
						<a href="dashboard-admin-presensi.php">
							<span>Lihat Data</span>
							<span class="icon-button">
								<i class="ph ph-arrow-right"></i>
							</span>
						</a>
					</article>
					<article class="tile" data-type="siswa">
						<div class="tile-header">
							<i class="ph ph-student"></i>
							<h3>
								<?php
									$query = "SELECT COUNT(*) AS total FROM siswa";
									$result = $conn->query($query);

									if ($result && $row = $result->fetch_assoc()) {
										$jumlah_siswa = $row['total'];
									} else {
										$jumlah_siswa = 0;
									}
								?>

								<?php echo htmlspecialchars($jumlah_siswa); ?>

								<span>Data Siswa</span>
							</h3>
						</div>
						<a href="dashboard-admin-siswa.php">
							<span>Lihat Data</span>
							<span class="icon-button">
								<i class="ph ph-arrow-right"></i>
							</span>
						</a>
					</article>
					<article class="tile" data-type="guru">
						<div class="tile-header">
							<i class="ph ph-chalkboard-teacher"></i>
							<h3>
								<?php
									$query = "SELECT COUNT(*) AS total FROM guru";
									$result = $conn->query($query);

									if ($result && $row = $result->fetch_assoc()) {
										$jumlah_siswa = $row['total'];
									} else {
										$jumlah_siswa = 0;
									}
								?>

								<?php echo htmlspecialchars($jumlah_siswa); ?>

								<span>Data Guru</span>
							</h3>
						</div>
						<a href="dashboard-admin-guru.php">
							<span>Lihat Data</span>
							<span class="icon-button">
								<i class="ph ph-arrow-right"></i>
							</span>
						</a>
					</article>
				</div>
				
				<div class="service-section-footer">
				</div>

				<section class="transfer-section">
					<div class="transfer-section-header">
						<h2>Status Database</h2>
					</div>

					<div class="transfer">
						<?php
						if (!$conn) {
							die("<h4 class='mt-5'>Gagal menyambung ke database: " . mysqli_connect_error() . "</h4>");
						}
						echo "<h4 class='mt-5'>Terhubung ke database</h4>";
						?>
					</div>
				</section>
			</section>
		</div>
	</div>

</div>
</body>
</html>