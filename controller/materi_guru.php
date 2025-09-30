<?php
require_once '../config/mysql_db.php'; // Sesuaikan path ke file koneksi DB

// Ambil id pelajaran dari query string
$id_pelajaran = isset($_GET['id_pelajaran']) ? intval($_GET['id_pelajaran']) : 0;

if ($id_pelajaran <= 0) {
    echo json_encode(["error" => "ID Pelajaran tidak valid."]);
    exit;
}

// Ambil semua materi berdasarkan ID_Pelajaran
$query = "SELECT * FROM materi WHERE ID_Pelajaran = ? ORDER BY Tanggal_Upload DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pelajaran);
$stmt->execute();
$result = $stmt->get_result();

$data_materi = [];

while ($row = $result->fetch_assoc()) {
    $id_materi = $row['ID_Materi'];

    // Ambil semua tugas yang terkait dengan pelajaran ini (jika tabel tugas tidak ada ID_Materi)
    $tugas_query = "SELECT * FROM tugas WHERE ID_Pelajaran = ?";
    $stmt_tugas = $conn->prepare($tugas_query);
    $stmt_tugas->bind_param("i", $id_pelajaran);
    $stmt_tugas->execute();
    $tugas_result = $stmt_tugas->get_result();

    $list_tugas = [];
    while ($tugas = $tugas_result->fetch_assoc()) {
        $list_tugas[] = $tugas['Deskripsi'];
    }

    // Dapatkan ekstensi file sebagai tipe konten
    $file_path = $row['File'];
    $tipe_konten = null;
    if (!empty($file_path)) {
        $tipe_konten = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
    }

    // Gabungkan ke dalam array materi
    $data_materi[] = [
        'judul' => $row['Judul'],
        'deskripsi' => $row['Deskripsi'],
        'tanggal' => !empty($row['Tanggal_Upload']) ? date('l, d F Y', strtotime($row['Tanggal_Upload'])) : '',
        'file' => $file_path,
        'tipe_konten' => $tipe_konten,
        'tugas' => $list_tugas
    ];
}

// Output JSON
header('Content-Type: application/json');
echo json_encode($data_materi, JSON_PRETTY_PRINT);
