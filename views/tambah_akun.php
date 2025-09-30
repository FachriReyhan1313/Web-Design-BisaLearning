<?php
// Tangkap pesan sukses/error dari URL
$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Akun</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      font-family: 'Segoe UI', sans-serif;
    }
    .form-container {
      max-width: 500px;
      margin: 50px auto;
      padding: 30px;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
      animation: fadeInUp 0.6s ease;
    }

    .form-container h3 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: bold;
      color: #343a40;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h3><i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah Akun</h3>

    <?php if ($success): ?>
      <div class="alert alert-success">Akun berhasil ditambahkan.</div>
    <?php elseif (!empty($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="../controller/tambah_akun.php" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">👤 Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">🔒 Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
      </div>

      <div class="mb-3">
        <label for="ID_user" class="form-label">🆔 ID User</label>
        <input type="number" name="ID_user" id="ID_user" class="form-control" placeholder="Masukkan ID dari siswa/guru/relawan" required>
      </div>

      <div class="mb-3">
        <label for="role" class="form-label">🎓 Role</label>
        <select name="role" id="role" class="form-select" required>
          <option value="">-- Pilih Role --</option>
          <option value="admin">Admin</option>
          <option value="guru">Guru</option>
          <option value="siswa">Siswa</option>
          <option value="relawan">Relawan</option>
        </select>
      </div>

      <button type="submit" name="login" class="btn btn-primary w-100">
        <i class="bi bi-person-check-fill me-1"></i> Tambah Akun
      </button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
