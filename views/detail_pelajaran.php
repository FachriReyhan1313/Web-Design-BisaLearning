<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location:../login.php?error=Akses ditolak");
    exit;
}

require_once(__DIR__ . '/../config/mysql_db.php');

// Ambil ID Pelajaran dari URL
$id_pelajaran = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Detail pelajaran
$stmt = $conn->prepare("
    SELECT mp.Nama_Pelajaran, mp.Hari, mp.Jam, g.Nama AS Nama_Guru
    FROM mata_pelajaran mp
    LEFT JOIN guru g ON mp.ID_Guru = g.ID_Guru
    WHERE mp.ID_Pelajaran=?
");
$stmt->bind_param("i", $id_pelajaran);
$stmt->execute();
$pelajaran = $stmt->get_result()->fetch_assoc();

if (!$pelajaran) {
    echo "<h4>Pelajaran tidak ditemukan.</h4>";
    exit;
}

// Data materi
$stmtMateri = $conn->prepare("
    SELECT ID_Materi, Judul, Deskripsi, tipe_konten, file 
    FROM materi 
    WHERE ID_Pelajaran=?
");
$stmtMateri->bind_param("i", $id_pelajaran);
$stmtMateri->execute();
$materiResult = $stmtMateri->get_result();

// Data tugas
$stmtTugas = $conn->prepare("
    SELECT t.ID_Tugas, t.Deskripsi, m.Judul AS JudulMateri 
    FROM tugas t
    JOIN materi m ON t.ID_Materi = m.ID_Materi
    WHERE m.ID_Pelajaran = ?
");
$stmtTugas->bind_param("i", $id_pelajaran);
$stmtTugas->execute();
$tugasResult = $stmtTugas->get_result();

// Tentukan warna header berdasarkan nama pelajaran
$namaPelajaran = strtolower($pelajaran['Nama_Pelajaran']);
$headerColor = ($namaPelajaran == 'matematika') ? '#E44E4E' : '#dc3545';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($pelajaran['Nama_Pelajaran']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: Arial, sans-serif; animation: fadeIn 0.8s ease-in; }
    .subject-header { color: white; padding: 10px 15px; font-weight: bold; font-size: 1.3rem; border-radius: 5px 5px 0 0; animation: slideIn 0.6s ease-in-out; }
    .card { border: none; margin-bottom: 20px; }
    .chapter-title { font-weight: bold; font-size: 1rem; margin-bottom: 5px; }
    .chapter-date { font-size: 0.85rem; color: #888; margin-bottom: 10px; }
    .list-group-item { border: none; padding: 10px 15px; font-size: 0.95rem; display: flex; align-items: center; gap: 10px; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideIn { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
  </style>
</head>
<body>

<div class="container mt-3">
  <div class="subject-header" style="background: <?= $headerColor ?>;">
      <?= htmlspecialchars($pelajaran['Nama_Pelajaran']) ?>
  </div>

  <!-- ==== Bagian Materi ==== -->
  <h4 class="mt-4 mb-3">Materi</h4>
  <?php if ($materiResult->num_rows > 0): ?>
    <?php while ($m = $materiResult->fetch_assoc()): ?>
      <div class="card shadow-sm p-3">
        <div class="chapter-title"><?= htmlspecialchars($m['Judul']) ?></div>
        <div class="chapter-date">Guru: <?= htmlspecialchars($pelajaran['Nama_Guru']) ?> | Hari: <?= htmlspecialchars($pelajaran['Hari']) ?> <?= htmlspecialchars($pelajaran['Jam']) ?></div>
        <ul class="list-group">
          <li class="list-group-item">
            <i class="bi bi-file-earmark-text text-primary"></i> 
            <?= htmlspecialchars($m['Deskripsi']) ?>
          </li>
          <li class="list-group-item">
            <i class="bi bi-link-45deg text-success"></i> 
            <a href="../uploads/<?= htmlspecialchars($m['file']) ?>" target="_blank" class="text-decoration-none text-dark">
              Lihat File (<?= strtoupper($m['tipe_konten']) ?>)
            </a>
          </li>
        </ul>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="alert alert-warning mt-3">Belum ada materi untuk pelajaran ini.</div>
  <?php endif; ?>

  <!-- ==== Bagian Tugas ==== -->
  <h4 class="mt-5 mb-3">Tugas</h4>
  <?php if ($tugasResult->num_rows > 0): ?>
    <?php while ($t = $tugasResult->fetch_assoc()): ?>
      <div class="card shadow-sm p-3">
        <div class="chapter-title"><?= htmlspecialchars($t['JudulMateri']) ?> - Tugas</div>
        <p><?= nl2br(htmlspecialchars($t['Deskripsi'])) ?></p>
        <a href="tugas.php?id=<?= $t['ID_Tugas'] ?>" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-journal-check"></i> Kumpulkan Tugas
        </a>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="alert alert-secondary mt-3">Belum ada tugas untuk pelajaran ini.</div>
  <?php endif; ?>

  <a href="mata_pelajaran.php" class="btn btn-secondary mt-4">Kembali</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
