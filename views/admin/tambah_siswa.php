<?php
require_once(__DIR__ . '/../../config/mysql_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama         = $_POST['nama'];
    $nisn         = $_POST['nisn'];
    $nik          = $_POST['nik'];
    $tempat       = $_POST['tempat_lahir'];
    $tanggal      = $_POST['tanggal_lahir'];
    $alamat       = $_POST['alamat'];
    $ayah         = $_POST['nama_ayah'];
    $ibu          = $_POST['nama_ibu'];
    $pekerjaan    = $_POST['pekerjaan'];
    $tlp          = $_POST['no_tlp'];
    $id_kelas     = $_POST['id_kelas'];

    $stmt = $conn->prepare("INSERT INTO siswa (Nama, NISN, NIK, Tempat_Lahir, Tanggal_Lahir, Alamat, Nama_Ayah, Nama_Ibu, Pekerjaan, No_Tlp, ID_Kelas)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssi", $nama, $nisn, $nik, $tempat, $tanggal, $alamat, $ayah, $ibu, $pekerjaan, $tlp, $id_kelas);

    if ($stmt->execute()) {
        header("Location: Data_siswa.php?success=Data berhasil ditambahkan");
        exit;
    } else {
        echo "Gagal menambahkan data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Siswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h4 class="mb-4">➕ Tambah Siswa</h4>

    <form method="POST" action="">
      <div class="row mb-3">
        <div class="col-md-6">
          <label>Nama Lengkap</label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>NISN</label>
          <input type="text" name="nisn" class="form-control" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>NIK</label>
          <input type="text" name="nik" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Tempat Lahir</label>
          <input type="text" name="tempat_lahir" class="form-control" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Alamat</label>
          <input type="text" name="alamat" class="form-control" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Nama Ayah</label>
          <input type="text" name="nama_ayah" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Nama Ibu</label>
          <input type="text" name="nama_ibu" class="form-control" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Pekerjaan Orang Tua</label>
          <input type="text" name="pekerjaan" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>No. Telepon</label>
          <input type="text" name="no_tlp" class="form-control" required>
        </div>
      </div>

      <div class="mb-3">
        <label>ID Kelas</label>
        <input type="number" name="id_kelas" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> Simpan
      </button>
      <a href="data_siswa.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>
</html>
