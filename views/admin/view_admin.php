<?php
require_once(__DIR__ . '/../../config/mysql_db.php'); // koneksi ke DB

// Query total data
$totalSiswa   = $conn->query("SELECT COUNT(*) AS total FROM siswa")->fetch_assoc()['total'] ?? 0;
$totalGuru    = $conn->query("SELECT COUNT(*) AS total FROM guru")->fetch_assoc()['total'] ?? 0;
$totalRelawan = $conn->query("SELECT COUNT(*) AS total FROM relawan")->fetch_assoc()['total'] ?? 0;
$totalKelas   = $conn->query("SELECT COUNT(*) AS total FROM kelas")->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Statistik</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #74ebd5, #acb6e5);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .dashboard-container {
      max-width: 1000px;
      width: 100%;
    }
    .card-stat {
      border: none;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .card-stat:hover {
      transform: translateY(-8px) scale(1.02);
    }
    .icon-box {
      font-size: 2.5rem;
      margin-right: 20px;
    }
    .stat-title {
      font-size: 15px;
      color: #666;
    }
    .stat-value {
      font-size: 1.8rem;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="dashboard-container">
  <h2 class="text-center mb-5 fw-bold text-white">📊 Statistik</h2>

  <div class="row g-4">
    <!-- Total Siswa -->
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card-stat d-flex align-items-center p-4">
        <div class="icon-box text-primary"><i class="bi bi-mortarboard-fill"></i></div>
        <div>
          <div class="stat-title">Siswa Aktif</div>
          <div class="stat-value"><?= $totalSiswa ?></div>
        </div>
      </div>
    </div>

    <!-- Total Guru -->
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card-stat d-flex align-items-center p-4">
        <div class="icon-box text-success"><i class="bi bi-person-badge-fill"></i></div>
        <div>
          <div class="stat-title">Guru Aktif</div>
          <div class="stat-value"><?= $totalGuru ?></div>
        </div>
      </div>
    </div>

    <!-- Total Relawan -->
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card-stat d-flex align-items-center p-4">
        <div class="icon-box text-warning"><i class="bi bi-people-fill"></i></div>
        <div>
          <div class="stat-title">Relawan Aktif</div>
          <div class="stat-value"><?= $totalRelawan ?></div>
        </div>
      </div>
    </div>

    <!-- Total Kelas -->
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card-stat d-flex align-items-center p-4">
        <div class="icon-box text-danger"><i class="bi bi-journal-bookmark-fill"></i></div>
        <div>
          <div class="stat-title">Kelas Aktif</div>
          <div class="stat-value"><?= $totalKelas ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
