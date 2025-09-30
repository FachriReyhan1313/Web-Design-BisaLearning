<?php
session_start();
<<<<<<< HEAD
session_unset(); // hapus semua session
session_destroy(); // hancurkan session
header("Location: ../login.php");
exit();
=======
// Bersihkan semua session
$_SESSION = [];
// Hapus cookie session jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Hancurkan session
session_destroy();
// Redirect ke halaman login
header("Location: ../login.php");
exit;
?>
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
