<?php
session_start();
require_once(__DIR__ . '/../config/mysql_db.php'); // Koneksi ke database
<<<<<<< HEAD

=======
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    // Validasi 
    if (empty($username) || empty($password)) {
        header("Location: ../views/login.php?error=" . urlencode("Username dan Password wajib diisi"));
        exit();
    }
    // Ambil data akun
    $stmt = $conn->prepare("SELECT * FROM akun WHERE UserName = ?");
    if (!$stmt) {
        die("Gagal menyiapkan statement akun: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $stmt->close();
        // Verifikasi 
        if (password_verify($password, $user['Password'])) {
            // Set session 
            $_SESSION['id_akun']  = $user['ID_Akun'];
            $_SESSION['username'] = $user['UserName'];
            $_SESSION['role']     = $user['Role'];
            $_SESSION['id_user']  = $user['ID_user'];
            switch ($user['Role']) {
                case 'admin':
                    header("Location: ../views/admin/dashboard_admin.php");
                    exit();
                case 'guru':
                    $stmt_guru = $conn->prepare("SELECT Nama FROM guru WHERE ID_Guru = ?");
                    if (!$stmt_guru) {
                        die("Gagal menyiapkan statement guru: " . $conn->error);
                    }
                    $stmt_guru->bind_param("i", $user['ID_user']);
                    $stmt_guru->execute();
                    $res_guru = $stmt_guru->get_result();
                    if ($res_guru->num_rows === 1) {
                        $data_guru = $res_guru->fetch_assoc();
                        $_SESSION['nama_guru'] = $data_guru['Nama'];
                        $stmt_guru->close();
                        // Ambil ID mapel 
                        $stmt_mapel = $conn->prepare("SELECT ID_pelajaran FROM kelas_mapel WHERE ID_Guru = ?");
                        if (!$stmt_mapel) {
                            die("Gagal menyiapkan statement mapel guru: " . $conn->error);
                        }
                        $stmt_mapel->bind_param("i", $user['ID_user']);
                        $stmt_mapel->execute();
                        $res_mapel = $stmt_mapel->get_result();
                        $mapel_ids = [];
                        while ($row = $res_mapel->fetch_assoc()) {
                            $mapel_ids[] = $row['ID_pelajaran'];
                        }
                        $_SESSION['mapel_ids'] = $mapel_ids;
                        $stmt_mapel->close();

<<<<<<< HEAD
    // Validasi input
    if (empty($username) || empty($password)) {
        header("Location: ../views/login.php?error=" . urlencode("Username dan Password wajib diisi"));
        exit();
    }

    // Ambil data user dari tabel akun
    $stmt = $conn->prepare("SELECT * FROM akun WHERE UserName = ?");
    if (!$stmt) {
        die("Gagal menyiapkan statement akun: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $stmt->close();

        // Verifikasi password
        if (password_verify($password, $user['Password'])) {
            // Set session dasar
            $_SESSION['id_akun']  = $user['ID_Akun'];
            $_SESSION['username'] = $user['UserName'];
            $_SESSION['role']     = $user['Role'];
            $_SESSION['id_user']  = $user['ID_user'];

            switch ($user['Role']) {
                case 'admin':
                    header("Location: ../views/admin.php");
                    exit();

                case 'guru':
                    $stmt_guru = $conn->prepare("SELECT Nama FROM guru WHERE ID_Guru = ?");
                    if (!$stmt_guru) {
                        die("Gagal menyiapkan statement guru: " . $conn->error);
                    }

                    $stmt_guru->bind_param("i", $user['ID_user']);
                    $stmt_guru->execute();
                    $res_guru = $stmt_guru->get_result();

                    if ($res_guru->num_rows === 1) {
                        $data_guru = $res_guru->fetch_assoc();
                        $_SESSION['nama_guru'] = $data_guru['Nama'];
                        $stmt_guru->close();

                        // Ambil ID mapel yang diajar
                        $stmt_mapel = $conn->prepare("SELECT ID_pelajaran FROM kelas_mapel WHERE ID_Guru = ?");
                        if (!$stmt_mapel) {
                            die("Gagal menyiapkan statement mapel guru: " . $conn->error);
                        }

                        $stmt_mapel->bind_param("i", $user['ID_user']);
                        $stmt_mapel->execute();
                        $res_mapel = $stmt_mapel->get_result();

                        $mapel_ids = [];
                        while ($row = $res_mapel->fetch_assoc()) {
                            $mapel_ids[] = $row['ID_pelajaran'];
                        }
                        $_SESSION['mapel_ids'] = $mapel_ids;
                        $stmt_mapel->close();

                        header("Location: ../views/guru.php");
                        exit();
                    } else {
                        header("Location: ../views/login.php?error=" . urlencode("Data guru tidak ditemukan"));
                        exit();
                    }

                case 'siswa':
                    $stmt_siswa = $conn->prepare("SELECT Nama, ID_Kelas FROM siswa WHERE ID_Siswa = ?");
                    if (!$stmt_siswa) {
                        die("Gagal menyiapkan statement siswa: " . $conn->error);
                    }

                    $stmt_siswa->bind_param("i", $user['ID_user']);
                    $stmt_siswa->execute();
                    $res_siswa = $stmt_siswa->get_result();

                    if ($res_siswa->num_rows === 1) {
                        $data_siswa = $res_siswa->fetch_assoc();
                        $_SESSION['nama_siswa'] = $data_siswa['Nama'];
                        $_SESSION['id_kelas']   = $data_siswa['ID_Kelas'];
                        $stmt_siswa->close();

                        // Ambil ID mapel berdasarkan kelas
                        $stmt_mapel = $conn->prepare("SELECT ID_pelajaran FROM kelas_mapel WHERE ID_Kelas = ?");
                        if (!$stmt_mapel) {
                            die("Gagal menyiapkan statement mapel siswa: " . $conn->error);
                        }

                        $stmt_mapel->bind_param("i", $data_siswa['ID_Kelas']);
                        $stmt_mapel->execute();
                        $res_mapel = $stmt_mapel->get_result();

                        $mapel_ids = [];
                        while ($row = $res_mapel->fetch_assoc()) {
                            $mapel_ids[] = $row['ID_pelajaran'];
                        }
                        $_SESSION['mapel_ids'] = $mapel_ids;
                        $stmt_mapel->close();

                        header("Location: ../views/siswa.php");
                        exit();
                    } else {
                        header("Location: ../views/login.php?error=" . urlencode("Data siswa tidak ditemukan"));
                        exit();
                    }

                default:
                    header("Location: ../views/login.php?error=" . urlencode("Role tidak dikenali"));
                    exit();
            }
        } else {
            header("Location: ../views/login.php?error=" . urlencode("Password salah"));
            exit();
        }
    } else {
        header("Location: ../views/login.php?error=" . urlencode("Username tidak ditemukan"));
        exit();
    }
} else {
    header("Location: ../views/login.php?error=" . urlencode("Akses tidak valid"));
    exit();
}
=======
                        header("Location: ../views/guru/dashboard_guru.php");
                        exit();
                    } else {
                        header("Location: ../login.php?error=" . urlencode("Data guru tidak ditemukan"));
                        exit();
                    }
                case 'siswa':
                    $stmt_siswa = $conn->prepare("SELECT Nama, ID_Kelas FROM siswa WHERE ID_Siswa = ?");
                    if (!$stmt_siswa) {
                        die("Gagal menyiapkan statement siswa: " . $conn->error);
                    }
                    $stmt_siswa->bind_param("i", $user['ID_user']);
                    $stmt_siswa->execute();
                    $res_siswa = $stmt_siswa->get_result();
                    if ($res_siswa->num_rows === 1) {
                        $data_siswa = $res_siswa->fetch_assoc();
                        $_SESSION['nama_siswa'] = $data_siswa['Nama'];
                        $_SESSION['id_kelas']   = $data_siswa['ID_Kelas'];
                        $stmt_siswa->close();

                        // Ambil ID mapel berdasarkan kelas
                        $stmt_mapel = $conn->prepare("SELECT ID_pelajaran FROM kelas_mapel WHERE ID_Kelas = ?");
                        if (!$stmt_mapel) {
                            die("Gagal menyiapkan statement mapel siswa: " . $conn->error);
                        }

                        $stmt_mapel->bind_param("i", $data_siswa['ID_Kelas']);
                        $stmt_mapel->execute();
                        $res_mapel = $stmt_mapel->get_result();

                        $mapel_ids = [];
                        while ($row = $res_mapel->fetch_assoc()) {
                            $mapel_ids[] = $row['ID_pelajaran'];
                        }
                        $_SESSION['mapel_ids'] = $mapel_ids;
                        $stmt_mapel->close();

                        header("Location: ../views/siswa/dashboard_siswa.php");
                        exit();
                    } else {
                        header("Location: ../login.php?error=" . urlencode("Data siswa tidak ditemukan"));
                        exit();
                    }

                default:
                    header("Location: ../login.php?error=" . urlencode("Role tidak dikenali"));
                    exit();
            }
        } else {
            header("Location: ../login.php?error=" . urlencode("Password salah"));
            exit();
        }
    } else {
        header("Location: ../login.php?error=" . urlencode("Username tidak ditemukan"));
        exit();
    }
} else {
    header("Location: ../login.php?error=" . urlencode("Akses tidak valid"));
    exit();
}
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
