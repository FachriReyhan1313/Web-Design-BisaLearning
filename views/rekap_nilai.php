<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header("Location:../login.php?error=Akses ditolak");
    exit;
}

require_once(__DIR__ . '/../config/mysql_db.php');

$id_siswa = $_SESSION['id_user'];
$id_pelajaran = isset($_GET['id_pelajaran']) ? (int)$_GET['id_pelajaran'] : 0;

// Data siswa
$stmtSiswa = $conn->prepare("SELECT Nama, NISN FROM siswa WHERE ID_Siswa = ?");
$stmtSiswa->bind_param("i", $id_siswa);
$stmtSiswa->execute();
$siswa = $stmtSiswa->get_result()->fetch_assoc();

// Data pelajaran & guru
$stmtPelajaran = $conn->prepare("SELECT mp.Nama_Pelajaran, g.Nama AS Guru 
                                FROM mata_pelajaran mp 
                                LEFT JOIN guru g ON mp.ID_Guru = g.ID_Guru 
                                WHERE mp.ID_Pelajaran = ?");
$stmtPelajaran->bind_param("i", $id_pelajaran);
$stmtPelajaran->execute();
$pelajaran = $stmtPelajaran->get_result()->fetch_assoc();

// Detail nilai
$sql = "SELECT t.Deskripsi, n.Nilai 
        FROM nilai n
        JOIN jawaban_tugas jt ON n.ID_Jawaban = jt.ID_Jawaban
        JOIN tugas t ON jt.ID_Tugas = t.ID_Tugas
        JOIN materi m ON t.ID_Materi = m.ID_Materi
        WHERE jt.ID_Siswa = ? AND m.ID_Pelajaran = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_siswa, $id_pelajaran);
$stmt->execute();
$nilai = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rekap Nilai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin:0; padding:0; }
    .content { padding:30px; background:white; min-height:100vh; animation:fadeIn 0.5s ease-in-out; }
    .info-box { border:1px solid #ccc; padding:15px; border-radius:8px; margin-bottom:20px; background:white; animation:fadeInDown 0.5s ease-in-out; }
    .table th { background:#e2e0ff; }
    @keyframes fadeIn { from{opacity:0;transform:translateY(10px);} to{opacity:1;transform:translateY(0);} }
    @keyframes fadeInDown { from{opacity:0;transform:translateY(-20px);} to{opacity:1;transform:translateY(0);} }
  </style>
</head>
<body>
  <div class="content">
    <h4><b>Rekap Nilai Semester Aktif</b></h4>
    <div class="info-box">
      <p><b>NISN:</b> <?= htmlspecialchars($siswa['NISN']) ?></p>
      <p><b>Mata Pelajaran:</b> <?= htmlspecialchars($pelajaran['Nama_Pelajaran'] ?? '-') ?></p>
      <p><b>Guru:</b> <?= htmlspecialchars($pelajaran['Guru'] ?? '-') ?></p>
    </div>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Detail</th>
          <th>Nilai</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($nilai->num_rows > 0): ?>
            <?php while($row = $nilai->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['Deskripsi']) ?></td>
              <td><?= htmlspecialchars($row['Nilai']) ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="2" class="text-center">Belum ada nilai</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
