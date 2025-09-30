<?php
session_start();
require_once('../config/mysql_db.php');

// Cek session
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../login.php?error=Akses ditolak");
    exit;
}

$id_guru = $_SESSION['id_user'];

// Ambil data mapel dan kelas yang diajar guru ini
$sql = "SELECT p.ID_Pelajaran, p.Nama_Pelajaran, k.Nama_Kelas 
        FROM pelajaran p 
        JOIN kelas_mapel km ON km.ID_Mapel = p.ID_Pelajaran 
        JOIN kelas k ON k.ID_Kelas = km.ID_Kelas 
        WHERE p.ID_Guru = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) die("Query gagal: " . $conn->error);
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$result = $stmt->get_result();

$data_mapel = [];
while ($row = $result->fetch_assoc()) {
    $data_mapel[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Mata Pelajaran Guru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .mapel-card {
      background-color: #20c997;
      border-radius: 8px;
      padding: 16px;
      color: white;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 16px;
    }
    .mapel-title {
      font-weight: bold;
      font-size: 18px;
    }
    .kelas-title {
      font-size: 14px;
      opacity: 0.8;
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Mata Pelajaran</h4>
    <span class="badge bg-success rounded-pill">👨‍🏫 Guru</span>
  </div>

  <?php if (count($data_mapel) > 0): ?>
    <div class="row">
      <?php foreach ($data_mapel as $mapel): ?>
        <div class="col-md-6">
          <div class="mapel-card">
            <div class="mapel-title"><?= htmlspecialchars($mapel['Nama_Pelajaran']) ?></div>
            <div class="kelas-title">Kelas <?= htmlspecialchars($mapel['Nama_Kelas']) ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">Belum ada mata pelajaran yang Anda ajar.</div>
  <?php endif; ?>
</div>
</body>
</html>
