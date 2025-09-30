<?php
session_start();
require_once(__DIR__ . '/../../config/mysql_db.php');
// Validasi ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idSiswa = intval($_GET['id']);
    // Hapus data siswa dari database
    $stmt = $conn->prepare("DELETE FROM siswa WHERE ID_Siswa = ?");
    $stmt->bind_param("i", $idSiswa);
    if ($stmt->execute()) {
        $_SESSION['flash_message'] = "Data berhasil dihapus.";
    } else {
        $_SESSION['flash_message'] = "Gagal menghapus data: " . $stmt->error;
    }
    $stmt->close();
} else {
    $_SESSION['flash_message'] = "ID tidak valid.";
}
$conn->close();
header("Location: ../../views/admin/data_siswa.php");
exit;
?>
