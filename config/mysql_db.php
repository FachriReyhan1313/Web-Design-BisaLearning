<?php
<<<<<<< HEAD
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'bisalearn'; // ganti sesuai nama database kamu

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
=======
$host = 'localhost';  // atau 'localhost'
$user = 'root';
$pass = '';            // kosongkan jika MySQL belum ada password
$dbname = 'BisaLearning'; // pastikan database ini sudah ada di phpMyAdmin

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika berhasil
// echo "Koneksi berhasil";
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
?>

