<?php
session_start();

// Cek apakah user sudah login dan role-nya adalah 'guru'
if (empty($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../login.php?error=Akses ditolak");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
            background: #f0f2f5;
        }

        #sidebar {
            width: 280px;
            background: linear-gradient(135deg, #5b86e5, #36d1dc);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px 20px;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 0 15px 15px 0;
            transition: background 0.4s ease;
        }

        #sidebar:hover {
            background: linear-gradient(135deg, #36d1dc, #5b86e5);
        }

        .profile-icon {
            font-size: 70px;
            text-align: center;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.85);
            text-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
        }

        .username {
            display: block;
            text-align: center;
            font-weight: 700;
            font-size: 1.6rem;
            margin-bottom: 25px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.25);
            user-select: text;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-line {
            width: 80%;
            height: 3px;
            background-color: rgba(255,255,255,0.3);
            margin: 0 auto 25px;
            border-radius: 5px;
            box-shadow: 0 0 8px rgba(255,255,255,0.5);
        }

        #sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        #sidebar ul li {
            margin-bottom: 18px;
        }

        #sidebar ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 600;
            padding: 10px 15px;
            border-radius: 12px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: inset 0 0 0 0 transparent;
        }

        #sidebar ul li a:hover {
            background-color: rgba(255, 255, 255, 0.25);
            box-shadow: inset 5px 0 0 0 #ffd43b;
            color: #ffd43b;
            text-shadow: 0 0 3px #ffd43b;
        }

        .logout {
            margin-top: auto;
        }

        .logout a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 0;
            background-color: #2a5298;
            color: white;
            font-weight: 700;
            border-radius: 15px;
            text-decoration: none;
            box-shadow: 0 6px 10px rgba(0, 123, 255, 0.6);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            font-size: 16px;
            user-select: none;
        }

        .logout a:hover {
            background-color: #74b9ff;
            box-shadow: 0 8px 14px rgba(232, 65, 24, 0.8);
            text-shadow: 0 0 6px #fff;
        }

        #main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #fff;
            overflow: hidden;
            height: 100vh;
            border-radius: 0 0 0 15px;
            box-shadow: inset 1px 0 8px rgba(0,0,0,0.05);
        }

        .topbar {
            background-color: #ffffff;
            padding: 12px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 8px rgba(0,0,0,0.1);
            flex-shrink: 0;
            user-select: none;
        }

        .topbar h1 {
            font-weight: 700;
            font-size: 1.5rem;
            color: #333;
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            color: #555;
            white-space: nowrap;
        }

        .user-info img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 6px rgba(0,0,0,0.15);
        }

        iframe {
            flex-grow: 1;
            border: none;
            width: 100%;
            height: calc(100vh - 56px); /* Tinggi topbar */
        }

        /* Responsive sidebar kecil */
        @media (max-width: 768px) {
            #sidebar {
                width: 70px;
                padding: 20px 10px;
                border-radius: 0;
            }

            .profile-icon, .username, .sidebar-line {
                display: none;
            }

            #sidebar ul li a {
                justify-content: center;
                padding: 10px 0;
                font-size: 20px;
            }

            #sidebar ul li a span {
                display: none;
            }

            .logout a {
                font-size: 14px;
                padding: 10px 0;
            }
        }
    </style>
</head>
<body>
    <nav id="sidebar" role="navigation" aria-label="Sidebar menu">
        <div>
            <div class="profile-icon" aria-label="Ikon profil guru">
                <i class="bi bi-person-gear"></i>
            </div>
            <span class="username" title="<?= htmlspecialchars($_SESSION['username']) ?>">
                <?= htmlspecialchars($_SESSION['username']) ?>
            </span>
            <div class="sidebar-line"></div>
            <ul>
                <li><a href="view_guru.php" target="main-frame"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a></li>
                <li><a href="mapel.php" target="main-frame"><i class="bi bi-book-half"></i> <span>Mata Pelajaran</span></a></li>
                <li><a href="nilai.php" target="main-frame"><i class="bi bi-journal-text"></i> <span>Nilai</span></a></li>
                <li><a href="kelas.php" target="main-frame"><i class="bi bi-building"></i> <span>Kelas</span></a></li>
                <li><a href="jadwal.php" target="main-frame"><i class="bi bi-calendar3-event"></i> <span>Jadwal</span></a></li>
            </ul>
        </div>
        <div class="logout">
            <a href="../controller/logout.php" title="Logout" aria-label="Logout">
                <i class="bi bi-box-arrow-right"></i> Log Out
            </a>
        </div>
    </nav>

    <main id="main" role="main">
        <header class="topbar">
            <h1>Selamat datang</h1>
            <div class="user-info" aria-label="Profil pengguna">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Foto Guru">
                <span><?= htmlspecialchars($_SESSION['username']) ?></span>
            </div>
        </header>

        <iframe name="main-frame" src="view.php" title="Konten utama dashboard guru"></iframe>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
