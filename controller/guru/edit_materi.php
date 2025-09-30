<?php
session_start();
require_once(__DIR__ . '/../config/mysql_db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../views/login.php?error=Akses ditolak");
    exit();
}
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : 'materi'; // mater/tugas, default materi
// Validasi jenis
if (!in_array($jenis, ['materi', 'tugas'])) {
    die("Jenis tidak valid");
}
$table = ($jenis === 'materi') ? 'materi' : 'tugas';
// Ambil data lama
$stmt = $conn->prepare("SELECT * FROM $table WHERE " . ($jenis === 'materi' ? "ID_Materi" : "ID_Tugas") . " = ?");
if (!$stmt) die("Prepare gagal: " . $conn->error);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Data tidak ditemukan");
}
$data = $result->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $judul = trim($_POST['judul']);
    $deskripsi = trim($_POST['deskripsi']);
    // Handle file baru
    $file_path = $data['File'];
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $allowed_ext = ['pdf', 'docx'];
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_ext)) {
            die("File harus berformat PDF atau DOCX.");
        }
        $upload_dir = __DIR__ . '/../uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        $new_file_name = uniqid() . "." . $file_ext;
        $destination = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $destination)) {
            // Hapus file lama jika ada
            if (!empty($file_path) && file_exists(__DIR__ . '/../' . $file_path)) {
                unlink(__DIR__ . '/../' . $file_path);
            }
            $file_path = 'uploads/' . $new_file_name;
        } else {
            die("Gagal mengupload file baru.");
        }
    }
    $stmt_update = $conn->prepare("UPDATE $table SET Judul = ?, Deskripsi = ?, File = ? WHERE " . ($jenis === 'materi' ? "ID_Materi" : "ID_Tugas") . " = ?");
    if (!$stmt_update) die("Prepare gagal update: " . $conn->error);
    $stmt_update->bind_param("sssi", $judul, $deskripsi, $file_path, $id);
    if ($stmt_update->execute()) {
        $stmt_update->close();
        header("Location: materi_guru.php?id_pelajaran=" . intval($data['ID_Pelajaran']) . "&success=Update berhasil");
        exit();
    } else {
        die("Gagal update data: " . $stmt_update->error);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Edit <?= ucfirst($jenis) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container py-4">
    <h3>Edit <?= ucfirst($jenis) ?></h3>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['Judul']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required><?= htmlspecialchars($data['Deskripsi']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>File saat ini</label><br>
            <?php if (!empty($data['File'])): ?>
                <a href="<?= htmlspecialchars($data['File']) ?>" target="_blank"><?= basename($data['File']) ?></a>
            <?php else: ?>
                <span>Tidak ada file</span>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>Ganti File (PDF/DOCX)</label>
            <input type="file" name="file" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti file</small>
        </div>
        <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
        <a href="materi_guru.php?id_pelajaran=<?= intval($data['ID_Pelajaran']) ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
