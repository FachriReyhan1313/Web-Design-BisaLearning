<?php
require_once('../../config/mysql_db.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idAkun = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM akun WHERE ID_Akun = ?");
    $stmt->bind_param("i", $idAkun);

    if ($stmt->execute()) {
        header("Location: ../../views/admin/kelola_akun.php?success=Akun berhasil dihapus");
    } else {
        echo "Gagal menghapus akun: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "ID tidak valid.";
}
$conn->close();
?>
