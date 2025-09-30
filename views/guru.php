<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../login.php?error=" . urlencode("Akses ditolak"));
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Guru</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      display: flex;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      overflow: hidden;
    }

    #sidebar {
      width: 280px;
      background-color: #2c3e50;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 30px 20px;
    }

    .profile-icon {
      font-size: 60px;
      text-align: center;
      margin-bottom: 10px;
    }

    #sidebar h1 {
      font-size: 26px;
      text-align: center;
      margin-bottom: 15px;
    }

    .sidebar-line {
      width: 80%;
      height: 2px;
      background-color: #ffffff33;
      margin: 0 auto 20px;
    }

    #sidebar ul {
      list-style: none;
      padding: 0;
    }

    #sidebar ul li {
      padding: 10px;
      font-size: 17px;
    }

    #sidebar ul li a {
      color: white;
      text-decoration: none;
      display: block;
      border-radius: 5px;
      padding: 8px 12px;
      transition: all 0.3s;
    }

    #sidebar ul li a:hover {
      background-color: #34495e;
    }

    .logout a {
      display: block;
      text-align: center;
      padding: 10px;
      background-color: #0817e8ff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .logout a:hover {
      background-color: #c0392b;
    }

    #main {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    iframe {
      flex-grow: 1;
      border: none;
      width: 100%;
    }

    .topbar {
      background-color: #f8f9fa;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #dee2e6;
    }
  </style>
</head>
<body>
  <div id="sidebar">
    <div>
      <div class="profile-icon">
        <i class="bi bi-person-gear"></i>
      </div>
      <h1>Guru</h1>
      <div class="sidebar-line"></div>
      <ul>
        <li><a href="view_guru.php" target="main-frame">📊 Dashboard</a></li>
        <li><a href="mapel_guru.php" target="main-frame">📘 Mata Pelajaran</a></li>
        <li><a href="nilai.php" target="main-frame">📝 Nilai</a></li>
        <li><a href="kelas.php" target="main-frame">🏫 Kelas</a></li>
        <li><a href="jadwal.php" target="main-frame">📅 Jadwal</a></li>
      </ul>
    </div>
    <div class="logout mt-3">
      <a href="../controller/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Log Out</a>
    </div>
  </div>
  <div id="main">
    <div class="topbar">
      <div>  
        <h1 class="mb-0">Selamat datang</h1>
      </div>
      <div>
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="35" class="rounded-circle me-2" alt="Guru">
         <span><?= htmlspecialchars($_SESSION['username']) ?></span>
      </div>
    </div>
    <iframe name="main-frame" src="view_guru.php"></iframe>
  </div>
</body>
</html>
