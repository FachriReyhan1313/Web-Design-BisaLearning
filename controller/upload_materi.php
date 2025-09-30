<?php
session_start();
require_once(__DIR__ . '/../config/mysql_db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../views/login.php?error=Akses ditolak");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    $id_pelajaran = intval($_POST['id_pelajaran']);
    $judul = trim($_POST['judul']);
    $deskripsi = trim($_POST['deskripsi']);
    $jenis = $_POST['jenis']; // "materi" atau "tugas"

    if (!in_array($jenis, ['materi', 'tugas'])) {
        die("Jenis tidak valid.");
    }

    // Handle upload file
    $file_path = null;
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $allowed_ext = ['pdf', 'docx'];
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_ext)) {
            die("File harus berformat PDF atau DOCX.");
        }

        $upload_dir = __DIR__ . '/../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $new_file_name = uniqid() . "." . $file_ext;
        $destination = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $destination)) {
            $file_path = 'uploads/' . $new_file_name; // path relatif untuk akses web
        } else {
            die("Gagal mengupload file.");
        }
    }

    $tanggal_upload = date('Y-m-d H:i:s');

    if ($jenis === 'materi') {
        $stmt = $conn->prepare("INSERT INTO materi (ID_Pelajaran, judul, deskripsi, file, tanggal_upload) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) die("Prepare gagal (materi): " . $conn->error);
        $stmt->bind_param("issss", $id_pelajaran, $judul, $deskripsi, $file_path, $tanggal_upload);
    } else {
        $stmt = $conn->prepare("INSERT INTO tugas (ID_Pelajaran, judul, deskripsi, file, tanggal_upload) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) die("Prepare gagal (tugas): " . $conn->error);
        $stmt->bind_param("issss", $id_pelajaran, $judul, $deskripsi, $file_path, $tanggal_upload);
    }

    if ($stmt->execute()) {
        $stmt->close();
        // Redirect ke halaman materi_guru.php di folder views setelah upload sukses
        header("Location: ../views/materi_guru.php?id_pelajaran=$id_pelajaran&success=Upload berhasil");
        exit();
    } else {
        die("Gagal menyimpan data: " . $stmt->error);
    }
} else {
    header("Location: ../views/materi_guru.php?id_pelajaran=" . ($_POST['id_pelajaran'] ?? 0));
    exit();
}
?>
