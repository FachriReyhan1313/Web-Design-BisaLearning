<?php
require_once(__DIR__ . '/../../config/mysql_db.php'); // Koneksi DB
$akunResult = $conn->query("SELECT * FROM akun ORDER BY ID_Akun ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>⚙️ Kelola Akun</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h4 {
      font-weight: 700;
      color: #343a40;
    }
    table {
      background: white;
      box-shadow: 0 0 10px rgb(0 0 0 / 0.1);
      border-radius: 8px;
      overflow: hidden;
    }
    thead th {
      background: #343a40;
      color: white;
      font-weight: 600;
      text-align: center;
    }
    tbody td {
      vertical-align: middle !important;
    }
    .btn-warning {
      color: #212529;
      font-weight: 600;
    }
    .btn-danger {
      font-weight: 600;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h4 class="mb-4">⚙️ Kelola Akun</h4>

  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= htmlspecialchars($_GET['success']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <table class="table table-bordered table-striped align-middle">
    <thead>
      <tr>
        <th>ID Akun</th>
        <th>Username</th>
        <th>Role</th>
        <th class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($akunResult->num_rows > 0): ?>
        <?php while ($row = $akunResult->fetch_assoc()): ?>
          <tr>
            <td class="text-center"><?= $row['ID_Akun']; ?></td>
            <td><?= htmlspecialchars($row['UserName']); ?></td>
            <td class="text-center"><?= htmlspecialchars($row['Role']); ?></td>
            <td class="text-center">
              <button 
                class="btn btn-sm btn-warning" 
                data-bs-toggle="modal" 
                data-bs-target="#editModal"
                data-id="<?= $row['ID_Akun']; ?>"
                data-username="<?= htmlspecialchars($row['UserName']); ?>"
                data-role="<?= htmlspecialchars($row['Role']); ?>"
              >
                <i class="bi bi-pencil-square"></i>
              </button>
              <a 
                href="../../controller/admin/hapus_akun.php?id=<?= $row['ID_Akun']; ?>" 
                class="btn btn-sm btn-danger"
                onclick="return confirm('Yakin ingin menghapus akun ini?')"
                title="Hapus Akun"
              >
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" class="text-center text-muted fst-italic">Tidak ada data akun.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<!-- Modal Edit Akun -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="../../controller/admin/edit_akun.php" method="POST" class="modal-content needs-validation" novalidate>
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Akun</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_akun" id="edit-id" />
        <div class="mb-3">
          <label for="edit-username" class="form-label">Username</label>
          <input type="text" name="username" id="edit-username" class="form-control" required minlength="3" />
          <div class="invalid-feedback">Username wajib diisi dan minimal 3 karakter.</div>
        </div>
        <div class="mb-3">
          <label for="edit-password" class="form-label">Password <small class="text-muted">(Isi jika ingin mengganti)</small></label>
          <input type="password" name="password" id="edit-password" class="form-control" minlength="6" />
          <div class="invalid-feedback">Password minimal 6 karakter jika diisi.</div>
        </div>
        <div class="mb-3">
          <label for="edit-role" class="form-label">Role</label>
          <select name="role" id="edit-role" class="form-select" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="siswa">Siswa</option>
            <option value="pendidik">Pendidik</option>
          </select>
          <div class="invalid-feedback">Role wajib dipilih.</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const editModal = document.getElementById('editModal');
  editModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const username = button.getAttribute('data-username');
    const role = button.getAttribute('data-role');

    document.getElementById('edit-id').value = id;
    document.getElementById('edit-username').value = username;
    document.getElementById('edit-password').value = ''; 
    document.getElementById('edit-role').value = role;
  });

  // Bootstrap validation form
  (() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
  })()
</script>
</body>
</html>
