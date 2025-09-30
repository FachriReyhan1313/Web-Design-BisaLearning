<?php
require_once(__DIR__ . '/../config/mysql_db.php'); // koneksi ke DB

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .card {
      border: none;
      border-radius: 15px;
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .icon-box {
      font-size: 2rem;
      margin-right: 15px;
    }
    .stat-title {
      font-size: 14px;
      color: #888;
    }
  </style>
</head>
<body>
  <div class="container mt-4">
    <h4 class="mb-4">📊 Ringkasan Data</h4>
    <div class="row g-3">
      <!-- Total Siswa -->
      <div class="col-md-6 col-lg-3">
        <div class="card p-3 d-flex flex-row align-items-center shadow-sm">
          <div class="icon-box text-primary"><i class="bi bi-mortarboard-fill"></i></div>
          <div>
            <div class="stat-title">Siswa Aktif</div>
            <div class="fw-bold"><?= $totalSiswa ?></div>
          </div>
        </div>
      </div>

      <!-- Total Guru -->
      <div class="col-md-6 col-lg-3">
        <div class="card p-3 d-flex flex-row align-items-center shadow-sm">
          <div class="icon-box text-success"><i class="bi bi-person-fill"></i></div>
          <div>
            <div class="stat-title">Guru Aktif</div>
            <div class="fw-bold"><?= $totalGuru ?></div>
          </div>
        </div>
      </div>

      <!-- Total Relawan -->
      <div class="col-md-6 col-lg-3">
        <div class="card p-3 d-flex flex-row align-items-center shadow-sm">
          <div class="icon-box text-warning"><i class="bi bi-people-fill"></i></div>
          <div>
            <div class="stat-title">Relawan Aktif</div>
            <div class="fw-bold"><?= $totalRelawan ?></div>
          </div>
        </div>
      </div>

      <!-- Total Kelas -->
      <div class="col-md-6 col-lg-3">
        <div class="card p-3 d-flex flex-row align-items-center shadow-sm">
          <div class="icon-box text-danger"><i class="bi bi-calendar-week-fill"></i></div>
          <div>
            <div class="stat-title">Kelas Aktif</div>
            <div class="fw-bold"><?= $totalKelas ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
