<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location:../login.php?error=Akses ditolak");
    exit;
}

require_once(__DIR__ . '/../config/mysql_db.php');

// Ambil data pelajaran + guru
$sql = "SELECT mp.ID_Pelajaran, mp.Nama_Pelajaran, mp.Hari, mp.Jam, g.Nama AS Nama_Guru 
        FROM mata_pelajaran mp 
        LEFT JOIN guru g ON mp.ID_Guru = g.ID_Guru
        ORDER BY mp.Nama_Pelajaran ASC";
$result = $conn->query($sql);
if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Mata Pelajaran</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { 
        background: #f8f9fa; 
        font-family: Arial, sans-serif; 
    }
    .judul-mata-pelajaran {
        background: #E44E4E; /* merah lebih muda */
        color: #fff;
    }
    .subject-card {
        border-radius: 12px;
        height: 180px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .subject-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .subject-title {
        color: #000;
        text-decoration: none;
        font-weight: bold;
    }
    .subject-desc {
        font-size: 0.9rem;
        color: #555;
        text-align: center;
        margin-top: 5px;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up { 
        animation: fadeInUp 0.8s ease-in-out; 
    }
  </style>
</head>
<body>

<div class="container mt-4 fade-in-up">
  <h4 class="p-3 rounded judul-mata-pelajaran">Mata Pelajaran</h4>
  <input type="text" class="form-control my-3" placeholder="Search...">

  <div class="row g-4">
    <?php while ($row = $result->fetch_assoc()): ?>
      <?php 
        $namaPelajaran = strtolower($row['Nama_Pelajaran']);

        // Tentukan ikon dan warna background berdasarkan nama pelajaran
        if ($namaPelajaran == 'bahasa indonesia') {
            $icon = '<i class="bi bi-journal-text fs-1 text-primary"></i>';
            $bgColor = '#D1F2EB'; // hijau muda
        } elseif ($namaPelajaran == 'matematika') {
            $icon = '<i class="bi bi-calculator fs-1 text-success"></i>';
            $bgColor = '#FADBD8'; // merah muda
        } else {
            $icon = '<i class="bi bi-book fs-1 text-secondary"></i>';
            $bgColor = '#d2f0ec'; // default
        }
      ?>
      <div class="col-md-4 col-sm-6">
        <div class="subject-card shadow-sm text-center p-3" style="background: <?= $bgColor ?>;">
          <?= $icon ?>
          <a href="detail_pelajaran.php?id=<?= $row['ID_Pelajaran'] ?>" 
             class="mt-3 h5 subject-title d-block">
            <?= htmlspecialchars($row['Nama_Pelajaran']) ?>
          </a>
          <div class="subject-desc">
            <div><?= htmlspecialchars($row['Hari']) ?> | <?= htmlspecialchars($row['Jam']) ?></div>
            <div>Guru: <?= htmlspecialchars($row['Nama_Guru'] ?? '-') ?></div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
