<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header("Location:../login.php?error=Akses ditolak");
    exit;
}

require_once(__DIR__ . '/../config/mysql_db.php');

$id_siswa = $_SESSION['id_user']; // ID siswa dari session login

// Ambil data siswa (menampilkan ID kelas langsung karena tabel kelas tidak punya nama kelas)
$sqlSiswa = "SELECT s.Nama, s.NISN, s.ID_Kelas AS Nama_Kelas
             FROM siswa s
             WHERE s.ID_Siswa = ?";
$stmtSiswa = $conn->prepare($sqlSiswa);
$stmtSiswa->bind_param("i", $id_siswa);
$stmtSiswa->execute();
$siswa = $stmtSiswa->get_result()->fetch_assoc();

// Ambil nilai siswa
$sqlNilai = "SELECT mp.Nama_Pelajaran, n.Nilai
             FROM nilai n
             JOIN jawaban_tugas jt ON n.ID_Jawaban = jt.ID_Jawaban
             JOIN tugas t ON jt.ID_Tugas = t.ID_Tugas
             JOIN materi m ON t.ID_Materi = m.ID_Materi
             JOIN mata_pelajaran mp ON m.ID_Pelajaran = mp.ID_Pelajaran
             WHERE jt.ID_Siswa = ?";
$stmtNilai = $conn->prepare($sqlNilai);
$stmtNilai->bind_param("i", $id_siswa);
$stmtNilai->execute();
$resultNilai = $stmtNilai->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Nilai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    @keyframes fadeIn { from{opacity:0; transform:translateY(10px);} to{opacity:1; transform:translateY(0);} }
    @keyframes fadeInDown { from{opacity:0; transform:translateY(-20px);} to{opacity:1; transform:translateY(0);} }
    body { font-family:Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
    .content { padding:30px; background:white; min-height:100vh; animation:fadeIn .5s ease-in-out; }
    .info-box { border:1px solid #ccc; padding:15px; border-radius:8px; margin-bottom:20px; background:white; animation:fadeInDown .5s ease-in-out; }
    .table th { background:#e2e0ff; }
    .btn-detail { background:#007bff; color:white; border:none; padding:8px 16px; border-radius:5px; margin-top:15px; }
    .btn-detail:hover { background:#0056b3; }
  </style>
</head>
<body>
  <div class="content">
    <h4><b>Nilai</b></h4>
    <div class="info-box">
      <p><b>NISN:</b> <?= htmlspecialchars($siswa['NISN']) ?></p>
      <p><b>Kelas:</b> <?= htmlspecialchars($siswa['Nama_Kelas']) ?></p>
    </div>

    <table class="table table-bordered">
      <thead>
        <tr><th>Mata Pelajaran</th><th>Nilai</th></tr>
      </thead>
      <tbody>
        <?php if ($resultNilai->num_rows > 0): ?>
            <?php while($row = $resultNilai->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['Nama_Pelajaran']) ?></td>
              <td><?= htmlspecialchars($row['Nilai']) ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="2" class="text-center">Belum ada nilai</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
    <button class="btn-detail" onclick="window.location.href='rekap_nilai.php'">Lihat Detail</button>
  </div>
</body>
</html>
