<?php
require_once(__DIR__ . '/../../config/mysql_db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("ID tidak valid.");
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nama = $_POST['Nama'];
    $NISN = $_POST['NISN'];
    $NIK = $_POST['NIK'];
    $Tempat_Lahir = $_POST['Tempat_Lahir'];
    $Tanggal_Lahir = $_POST['Tanggal_Lahir'];
    $Alamat = $_POST['Alamat'];
    $Nama_Ayah = $_POST['Nama_Ayah'];
    $Nama_Ibu = $_POST['Nama_Ibu'];
    $Pekerjaan = $_POST['Pekerjaan'];
    $No_Tlp = $_POST['No_Tlp'];
    $ID_Kelas = $_POST['ID_Kelas'];

    $stmt = $conn->prepare("UPDATE siswa SET Nama=?, NISN=?, NIK=?, Tempat_Lahir=?, Tanggal_Lahir=?, Alamat=?, Nama_Ayah=?, Nama_Ibu=?, Pekerjaan=?, No_Tlp=?, ID_Kelas=? WHERE ID_Siswa=?");
    $stmt->bind_param("ssssssssssii", $Nama, $NISN, $NIK, $Tempat_Lahir, $Tanggal_Lahir, $Alamat, $Nama_Ayah, $Nama_Ibu, $Pekerjaan, $No_Tlp, $ID_Kelas, $id);

    if ($stmt->execute()) {
        header("Location: data_siswa.php?success=Data berhasil diperbarui");
        exit;
    } else {
        $error = "Gagal memperbarui data.";
    }
}

// Ambil data siswa
$stmt = $conn->prepare("SELECT * FROM siswa WHERE ID_Siswa = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
if (!$data) {
    die("Data tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h4>Edit Data Siswa</h4>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="Nama" value="<?= htmlspecialchars($data['Nama']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>NISN</label>
                <input type="text" name="NISN" value="<?= htmlspecialchars($data['NISN']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>NIK</label>
                <input type="text" name="NIK" value="<?= htmlspecialchars($data['NIK']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Tempat Lahir</label>
                <input type="text" name="Tempat_Lahir" value="<?= htmlspecialchars($data['Tempat_Lahir']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="Tanggal_Lahir" value="<?= $data['Tanggal_Lahir'] ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="Alamat" class="form-control" required><?= htmlspecialchars($data['Alamat']) ?></textarea>
            </div>
            <div class="mb-3">
                <label>Nama Ayah</label>
                <input type="text" name="Nama_Ayah" value="<?= htmlspecialchars($data['Nama_Ayah']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nama Ibu</label>
                <input type="text" name="Nama_Ibu" value="<?= htmlspecialchars($data['Nama_Ibu']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Pekerjaan</label>
                <input type="text" name="Pekerjaan" value="<?= htmlspecialchars($data['Pekerjaan']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>No. Tlp</label>
                <input type="text" name="No_Tlp" value="<?= htmlspecialchars($data['No_Tlp']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>ID Kelas</label>
                <input type="number" name="ID_Kelas" value="<?= $data['ID_Kelas'] ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="view_siswa.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
