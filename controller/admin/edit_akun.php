<?php
require_once('../../config/mysql_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAkun = intval($_POST['id_akun']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if ($password === '') {
        // Jika password kosong, update username saja tanpa ubah password
        $stmt = $conn->prepare("UPDATE akun SET UserName = ? WHERE ID_Akun = ?");
        $stmt->bind_param("si", $username, $idAkun);
    } else {
        // Hash password baru
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Update username dan password
        $stmt = $conn->prepare("UPDATE akun SET UserName = ?, Password = ? WHERE ID_Akun = ?");
        $stmt->bind_param("ssi", $username, $hashedPassword, $idAkun);
    }

    if ($stmt->execute()) {
        header("Location: ../../views/admin/kelola_akun.php?success=Akun berhasil diperbarui");
        exit;
    } else {
        echo "Gagal memperbarui akun: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
