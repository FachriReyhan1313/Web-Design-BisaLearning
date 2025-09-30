<?php
session_start();

// Pastikan user login dan role siswa
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php?error=Akses ditolak");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Siswa</title>
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
      font-size: 24px;
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
      padding: 10px 0;
    }

    #sidebar ul li a {
      color: white;
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 5px;
      display: block;
      transition: background-color 0.3s;
    }

    #sidebar ul li a:hover {
      background-color: #34495e;
    }

    .logout a {
      display: block;
      text-align: center;
      padding: 10px;
      background-color: #0817e8;
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

    .topbar {
      background-color: #f8f9fa;
      padding: 12px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #dee2e6;
    }

    iframe {
      flex-grow: 1;
      width: 100%;
      border: none;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div id="sidebar">
    <div>
      <div class="profile-icon">
        <i class="bi bi-person-circle"></i>
      </div>
      <h1>Siswa</h1>
      <div class="sidebar-line"></div>
      <ul>
        <li>
          <a href="view_siswa.php" target="main-frame">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
          </a>
        </li>
        <li>
          <a href="detail_pelajaran.php" target="main-frame">
            <i class="bi bi-journal-text me-2"></i> Mata Pelajaran
          </a>
        </li>
        <li>
          <a href="Nilai.php" target="main-frame">
            <i class="bi bi-card-checklist me-2"></i> Nilai
          </a>
        </li>
      </ul>
    </div>

    <!-- Logout -->
    <div class="logout mt-3">
      <a href="../controller/logout.php">
        <i class="bi bi-box-arrow-right me-2"></i> Log Out
      </a>
    </div>
  </div>

  <!-- Main Content -->
  <div id="main">
    <div class="topbar">
      <div><strong>Selamat Datang</strong></div>
      <div>
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="35" class="rounded-circle me-2" alt="User">
        <span><?= htmlspecialchars($_SESSION['username']) ?></span>
      </div>
    </div>
    <iframe name="main-frame" src="view_siswa.php"></iframe>
  </div>
</body>
</html>
