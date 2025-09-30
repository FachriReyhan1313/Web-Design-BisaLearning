<?php
session_start();
$errorMsg = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Learning App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">🔒 Password</label>
              <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password">
            </div>

            <div class="d-grid">
              <button type="submit" name="login" class="btn btn-primary">Masuk</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
