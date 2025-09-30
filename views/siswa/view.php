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
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f5f5;
    }
    .announcement-box {
      background-color: white;
      border-radius: 10px;
      padding: 15px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    .announcement-header {
      background-color: #eeeeee;
      padding: 10px;
      border-radius: 8px;
      font-weight: bold;
      display: flex;
      align-items: center;
    }
    .announcement-header i {
      font-size: 1.5rem;
      margin-right: 10px;
    }
    .icon {
      margin-right: 6px;
    }
    a {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container mt-4">
    <h3 class="text-center fw-bold mb-4">Selamat Datang</h3>

    <div class="announcement-header">
      <i class="bi bi-megaphone-fill"></i> PENGUMUMAN
    </div>

    <!-- Pengumuman 1 -->
    <div class="announcement-box mt-3">
      <p>📌 Hari Libur Nasional</p>
      <p>
        <i class="bi bi-calendar-event icon"></i>
        <strong>17 Agustus 2025</strong><br>
        <a>Memperingati Hari Kemerdekaan RI - Libur Sekolah</a><br>
        <i class="bi bi-geo-alt-fill icon"></i>
        Kegiatan upacara dilakukan hari sebelumnya pukul <strong>07.00 WIB</strong> di lapangan sekolah.
      </p>
    </div>
  </div>
</body>
</html>
