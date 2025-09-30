<?php
session_start();
require_once(__DIR__ . '/../../config/mysql_db.php');

// Cek login dan role guru
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header("Location: login.php?error=Akses ditolak");
    exit();
}

$id_materi = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("SELECT * FROM materi WHERE ID_Materi = ?");
if (!$stmt) die("Query gagal: " . $conn->error);

$stmt->bind_param("i", $id_materi);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Materi tidak ditemukan.");
}

$materi = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Materi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h3 class="mb-4">Detail Materi</h3>
    <table class="table table-bordered">
        <tr>
            <th>ID Materi</th>
            <td><?= htmlspecialchars($materi['ID_Materi']) ?></td>
        </tr>
        <tr>
            <th>ID Pelajaran</th>
            <td><?= htmlspecialchars($materi['ID_Pelajaran']) ?></td>
        </tr>
        <tr>
            <th>Judul</th>
            <td><?= htmlspecialchars($materi['Judul']) ?></td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td><?= nl2br(htmlspecialchars($materi['Deskripsi'])) ?></td>
        </tr>
        <tr>
            <th>Tanggal Upload</th>
            <td><?= date('d M Y H:i', strtotime($materi['Tanggal_Upload'])) ?></td>
        </tr>
        <tr>
            <th>File</th>
            <td>
                <?php if (!empty($materi['File'])): ?>
                    <?php if (pathinfo($materi['File'], PATHINFO_EXTENSION) === 'pdf'): ?>
                        <embed src="../<?= htmlspecialchars($materi['File']) ?>" type="application/pdf" width="100%" height="600px" />
                    <?php else: ?>
                        <a href="../<?= htmlspecialchars($materi['File']) ?>" class="btn btn-primary" download>Download File</a>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="text-muted">Tidak ada file</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <a href="materi_guru.php?id_pelajaran=<?= $materi['ID_Pelajaran'] ?>" class="btn btn-secondary">Kembali ke Daftar Materi</a>
</div>
</body>
</html>
