<<<<<<< HEAD

=======
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
<?php
session_start();
require_once(__DIR__ . '/../config/mysql_db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../views/login.php?error=Akses ditolak");
    exit();
}

$id_pelajaran = isset($_GET['id_pelajaran']) ? intval($_GET['id_pelajaran']) : 0;

// Ambil data materi
$stmtMateri = $conn->prepare("SELECT * FROM materi WHERE ID_Pelajaran = ? ORDER BY Tanggal_Upload DESC");
if (!$stmtMateri) die("Query materi gagal: " . $conn->error);
$stmtMateri->bind_param("i", $id_pelajaran);
$stmtMateri->execute();
$resultMateri = $stmtMateri->get_result();

// Ambil data tugas
$stmtTugas = $conn->prepare("SELECT * FROM tugas WHERE ID_Pelajaran = ? ORDER BY Tanggal_Upload DESC");
if (!$stmtTugas) die("Query tugas gagal: " . $conn->error);
$stmtTugas->bind_param("i", $id_pelajaran);
$stmtTugas->execute();
$resultTugas = $stmtTugas->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<<<<<<< HEAD
    <meta charset="UTF-8" />
    <title>Materi & Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
=======
    <meta charset="UTF-8">
    <title>Materi & Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
</head>
<body>
<div class="container py-4">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <h3 class="mb-3">Upload Materi / Tugas</h3>
    <form action="../controller/upload_materi.php" method="post" enctype="multipart/form-data" class="mb-5">
        <input type="hidden" name="id_pelajaran" value="<?= $id_pelajaran ?>">
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label>File (PDF/DOCX)</label>
            <input type="file" name="file" class="form-control" accept=".pdf,.docx">
        </div>
        <div class="mb-3">
            <label>Jenis</label>
            <select name="jenis" class="form-control" required>
                <option value="materi">Materi</option>
                <option value="tugas">Tugas</option>
            </select>
        </div>
        <button type="submit" name="upload" class="btn btn-primary">Upload</button>
    </form>

<<<<<<< HEAD
    <h4 class="mb-3">📚 Daftar Materi</h4>
    <?php while ($m = $resultMateri->fetch_assoc()): ?>
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($m['Judul']) ?></h5>
=======
    <h4 class="mb-3">Daftar Materi</h4>
    <?php while ($m = $resultMateri->fetch_assoc()): ?>
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="detail_materi.php?id=<?= $m['ID_Materi'] ?>" class="text-decoration-none text-dark">
                        <?= htmlspecialchars($m['Judul']) ?>
                    </a>
                </h5>
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
                <h6 class="card-subtitle text-muted mb-2">
                    <?= !empty($m['Tanggal_Upload']) ? date('d M Y H:i', strtotime($m['Tanggal_Upload'])) : 'Tanggal tidak tersedia' ?>
                </h6>
                <p class="card-text"><?= nl2br(htmlspecialchars($m['Deskripsi'])) ?></p>
                <?php if (!empty($m['File'])): ?>
                    <a href="<?= htmlspecialchars($m['File']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">Lihat File</a>
<<<<<<< HEAD
=======

                    <?php 
                    $ext = strtolower(pathinfo($m['File'], PATHINFO_EXTENSION));
                    if ($ext === 'pdf'): ?>
                        <div class="mt-3">
                            <embed src="<?= htmlspecialchars($m['File']) ?>" type="application/pdf" width="100%" height="400px" />
                        </div>
                    <?php endif; ?>
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
                <?php endif; ?>
                <div class="mt-3">
                    <a href="edit_materi.php?id=<?= $m['ID_Materi'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="hapus_materi.php?id=<?= $m['ID_Materi'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus materi ini?')">Hapus</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>

<<<<<<< HEAD
    <h4 class="mt-5 mb-3">📝 Daftar Tugas</h4>
=======
    <h4 class="mt-5 mb-3"> Daftar Tugas</h4>
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
    <?php while ($t = $resultTugas->fetch_assoc()): ?>
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($t['Judul']) ?></h5>
                <h6 class="card-subtitle text-muted mb-2">
                    <?= !empty($t['Tanggal_Upload']) ? date('d M Y H:i', strtotime($t['Tanggal_Upload'])) : 'Tanggal tidak tersedia' ?>
                </h6>
                <p class="card-text"><?= nl2br(htmlspecialchars($t['Deskripsi'])) ?></p>
                <?php if (!empty($t['File'])): ?>
                    <a href="<?= htmlspecialchars($t['File']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">Lihat File</a>
                <?php endif; ?>
                <div class="mt-3">
<<<<<<< HEAD
                    <a href="edit_tugas.php?id=<?= $t['ID_Tugas'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="hapus_tugas.php?id=<?= $t['ID_Tugas'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus tugas ini?')">Hapus</a>
=======
                    <a href="detail_materi.php?id=<?= $m['ID_Materi'] ?>" class="btn btn-sm btn-info">Detail</a>
                    <a href="edit_materi.php?id=<?= $m['ID_Materi'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="hapus_materi.php?id=<?= $m['ID_Materi'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus materi ini?')">Hapus</a>
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
