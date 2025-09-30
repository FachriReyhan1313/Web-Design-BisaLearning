<?php
session_start();
$errorMsg = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<<<<<<< HEAD

=======
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Learning App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<<<<<<< HEAD
</head>
<body class="bg-light">

<div class="container">
  <div class="row min-vh-100 justify-content-center align-items-center">
    <div class="col-md-4">
      <div class="card shadow border-0">
        <div class="card-body p-4">
          <h3 class="text-center mb-4">🔐 Login</h3>

          <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-danger"><?= $errorMsg ?></div>
          <?php endif; ?>

          <form action="/LEARNING/controller/auth.php" method="POST">
            <div class="mb-3">
              <label for="username" class="form-label">👤 Username</label>
              <input type="text" class="form-control" id="username" name="username" required placeholder="Masukkan username">
=======
  <style>
    body {
      background: linear-gradient(135deg, #74ebd5, #acb6e5);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      animation: fadeInBody 1s ease-in-out;
    }

    @keyframes fadeInBody {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .card {
      animation: slideUpFade 0.8s ease-in-out;
      border-radius: 1rem;
    }

    @keyframes slideUpFade {
      from { transform: translateY(50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .form-control:focus {
      border-color: #6c5ce7;
      box-shadow: 0 0 10px rgba(108, 92, 231, 0.4);
      transition: 0.3s ease;
    }

    .btn-primary {
      background: linear-gradient(135deg, #6c5ce7, #341f97);
      border: none;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(108, 92, 231, 0.5);
    }

    .alert {
      animation: fadeInAlert 0.5s ease-in-out;
    }

    @keyframes fadeInAlert {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-lg">
        <div class="card-body p-4">
          <h3 class="text-center mb-4 fw-bold text-dark">🔐 Selamat Datang</h3>

          <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-danger text-center">
              <?= $errorMsg ?>
            </div>
          <?php endif; ?>

          <form action="../BisaLearning/controller/auth.php" method="POST">
            <div class="mb-3">
              <label for="username" class="form-label">👤 Username</label>
              <input type="text" class="form-control" id="username" name="username" required autofocus placeholder="Masukkan username">
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">🔒 Password</label>
              <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password">
            </div>

            <div class="d-grid">
<<<<<<< HEAD
              <button type="submit" name="login" class="btn btn-primary">Masuk</button>
            </div>
          </form>
=======
              <button type="submit" name="login" class="btn btn-primary btn-lg">
                Masuk
              </button>
            </div>
          </form>

          <div class="mt-4 text-center text-white-50 small">
            &copy; <?= date('Y') ?> Learning App. All rights reserved.
          </div>
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
