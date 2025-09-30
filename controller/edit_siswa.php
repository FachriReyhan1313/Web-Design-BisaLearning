<?php
require_once(__DIR__ . '/../config/mysql_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id             = intval($_POST['id']);
    $nama           = $_POST['nama'];
    $nisn           = $_POST['nisn'];
    $nik            = $_POST['nik'];
    $tempat_lahir   = $_POST['tempat_lahir'];
    $tanggal_lahir  = $_POST['tanggal_lahir'];
    $alamat         = $_POST['alamat'];
    $ayah           = $_POST['ayah'];
    $ibu            = $_POST['ibu'];
    $pekerjaan      = $_POST['pekerjaan'];
    $no_tlp         = $_POST['no_tlp'];
    $id_kelas       = $_POST['id_kelas'];

    $query = "UPDATE siswa SET 
        Nama = ?, NISN = ?, NIK = ?, Tempat_Lahir = ?, Tanggal_Lahir = ?, Alamat = ?, 
        Nama_Ayah = ?, Nama_Ibu = ?, Pekerjaan = ?, No_Tlp = ?, ID_Kelas = ?
        WHERE ID_Siswa = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssssii", $nama, $nisn, $nik, $tempat_lahir, $tanggal_lahir, $alamat, 
        $ayah, $ibu, $pekerjaan, $no_tlp, $id_kelas, $id);

    if ($stmt->execute()) {
        header("Location: ../views/data_siswa.php?success=Data berhasil diperbarui");
        exit();
    } else {
        echo "Gagal memperbarui data: " . $conn->error;
    }
} else {
    echo "Akses tidak diizinkan.";
}
