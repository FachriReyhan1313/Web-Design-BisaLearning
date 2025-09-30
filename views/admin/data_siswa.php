<?php
session_start();
require_once(__DIR__ . '/../../config/mysql_db.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Siswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h4 class="mb-4">📋 Data Siswa</h4>

    <?php if (isset($_SESSION['flash_message'])): ?>
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['flash_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

    <a href="tambah_siswa.php" class="btn btn-primary mb-3">
      <i class="bi bi-plus-circle"></i> Tambah Siswa
    </a>

    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NISN</th>
            <th>NIK</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>Nama Ayah</th>
            <th>Nama Ibu</th>
            <th>Pekerjaan</th>
            <th>No. Tlp</th>
            <th>ID Kelas</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT * FROM siswa ORDER BY ID_Siswa ASC";
          $result = $conn->query($query);
          $no = 1;

          if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
          ?>
              <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['Nama']); ?></td>
                <td><?= htmlspecialchars($row['NISN']); ?></td>
                <td><?= htmlspecialchars($row['NIK']); ?></td>
                <td><?= htmlspecialchars($row['Tempat_Lahir']); ?></td>
                <td><?= htmlspecialchars($row['Tanggal_Lahir']); ?></td>
                <td><?= htmlspecialchars($row['Alamat']); ?></td>
                <td><?= htmlspecialchars($row['Nama_Ayah']); ?></td>
                <td><?= htmlspecialchars($row['Nama_Ibu']); ?></td>
                <td><?= htmlspecialchars($row['Pekerjaan']); ?></td>
                <td><?= htmlspecialchars($row['No_Tlp']); ?></td>
                <td class="text-center"><?= htmlspecialchars($row['ID_Kelas']); ?></td>
                <td class="text-center">
                  <a href="edit_siswa.php?id=<?= $row['ID_Siswa']; ?>" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <button type="button" 
                          class="btn btn-sm btn-danger btn-delete" 
                          data-id="<?= $row['ID_Siswa']; ?>" 
                          data-nama="<?= htmlspecialchars($row['Nama']); ?>" 
                          data-bs-toggle="modal" 
                          data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i>
                  </button>
                </td>
              </tr>
          <?php
            endwhile;
          else:
          ?>
            <tr>
              <td colspan="13" class="text-center">Tidak ada data siswa.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Konfirmasi Hapus -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus data siswa <strong id="modalNamaSiswa"></strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Hapus</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS & Script Modal -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const deleteModal = document.getElementById('deleteModal');
    const modalNamaSiswa = document.getElementById('modalNamaSiswa');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    deleteModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const siswaId = button.getAttribute('data-id');
      const siswaNama = button.getAttribute('data-nama');

      // Tampilkan nama siswa di modal
      modalNamaSiswa.textContent = siswaNama;

      // Set link hapus di tombol konfirmasi
      confirmDeleteBtn.href = "../../controller/admin/hapus.php?id=" + siswaId;
    });
  </script>
</body>
</html>
