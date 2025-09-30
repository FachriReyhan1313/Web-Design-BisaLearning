
<?php
require_once(__DIR__ . '/../config/mysql_db.php'); // pastikan file koneksi benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing
    $role     = $_POST['role'];
    $id_user  = $_POST['ID_user']; // <- ambil dari form

    // Cek koneksi aktif
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query insert termasuk ID_user
    $stmt = $conn->prepare("INSERT INTO akun (UserName, Password, ID_user, Role) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare statement gagal: " . $conn->error);
    }

    $stmt->bind_param("ssis", $username, $password, $id_user, $role); // s = string, i = integer

    if ($stmt->execute()) {
        header("Location: ../views/tambah_akun.php?success=1");
    } else {
        header("Location: ../views/tambah_akun.php?error=" . urlencode("Gagal menambahkan akun."));
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../views/tambah_akun.php");
}
?>

