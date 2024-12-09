<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/azzyra-nathalyne/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/card.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard-admin.css">
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
					if (isset($_SESSION['username'])) {
						echo "<h5>Selamat datang kembali, " . htmlspecialchars($_SESSION['username']) . "!</h5>";
					}
					?>
			</span>
		</div>

		<div class="app-header-actions">
			<span>
				<form action="../../azzyra-nathalyne/logout.php" method="post" class="mt-3">
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
				<h2>Dashboard</h2>
				<div class="service-section-header">
				</div>
				<div class="tiles">
					<article class="tile" data-type="presensi">
						<div class="tile-header">
							<i class="ph ph-database"></i>
							<h3>
								<span>Data</span>
								<span>Presensi</span>
							</h3>
						</div>
						<a href="#">
							<span>Lihat Data</span>
							<span class="icon-button">
								<i class="ph ph-arrow-right"></i>
							</span>
						</a>
					</article>
					<article class="tile" data-type="siswa">
						<div class="tile-header">
							<i class="ph ph-database"></i>
							<h3>
								<span>Data</span>
								<span>Siswa</span>
							</h3>
						</div>
						<a href="#">
							<span>Lihat Data</span>
							<span class="icon-button">
								<i class="ph ph-arrow-right"></i>
							</span>
						</a>
					</article>
					<article class="tile" data-type="guru">
						<div class="tile-header">
							<i class="ph ph-database"></i>
							<h3>
								<span>Data</span>
								<span>Guru</span>
							</h3>
						</div>
						<a href="#">
							<span>Lihat Data</span>
							<span class="icon-button">
								<i class="ph ph-arrow-right"></i>
							</span>
						</a>
					</article>
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
<script>
document.querySelectorAll('.tile').forEach(tile => {
    tile.addEventListener('click', function(event) {
        event.preventDefault();
        const type = this.getAttribute('data-type');
        loadData(type);
    });
});

function loadData(type) {
    const transfersDiv = document.querySelector('.transfers');
    const appBodySidebarDiv = document.querySelector('.app-body-sidebar');
    
    transfersDiv.innerHTML = '';
    appBodySidebarDiv.innerHTML = '';

    // Ambil nilai dari checkbox
    const jurusanFilters = Array.from(document.querySelectorAll('input[name="jurusan[]"]:checked')).map(el => el.value);
    const statusFilters = Array.from(document.querySelectorAll('input[name="status[]"]:checked')).map(el => el.value);
    
    // Buat query string untuk filter
    const params = new URLSearchParams();
    params.append('type', type);
    if (jurusanFilters.length > 0) {
        params.append('jurusan', JSON.stringify(jurusanFilters));
    }
    if (statusFilters.length > 0) {
        params.append('status', JSON.stringify(statusFilters));
    }

    fetch(`data/process/get_data.php?type=${type}`)
        .then(response => response.text())
        .then(data => {
            transfersDiv.innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            transfersDiv.innerHTML = '<span>Error loading data.</span>';
        });

    fetch(`data/process/get_filter.php?${params.toString()}`)
        .then(response => response.text())
        .then(data => {
            appBodySidebarDiv.innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            appBodySidebarDiv.innerHTML = '<span>Error loading filter.</span>';
        });
}
</script>
</body>
</html>