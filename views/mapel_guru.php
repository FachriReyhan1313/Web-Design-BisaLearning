<?php
session_start();
require_once(__DIR__ . '/../config/mysql_db.php');

// Cek login dan role guru
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../views/login.php?error=Akses ditolak");
    exit();
}

$id_guru = $_SESSION['id_user'];

// Query tambah p.ID_Pelajaran supaya bisa buat link
$query = "SELECT p.ID_Pelajaran, p.Nama_Pelajaran, p.Hari, p.Jam 
    FROM kelas_mapel km
    JOIN mata_pelajaran p ON km.ID_Pelajaran = p.ID_Pelajaran
    WHERE km.ID_Guru = ?";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $id_guru);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-mapel {
            background-color: #0984e3;
            border-left: 5px solid #74b9ff;
            border-radius: 0.5rem;
            color: white;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .card-mapel h5 {
            margin: 0;
            font-weight: bold;
        }
        .card-mapel small {
            font-size: 0.95rem;
        }
        .card-mapel a {
            color: white;
            text-decoration: underline;
        }
        .card-mapel a:hover {
            color: #dfe6e9;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <h3 class="mb-4">Mata Pelajaran yang Diampu</h3>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card-mapel shadow-sm">
                    <h5>
                      <a href="materi_guru.php?id_pelajaran=<?= urlencode($row['ID_Pelajaran']) ?>">
                        <?= htmlspecialchars($row['Nama_Pelajaran']) ?>
                      </a>
                    </h5>
                    <small><?= htmlspecialchars($row['Hari']) ?> - <?= htmlspecialchars($row['Jam']) ?></small>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning">Belum ada mata pelajaran yang diampu.</div>
        <?php endif; ?>
    </div>
</body>
</html>
