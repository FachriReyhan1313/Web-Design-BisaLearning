<?php
require_once(__DIR__ . '/../config/mysql_db.php');
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
    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>
    <a href="tambah_siswa.php" class="btn btn-primary mb-3">
      <i class="bi bi-plus-circle"></i> Tambah Siswa
    </a>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
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

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['Nama']}</td>
                    <td>{$row['NISN']}</td>
                    <td>{$row['NIK']}</td>
                    <td>{$row['Tempat_Lahir']}</td>
                    <td>{$row['Tanggal_Lahir']}</td>
                    <td>{$row['Alamat']}</td>
                    <td>{$row['Nama_Ayah']}</td>
                    <td>{$row['Nama_Ibu']}</td>
                    <td>{$row['Pekerjaan']}</td>
                    <td>{$row['No_Tlp']}</td>
                    <td>{$row['ID_Kelas']}</td>
                    <td>
                      <a href='edit_siswa.php?id={$row['ID_Siswa']}' class='btn btn-sm btn-warning'>
                        <i class='bi bi-pencil-square'></i>
                      </a>
                      <a href='../controller/hapus.php?id={$row['ID_Siswa']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                        <i class='bi bi-trash'></i>
                      </a>
                    </td>
                  </tr>";
            $no++;
          }
        } else {
          echo "<tr><td colspan='13' class='text-center'>Tidak ada data siswa.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
