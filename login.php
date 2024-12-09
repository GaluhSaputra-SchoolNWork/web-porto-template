<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek di tabel login_admin
    $query = "SELECT * FROM login_admin WHERE user_admin = ? AND pw_admin = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika admin, arahkan ke data_presensi.php
        $_SESSION['role'] = 'admin';
        $_SESSION['username'] = $username;
        header("Location: admin/dashboard-admin.php");
        exit();
    }

    // Cek di tabel login_guru
    $query = "SELECT * FROM login_guru WHERE user_guru = ? AND pw_guru = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika guru, arahkan ke riwayat.php
        $_SESSION['role'] = 'guru';
        header("Location: public/guru/pages/home.php");
        exit();
    }

    // Cek di tabel login_siswa
    $query = "SELECT ls.*, s.nama_siswa FROM login_siswa ls JOIN siswa s ON ls.user_siswa = s.nisn WHERE ls.user_siswa = ? AND ls.pw_siswa = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika siswa, arahkan ke absen.php
        $siswa_data = $result->fetch_assoc();
        $_SESSION['role'] = 'siswa';
        $_SESSION['username'] = $siswa_data['user_siswa']; // Ambil nisn
        $_SESSION['nama_siswa'] = $siswa_data['nama_siswa']; // Ambil nama_siswa
        header("Location: public/siswa/pages/home.php");
        exit();
    }

    // Jika tidak ada yang cocok
    echo "Email atau password salah/tidak terdaftar!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.2.0/anime.min.js"></script>
    <script type="module" src="js/login.js"></script>
</head>
<body>
<div class="page">
  <div class="container">
    <div class="left">
      <div class="login">Login</div>
      <div class="eula">Selamat datang kembali! Silahkan masukkan username dan Password Anda</div>
    </div>
    <div class="right">
      <svg viewBox="0 0 320 300">
        <defs>
          <linearGradient
                          inkscape:collect="always"
                          id="linearGradient"
                          x1="13"
                          y1="193.49992"
                          x2="307"
                          y2="193.49992"
                          gradientUnits="userSpaceOnUse">
            <stop
                  style="stop-color:#ff00ff;"
                  offset="0"
                  id="stop876" />
            <stop
                  style="stop-color:#ff0000;"
                  offset="1"
                  id="stop878" />
          </linearGradient>
        </defs>
        <path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143" />
      </svg>
      <form action="login.php" method="post">
        <div class="form">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
          <input type="submit" id="submit" value="Submit">
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>