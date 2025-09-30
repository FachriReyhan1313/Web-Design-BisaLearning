<<<<<<< HEAD

=======
<?php
require_once(__DIR__ . '/../config/mysql_db.php');

// Cek apakah parameter ID dikirim
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idSiswa = $_GET['id'];

    // Siapkan statement SQL hapus
    $stmt = $conn->prepare("DELETE FROM siswa WHERE ID_Siswa = ?");
    $stmt->bind_param("i", $idSiswa);

    if ($stmt->execute()) {
        // mengembalikan data yang dihapus
        header("Location: ../views/data_siswa.php?success=Data berhasil dihapus");
        exit;
    } else {
        echo "Gagal menghapus data: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID tidak valid.";
}

$conn->close();
?>
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
