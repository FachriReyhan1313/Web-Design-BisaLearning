<?php
// Koneksi Database
require_once('../../config/mysql_db.php'); // Pastikan path ini sesuai struktur folder Anda

// Ambil Total Guru
$resultGuru = $conn->query("SELECT COUNT(*) AS total FROM guru");
$totalGuru = $resultGuru->fetch_assoc()['total'] ?? 0;

// Ambil Total Relawan
$resultRelawan = $conn->query("SELECT COUNT(*) AS total FROM relawan");
$totalRelawan = $resultRelawan->fetch_assoc()['total'] ?? 0;

// Ambil Data Guru per Mata Pelajaran
$dataGuruBidang = [];
$result = $conn->query("
    SELECT mp.Nama_Pelajaran, COUNT(*) AS jumlah
    FROM guru g
    JOIN mata_pelajaran mp ON g.ID_Guru = mp.ID_Guru
    GROUP BY mp.Nama_Pelajaran
");
while ($row = $result->fetch_assoc()) {
    $dataGuruBidang[$row['Nama_Pelajaran']] = $row['jumlah'];
}

// Ambil Data Relawan per Mata Pelajaran
$dataRelawanBidang = [];
$result = $conn->query("
    SELECT mp.Nama_Pelajaran, COUNT(*) AS jumlah
    FROM relawan r
    JOIN mata_pelajaran mp ON r.ID_Pelajaran = mp.ID_Pelajaran
    GROUP BY mp.Nama_Pelajaran
");
while ($row = $result->fetch_assoc()) {
    $dataRelawanBidang[$row['Nama_Pelajaran']] = $row['jumlah'];
}

// Gabungkan Bidang Unik
$allBidang = array_unique(array_merge(array_keys($dataGuruBidang), array_keys($dataRelawanBidang)));

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Statistik Guru & Relawan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background: linear-gradient(to right, #a18cd1, #fbc2eb);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .card {
      border-radius: 1rem;
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      transition: transform 0.2s;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .fun-title {
      font-family: 'Comic Sans MS', cursive, sans-serif;
      color: #2d3436;
    }

    .chart-container {
      width: 100%;
      height: 300px;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card text-center p-4">
        <h4>👩‍🏫 Total Guru</h4>
        <h1 class="text-primary"><?= $totalGuru; ?></h1>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card text-center p-4">
        <h4>🤝 Total Relawan</h4>
        <h1 class="text-success"><?= $totalRelawan; ?></h1>
      </div>
    </div>
  </div>

  <div class="row mt-5 g-4">
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">Perbandingan Guru & Relawan</h5>
        <div class="chart-container">
          <canvas id="donutChart"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3">
        <h5 class="text-center">Jumlah per Mata Pelajaran</h5>
        <div class="chart-container">
          <canvas id="barChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const donutCtx = document.getElementById('donutChart').getContext('2d');
  new Chart(donutCtx, {
    type: 'doughnut',
    data: {
      labels: ['Guru', 'Relawan'],
      datasets: [{
        data: [<?= $totalGuru; ?>, <?= $totalRelawan; ?>],
        backgroundColor: ['#74b9ff', '#55efc4'],
        hoverOffset: 10
      }]
    },
    options: {
      plugins: { legend: { position: 'bottom' } }
    }
  });

  const barCtx = document.getElementById('barChart').getContext('2d');
  new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_values($allBidang)); ?>,
      datasets: [
        {
          label: 'Guru',
          data: <?= json_encode(array_map(function($b) use ($dataGuruBidang) { return $dataGuruBidang[$b] ?? 0; }, $allBidang)); ?>,
          backgroundColor: '#0984e3'
        },
        {
          label: 'Relawan',
          data: <?= json_encode(array_map(function($b) use ($dataRelawanBidang) { return $dataRelawanBidang[$b] ?? 0; }, $allBidang)); ?>,
          backgroundColor: '#00b894'
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      },
      plugins: { legend: { position: 'top' } }
    }
  });
</script>

</body>
</html>
