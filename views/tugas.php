<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location:../login.php?error=Akses ditolak");
    exit;
}

require_once(__DIR__ . '/../config/mysql_db.php');

$id_tugas = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil detail tugas + materi + pelajaran
$sql = "SELECT t.ID_Tugas, t.Deskripsi AS DeskripsiTugas, m.Judul AS JudulMateri, 
               mp.Nama_Pelajaran, mp.ID_Pelajaran, g.Nama AS Nama_Guru
        FROM tugas t
        JOIN materi m ON t.ID_Materi = m.ID_Materi
        JOIN mata_pelajaran mp ON m.ID_Pelajaran = mp.ID_Pelajaran
        LEFT JOIN guru g ON mp.ID_Guru = g.ID_Guru
        WHERE t.ID_Tugas = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_tugas);
$stmt->execute();
$tugas = $stmt->get_result()->fetch_assoc();

if (!$tugas) {
    echo "<h4>Tugas tidak ditemukan.</h4>";
    exit;
}

// Upload file jawaban
$notif = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $id_siswa = $_SESSION['id_user'];
    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . '_' . basename($_FILES['file']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        $waktu = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO jawaban_tugas (Isi_Jawaban, FilePath, Waktu, ID_Tugas, ID_Siswa) 
                                VALUES (?, ?, ?, ?, ?)");
        $isiJawaban = "Upload file jawaban";
        $stmt->bind_param("sssii", $isiJawaban, $fileName, $waktu, $id_tugas, $id_siswa);

        if ($stmt->execute()) {
            $notif = '<div class="alert alert-success alert-dismissible fade show animate-fadein" role="alert">
                        <strong>Berhasil!</strong> Tugas berhasil dikumpulkan.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
        } else {
            $notif = '<div class="alert alert-danger alert-dismissible fade show animate-fadein" role="alert">
                        <strong>Gagal!</strong> Tidak bisa menyimpan ke database.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
        }
    } else {
        $notif = '<div class="alert alert-warning alert-dismissible fade show animate-fadein" role="alert">
                    <strong>Gagal upload!</strong> Periksa kembali file yang diunggah.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
    }
}

// Tentukan warna header berdasarkan nama pelajaran
$bgColor = (strtolower($tugas['Nama_Pelajaran']) == 'matematika') ? '#E44E4E' : '#dc3545';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pengumpulan Tugas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: Arial, sans-serif; }
    .card { animation: slideUp 0.8s ease-in-out; }
    .animate-fadein { animation: fadeIn 0.8s ease-in-out; }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
  </style>
</head>
<body>
<div class="container mt-3">
  <?= $notif ?>
  <div class="card shadow-sm">
    <div class="card-header text-white" style="background: <?= $bgColor ?>;">
        <?= htmlspecialchars($tugas['Nama_Pelajaran']) ?>
    </div>
    <div class="card-body">
      <h5 class="mb-3">Tugas - <?= htmlspecialchars($tugas['JudulMateri']) ?></h5>
      <p><?= nl2br(htmlspecialchars($tugas['DeskripsiTugas'])) ?></p>

      <h6 class="mt-4">Submit Tugas</h6>
      <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="formFile" class="form-label">Upload file</label>
          <input class="form-control" type="file" id="formFile" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="detail_pelajaran.php?id=<?= $tugas['ID_Pelajaran'] ?>" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
