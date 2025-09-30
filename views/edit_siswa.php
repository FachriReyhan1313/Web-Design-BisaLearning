<?php
require_once(__DIR__ . '/../config/mysql_db.php');

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM siswa WHERE ID_Siswa = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Data siswa tidak ditemukan.";
    exit;
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Siswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
  <div class="container p-4">
    <h4 class="mb-4">✏️ Edit Data Siswa</h4>
    <form action="../controller/update_siswa.php" method="POST">
      <input type="hidden" name="id" value="<?= $data['ID_Siswa'] ?>">

      <div class="row mb-3">
        <div class="col">
          <label for="nama" class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" value="<?= $data['Nama'] ?>" required>
        </div>
        <div class="col">
          <label for="nisn" class="form-label">NISN</label>
          <input type="text" name="nisn" class="form-control" value="<?= $data['NISN'] ?>" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col">
          <label for="nik" class="form-label">NIK</label>
          <input type="text" name="nik" class="form-control" value="<?= $data['NIK'] ?>" required>
        </div>
        <div class="col">
          <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
          <input type="text" name="tempat_lahir" class="form-control" value="<?= $data['Tempat_Lahir'] ?>" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control" value="<?= $data['Tanggal_Lahir'] ?>" required>
      </div>

      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <input type="text" name="alamat" class="form-control" value="<?= $data['Alamat'] ?>" required>
      </div>

      <div class="row mb-3">
        <div class="col">
          <label for="ayah" class="form-label">Nama Ayah</label>
          <input type="text" name="ayah" class="form-control" value="<?= $data['Nama_Ayah'] ?>" required>
        </div>
        <div class="col">
          <label for="ibu" class="form-label">Nama Ibu</label>
          <input type="text" name="ibu" class="form-control" value="<?= $data['Nama_Ibu'] ?>" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col">
          <label for="pekerjaan" class="form-label">Pekerjaan</label>
          <input type="text" name="pekerjaan" class="form-control" value="<?= $data['Pekerjaan'] ?>" required>
        </div>
        <div class="col">
          <label for="no_tlp" class="form-label">No. Telepon</label>
          <input type="text" name="no_tlp" class="form-control" value="<?= $data['No_Tlp'] ?>" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="id_kelas" class="form-label">ID Kelas</label>
        <input type="number" name="id_kelas" class="form-control" value="<?= $data['ID_Kelas'] ?>" required>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-save me-1"></i> Simpan Perubahan
        </button>
        <a href="data_siswa.php" class="btn btn-secondary">Kembali</a>
      </div>
    </form>
  </div>
</body>
</html>
