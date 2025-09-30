<?php
require_once(__DIR__ . '/../config/mysql_db.php');

<<<<<<< HEAD
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM siswa WHERE ID_Siswa = ?";
$stmt = $conn->prepare($query);
=======
// Ambil ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID tidak valid.";
    exit;
}

$id = $_GET['id'];

// Ambil data siswa dari database
$stmt = $conn->prepare("SELECT * FROM siswa WHERE ID_Siswa = ?");
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Data siswa tidak ditemukan.";
    exit;
}

$data = $result->fetch_assoc();
<<<<<<< HEAD
=======

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nama         = $_POST['Nama'];
    $NISN         = $_POST['NISN'];
    $NIK          = $_POST['NIK'];
    $Tempat_Lahir = $_POST['Tempat_Lahir'];
    $Tanggal_Lahir= $_POST['Tanggal_Lahir'];
    $Alamat       = $_POST['Alamat'];
    $Nama_Ayah    = $_POST['Nama_Ayah'];
    $Nama_Ibu     = $_POST['Nama_Ibu'];
    $Pekerjaan    = $_POST['Pekerjaan'];
    $No_Tlp       = $_POST['No_Tlp'];
    $ID_Kelas     = $_POST['ID_Kelas'];

    $update = $conn->prepare("UPDATE siswa SET Nama=?, NISN=?, NIK=?, Tempat_Lahir=?, Tanggal_Lahir=?, Alamat=?, Nama_Ayah=?, Nama_Ibu=?, Pekerjaan=?, No_Tlp=?, ID_Kelas=? WHERE ID_Siswa=?");
    $update->bind_param("ssssssssssii", $Nama, $NISN, $NIK, $Tempat_Lahir, $Tanggal_Lahir, $Alamat, $Nama_Ayah, $Nama_Ibu, $Pekerjaan, $No_Tlp, $ID_Kelas, $id);

    if ($update->execute()) {
        header("Location: data_siswa.php?success=Data berhasil diperbarui");
        exit;
    } else {
        echo "Gagal memperbarui data: " . $conn->error;
    }
}
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Siswa</title>
<<<<<<< HEAD
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
=======
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h3>Edit Data Siswa</h3>
    <form method="POST">
      <div class="row mb-3">
        <div class="col-md-6">
          <label>Nama</label>
          <input type="text" name="Nama" class="form-control" value="<?= htmlspecialchars($data['Nama']) ?>" required>
        </div>
        <div class="col-md-6">
          <label>NISN</label>
          <input type="text" name="NISN" class="form-control" value="<?= $data['NISN'] ?>" required>
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
        </div>
      </div>

      <div class="row mb-3">
<<<<<<< HEAD
        <div class="col">
          <label for="nik" class="form-label">NIK</label>
          <input type="text" name="nik" class="form-control" value="<?= $data['NIK'] ?>" required>
        </div>
        <div class="col">
          <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
          <input type="text" name="tempat_lahir" class="form-control" value="<?= $data['Tempat_Lahir'] ?>" required>
=======
        <div class="col-md-6">
          <label>NIK</label>
          <input type="text" name="NIK" class="form-control" value="<?= $data['NIK'] ?>" required>
        </div>
        <div class="col-md-6">
          <label>Tempat Lahir</label>
          <input type="text" name="Tempat_Lahir" class="form-control" value="<?= $data['Tempat_Lahir'] ?>" required>
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
        </div>
      </div>

      <div class="mb-3">
<<<<<<< HEAD
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
=======
        <label>Tanggal Lahir</label>
        <input type="date" name="Tanggal_Lahir" class="form-control" value="<?= $data['Tanggal_Lahir'] ?>" required>
      </div>

      <div class="mb-3">
        <label>Alamat</label>
        <textarea name="Alamat" class="form-control" required><?= $data['Alamat'] ?></textarea>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Nama Ayah</label>
          <input type="text" name="Nama_Ayah" class="form-control" value="<?= $data['Nama_Ayah'] ?>">
        </div>
        <div class="col-md-6">
          <label>Nama Ibu</label>
          <input type="text" name="Nama_Ibu" class="form-control" value="<?= $data['Nama_Ibu'] ?>">
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
        </div>
      </div>

      <div class="row mb-3">
<<<<<<< HEAD
        <div class="col">
          <label for="pekerjaan" class="form-label">Pekerjaan</label>
          <input type="text" name="pekerjaan" class="form-control" value="<?= $data['Pekerjaan'] ?>" required>
        </div>
        <div class="col">
          <label for="no_tlp" class="form-label">No. Telepon</label>
          <input type="text" name="no_tlp" class="form-control" value="<?= $data['No_Tlp'] ?>" required>
=======
        <div class="col-md-6">
          <label>Pekerjaan</label>
          <input type="text" name="Pekerjaan" class="form-control" value="<?= $data['Pekerjaan'] ?>">
        </div>
        <div class="col-md-6">
          <label>No. Telepon</label>
          <input type="text" name="No_Tlp" class="form-control" value="<?= $data['No_Tlp'] ?>">
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
        </div>
      </div>

      <div class="mb-3">
<<<<<<< HEAD
        <label for="id_kelas" class="form-label">ID Kelas</label>
        <input type="number" name="id_kelas" class="form-control" value="<?= $data['ID_Kelas'] ?>" required>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-save me-1"></i> Simpan Perubahan
        </button>
        <a href="data_siswa.php" class="btn btn-secondary">Kembali</a>
      </div>
=======
        <label>ID Kelas</label>
        <input type="text" name="ID_Kelas" class="form-control" value="<?= $data['ID_Kelas'] ?>" required>
      </div>

      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="data_siswa.php" class="btn btn-secondary">Kembali</a>
>>>>>>> d8ad728 (Update project: perbaiikan auth, tambah fitur guru, hapus yang lama)
    </form>
  </div>
</body>
</html>
