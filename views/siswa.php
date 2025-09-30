<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("Location:../login.php?error=Akses ditolak");
    exit;
}
$nama = $_SESSION['username'];
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
      background-color: #D43C3C;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 30px 20px;
    }
    .profile-section {
      text-align: center;
      margin-bottom: 20px;
    }
    .profile-section img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      margin-bottom: 10px;
    }
    .profile-section span {
      display: block;
      font-weight: 700;
      font-size: 1.3rem;   /* lebih besar */
    }
    .sidebar-line {
      width: 80%;
      height: 2px;
      background-color: #ffffff33;
      margin: 20px auto;
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
      background-color: #E12C2C;
    }
    .logout a {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #3498DB;
      color: white;
      text-align: center;
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
    .topbar .username {
      font-size: 1.2rem;   /* lebih besar */
      font-weight: 700;    /* tebal */
    }
    iframe {
      flex-grow: 1;
      width: 100%;
      border: none;
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up { animation: fadeInUp 0.8s ease-in-out; }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div id="sidebar">
    <div>
      <div class="profile-section">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Foto Profil">
        <span><?= htmlspecialchars($nama) ?></span>
      </div>
      <div class="sidebar-line"></div>
      <ul>
        <li>
          <a href="view_siswa.php" target="main-frame">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
          </a>
        </li>
        <li>
          <a href="mata_pelajaran.php" target="main-frame">
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
      <a href="../controller/logout.php" onclick="return confirm('Yakin ingin logout?')">
        <i class="bi bi-box-arrow-right me-2"></i> Log Out
      </a>
    </div>
  </div>

  <!-- Main Content -->
  <div id="main">
    <div class="topbar">
      <div><strong>Selamat Datang</strong></div>
      <div class="d-flex align-items-center">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="35" class="rounded-circle me-2" alt="Admin">
        <span class="username"><?= htmlspecialchars($nama) ?></span>
      </div>
    </div>
    <iframe name="main-frame" src="view_siswa.php"></iframe>
  </div>

</body>
</html>
