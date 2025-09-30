-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Agu 2025 pada 00.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bisalearn`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `ID_Admin` int(11) NOT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `NIP` varchar(20) DEFAULT NULL,
  `No_Tlp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`ID_Admin`, `Nama`, `NIP`, `No_Tlp`) VALUES
(1, 'Ahmad Fauzi', '198004012005', '081234567890'),
(2, 'Irwan', '198507192010', '082345678901');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `ID_Akun` int(11) NOT NULL,
  `UserName` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `ID_user` int(11) DEFAULT NULL,
  `Role` enum('admin','guru','siswa','relawan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`ID_Akun`, `UserName`, `Password`, `ID_user`, `Role`) VALUES
(23, 'azka', '$2y$10$PMW3wsDXVzYkRwCeuMEGEOZKLvocyr7KJkT7jUWJhFy4qT4oKQejy', 3, 'siswa'),
(25, 'Irwan', '$2y$10$p8jhkYqnV0NIJbpOPLRO5ObVBbI1JUpOthONZpW2m.Ym3hu7Hifym', 2, 'admin'),
(27, 'Irwan32', '$2y$10$h3VhU9pFtMyI.KQ3Y0rquOAUo5Gb2YheqhDsETkLqfcTp9sJeNin.', 2, 'guru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `ID_Guru` int(11) NOT NULL,
  `NIP` varchar(20) DEFAULT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `Hari` varchar(20) DEFAULT NULL,
  `Jam` time DEFAULT NULL,
  `No_Tlp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`ID_Guru`, `NIP`, `Nama`, `Hari`, `Jam`, `No_Tlp`) VALUES
(1, '197809102003', 'Budi Santoso', 'Senin', '08:00:00', '081112223333'),
(2, '198203152007', 'Irwan Nurhadi', 'Rabu', '10:00:00', '082233344455');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban_tugas`
--

CREATE TABLE `jawaban_tugas` (
  `ID_Jawaban` int(11) NOT NULL,
  `Isi_Jawaban` text DEFAULT NULL,
  `Waktu` date DEFAULT NULL,
  `ID_Tugas` int(11) DEFAULT NULL,
  `ID_Siswa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jawaban_tugas`
--

INSERT INTO `jawaban_tugas` (`ID_Jawaban`, `Isi_Jawaban`, `Waktu`, `ID_Tugas`, `ID_Siswa`) VALUES
(1, 'Jawaban soal aljabar lengkap', '2025-07-20', 1, 1),
(2, 'Narasi tentang kebersihan sekolah', '2025-07-21', 2, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `ID_Kelas` int(11) NOT NULL,
  `Tingkatan` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`ID_Kelas`, `Tingkatan`) VALUES
(1, 'IV'),
(2, 'V');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_mapel`
--

CREATE TABLE `kelas_mapel` (
  `ID_Kelas` int(11) NOT NULL,
  `ID_Pelajaran` int(11) NOT NULL,
  `id_guru` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas_mapel`
--

INSERT INTO `kelas_mapel` (`ID_Kelas`, `ID_Pelajaran`, `id_guru`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `ID_Pelajaran` int(11) NOT NULL,
  `Nama_Pelajaran` varchar(100) DEFAULT NULL,
  `Hari` varchar(20) DEFAULT NULL,
  `Jam` time DEFAULT NULL,
  `ID_Guru` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`ID_Pelajaran`, `Nama_Pelajaran`, `Hari`, `Jam`, `ID_Guru`) VALUES
(1, 'Matematika', 'Senin', '08:00:00', 1),
(2, 'Bahasa Indonesia', 'Rabu', '10:00:00', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `ID_Materi` int(11) NOT NULL,
  `Judul` varchar(100) DEFAULT NULL,
  `Deskripsi` text DEFAULT NULL,
  `tipe_konten` enum('pdf','video','ppt') DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `ID_Pelajaran` int(11) DEFAULT NULL,
  `Tanggal_Upload` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`ID_Materi`, `Judul`, `Deskripsi`, `tipe_konten`, `file`, `ID_Pelajaran`, `Tanggal_Upload`) VALUES
(1, 'Pengenalan Aljabar', 'Materi dasar tentang variabel dan persamaan', 'pdf', 'aljabar.pdf', 1, '2025-08-02 00:24:10'),
(2, 'Teks Narasi', 'Pengertian dan contoh teks narasi', 'ppt', 'narasi.ppt', 2, '2025-08-02 00:24:10'),
(3, 'subjek', 'aiueso', NULL, NULL, 2, '2025-08-01 20:12:45'),
(4, 'objek', 'objek', NULL, NULL, 2, '2025-08-01 20:15:25'),
(5, 'objek', 'objek', NULL, NULL, 2, '2025-08-01 20:18:25'),
(6, 'a', 'a', NULL, NULL, 2, '2025-08-01 20:22:43'),
(7, 's', 'a', NULL, NULL, 2, '2025-08-01 20:24:56'),
(8, 's', 'a', NULL, NULL, 2, '2025-08-01 20:25:42'),
(9, 's', 'a', NULL, NULL, 2, '2025-08-01 20:25:54'),
(10, 'd', 'c', NULL, 'uploads/688d0779b7a04.pdf', 2, '2025-08-01 20:29:13'),
(11, 'd', 'c', NULL, 'uploads/688d091da73f7.pdf', 2, '2025-08-01 20:36:13'),
(12, 'a', 'gh', NULL, NULL, 2, '2025-08-02 00:41:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `ID_Nilai` int(11) NOT NULL,
  `Nilai` int(11) DEFAULT NULL,
  `Waktu` time DEFAULT NULL,
  `ID_Jawaban` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`ID_Nilai`, `Nilai`, `Waktu`, `ID_Jawaban`) VALUES
(1, 90, '08:30:00', 1),
(2, 85, '09:00:00', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `relawan`
--

CREATE TABLE `relawan` (
  `ID_Relawan` int(11) NOT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `ID_Pelajaran` int(11) DEFAULT NULL,
  `Hari` varchar(20) DEFAULT NULL,
  `Jam` time DEFAULT NULL,
  `No_Tlp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `relawan`
--

INSERT INTO `relawan` (`ID_Relawan`, `Nama`, `ID_Pelajaran`, `Hari`, `Jam`, `No_Tlp`) VALUES
(1, 'Fajar Hidayat', 1, 'Selasa', '09:00:00', '081788899900'),
(2, 'Lina Safitri', 2, 'Kamis', '11:00:00', '082899900011');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `ID_Siswa` int(11) NOT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `NISN` varchar(15) DEFAULT NULL,
  `NIK` varchar(20) DEFAULT NULL,
  `Tempat_Lahir` varchar(50) DEFAULT NULL,
  `Tanggal_Lahir` date DEFAULT NULL,
  `Alamat` text DEFAULT NULL,
  `Nama_Ayah` varchar(100) DEFAULT NULL,
  `Nama_Ibu` varchar(100) DEFAULT NULL,
  `Pekerjaan` varchar(50) DEFAULT NULL,
  `No_Tlp` varchar(15) DEFAULT NULL,
  `ID_Kelas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`ID_Siswa`, `Nama`, `NISN`, `NIK`, `Tempat_Lahir`, `Tanggal_Lahir`, `Alamat`, `Nama_Ayah`, `Nama_Ibu`, `Pekerjaan`, `No_Tlp`, `ID_Kelas`) VALUES
(1, 'Rina Oktaviani', '0056781234', '3210987654321001', 'Jakarta', '2010-03-15', 'Jl. Mawar No. 11', 'Tono', 'Rini', 'Karyawan', '081344556677', 1),
(2, 'Andi Prasetyo', '0056785678', '3210987654321002', 'Bandung', '2010-06-22', 'Jl. Melati No. 5', 'Rudi', 'Ayu', 'Wiraswasta', '081566778899', 2),
(5, 'bona', '1234', '1235', 'jakarta', '2025-08-06', 'jakarta', 'fahri', 'azka ', 'kemenkes', '12345', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `ID_Tugas` int(11) NOT NULL,
  `ID_Pelajaran` int(11) DEFAULT NULL,
  `Deskripsi` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `ID_Materi` int(11) DEFAULT NULL,
  `Tanggal_Upload` datetime DEFAULT current_timestamp(),
  `Judul` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`ID_Tugas`, `ID_Pelajaran`, `Deskripsi`, `file`, `ID_Materi`, `Tanggal_Upload`, `Judul`) VALUES
(1, NULL, 'Kerjakan latihan soal aljabar halaman 15', NULL, 1, '2025-08-02 00:45:01', NULL),
(2, NULL, 'Tulis teks narasi bertema lingkungan', NULL, 2, '2025-08-02 00:45:01', NULL),
(3, 2, 'b', NULL, NULL, '2025-08-02 00:31:13', NULL),
(4, 2, 'bg', NULL, NULL, '2025-08-02 00:42:06', 'cd');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_Admin`);

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`ID_Akun`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`ID_Guru`);

--
-- Indeks untuk tabel `jawaban_tugas`
--
ALTER TABLE `jawaban_tugas`
  ADD PRIMARY KEY (`ID_Jawaban`),
  ADD KEY `ID_Tugas` (`ID_Tugas`),
  ADD KEY `ID_Siswa` (`ID_Siswa`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`ID_Kelas`);

--
-- Indeks untuk tabel `kelas_mapel`
--
ALTER TABLE `kelas_mapel`
  ADD PRIMARY KEY (`ID_Kelas`,`ID_Pelajaran`),
  ADD KEY `ID_Pelajaran` (`ID_Pelajaran`);

--
-- Indeks untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`ID_Pelajaran`),
  ADD KEY `ID_Guru` (`ID_Guru`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`ID_Materi`),
  ADD KEY `ID_Pelajaran` (`ID_Pelajaran`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`ID_Nilai`),
  ADD KEY `ID_Jawaban` (`ID_Jawaban`);

--
-- Indeks untuk tabel `relawan`
--
ALTER TABLE `relawan`
  ADD PRIMARY KEY (`ID_Relawan`),
  ADD KEY `ID_Pelajaran` (`ID_Pelajaran`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`ID_Siswa`),
  ADD KEY `ID_Kelas` (`ID_Kelas`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`ID_Tugas`),
  ADD KEY `ID_Materi` (`ID_Materi`),
  ADD KEY `fk_tugas_pelajaran` (`ID_Pelajaran`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `ID_Admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `ID_Akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `ID_Guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jawaban_tugas`
--
ALTER TABLE `jawaban_tugas`
  MODIFY `ID_Jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `ID_Kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `ID_Pelajaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `ID_Materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `ID_Nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `relawan`
--
ALTER TABLE `relawan`
  MODIFY `ID_Relawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `ID_Siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `ID_Tugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jawaban_tugas`
--
ALTER TABLE `jawaban_tugas`
  ADD CONSTRAINT `jawaban_tugas_ibfk_1` FOREIGN KEY (`ID_Tugas`) REFERENCES `tugas` (`ID_Tugas`),
  ADD CONSTRAINT `jawaban_tugas_ibfk_2` FOREIGN KEY (`ID_Siswa`) REFERENCES `siswa` (`ID_Siswa`);

--
-- Ketidakleluasaan untuk tabel `kelas_mapel`
--
ALTER TABLE `kelas_mapel`
  ADD CONSTRAINT `kelas_mapel_ibfk_1` FOREIGN KEY (`ID_Kelas`) REFERENCES `kelas` (`ID_Kelas`),
  ADD CONSTRAINT `kelas_mapel_ibfk_2` FOREIGN KEY (`ID_Pelajaran`) REFERENCES `mata_pelajaran` (`ID_Pelajaran`);

--
-- Ketidakleluasaan untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD CONSTRAINT `mata_pelajaran_ibfk_1` FOREIGN KEY (`ID_Guru`) REFERENCES `guru` (`ID_Guru`);

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`ID_Pelajaran`) REFERENCES `mata_pelajaran` (`ID_Pelajaran`);

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`ID_Jawaban`) REFERENCES `jawaban_tugas` (`ID_Jawaban`);

--
-- Ketidakleluasaan untuk tabel `relawan`
--
ALTER TABLE `relawan`
  ADD CONSTRAINT `relawan_ibfk_1` FOREIGN KEY (`ID_Pelajaran`) REFERENCES `mata_pelajaran` (`ID_Pelajaran`);

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`ID_Kelas`) REFERENCES `kelas` (`ID_Kelas`);

--
-- Ketidakleluasaan untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `fk_tugas_pelajaran` FOREIGN KEY (`ID_Pelajaran`) REFERENCES `mata_pelajaran` (`ID_Pelajaran`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`ID_Materi`) REFERENCES `materi` (`ID_Materi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
