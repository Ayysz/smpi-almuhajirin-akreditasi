-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2026 at 09:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_akreditasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_osis`
--
SET SESSION sql_require_primary_key = 0;
CREATE TABLE `dokumen_osis` (
  `id_dokumen` int(11) NOT NULL,
  `jenis_dokumen` varchar(100) NOT NULL,
  `nama_dokumen` varchar(200) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `periode` varchar(20) DEFAULT NULL,
  `uploaded_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokumen_osis`
--

INSERT INTO `dokumen_osis` (`id_dokumen`, `jenis_dokumen`, `nama_dokumen`, `file_path`, `periode`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(3, 'SK Pengurus', 'rapat osis', 'uploads/osis/1776924391_97ccc412a15c555ba01e.pdf', '2025/2026', 1, '2026-04-23 06:06:31', NULL),
(8, 'Notulen Rapat', 'notulen rapat 20 mei', 'uploads/osis/1782402147_b9e2a2fb6316a624e682.pdf', '2025/2026', 3, '2026-06-25 15:42:27', '2026-06-25 22:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `nama_kegiatan` varchar(200) NOT NULL,
  `jenis_kegiatan` varchar(100) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `tempat` varchar(200) DEFAULT NULL,
  `penanggung_jawab` int(11) DEFAULT NULL,
  `status_verifikasi` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu',
  `alasan_penolakan` text DEFAULT NULL,
  `rundown_kegiatan` varchar(255) DEFAULT NULL,
  `file_absensi` varchar(255) DEFAULT NULL,
  `foto_kegiatan` varchar(255) DEFAULT NULL,
  `surat_keterangan` varchar(255) DEFAULT NULL,
  `proposal_laporan` varchar(255) DEFAULT NULL,
  `tahun_ajaran` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `nama_kegiatan`, `jenis_kegiatan`, `tanggal_mulai`, `tanggal_selesai`, `tempat`, `penanggung_jawab`, `status_verifikasi`, `alasan_penolakan`, `rundown_kegiatan`, `file_absensi`, `foto_kegiatan`, `surat_keterangan`, `proposal_laporan`, `tahun_ajaran`, `created_by`, `created_at`, `updated_at`) VALUES
(19, 'Kesenian', 'EKSTRAKURIKULER', '2026-07-05', '2026-07-07', 'GOR', 1, 'disetujui', '', '', 'uploads/kegiatan/19/1782394772_1782394772_beebcb27484ab9e28029.jpg', 'uploads/kegiatan/19/1782394772_1782394772_5cff197e26ecd2bce51f.png', '', '', '2023/2024', 1, '2026-06-25 07:25:22', '2026-06-25 15:53:45'),
(21, 'LDKS', 'KARAKTER', '2026-06-18', '2026-06-22', 'Sekolah', NULL, 'menunggu', NULL, 'uploads/kegiatan/21/1782396637_1782396637_5832d57267fead0264fb.jpg', 'uploads/kegiatan/21/1782396637_1782396637_242edbe8a23cbba26bc8.png', 'uploads/kegiatan/21/1782396637_1782396637_17667c8e4b696aa394f6.png', NULL, 'uploads/kegiatan/21/1782396637_1782396637_05d878c5e190184b677b.pdf', '2025/2026', NULL, '2026-06-25 14:10:37', '2026-06-25 14:10:37'),
(22, 'Class Meeting', 'EKSTRAKURIKULER', '2026-06-10', '2026-06-11', 'Sekolah', NULL, 'menunggu', NULL, NULL, 'uploads/kegiatan/22/1782396713_1782396713_4365251a27d030aee311.png', 'uploads/kegiatan/22/1782396713_1782396713_9bf459af5617d521c85d.jpg', NULL, 'uploads/kegiatan/22/1782396713_1782396713_76d287ac88040378f890.pdf', '2025/2026', NULL, '2026-06-25 14:11:53', '2026-06-25 14:11:53');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_kegiatan_osis`
--

CREATE TABLE `laporan_kegiatan_osis` (
  `id_laporan` int(11) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `tanggal_pelaksanaan` date NOT NULL,
  `jumlah_peserta` int(11) NOT NULL,
  `dokumentasi` varchar(255) NOT NULL,
  `file_laporan` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_kegiatan_osis`
--

INSERT INTO `laporan_kegiatan_osis` (`id_laporan`, `nama_kegiatan`, `tanggal_pelaksanaan`, `jumlah_peserta`, `dokumentasi`, `file_laporan`, `created_by`, `created_at`, `updated_at`) VALUES
(4, 'Laporan Kemerdekaan2', '2026-04-26', 1000, 'uploads/osis/1782401902_c31f913769a9c4472cf1.jpg', 'uploads/osis/1782401902_e6d269a04c58d21c393b.pdf', 1, '2026-06-25 14:25:22', '2026-06-25 22:38:22'),
(5, 'Laporan Kemerdekaan', '2026-06-30', 100, 'uploads/osis/1782401810_637845e1fb555c90a50d.png', 'uploads/osis/1782401810_1302cca8d83caf846964.pdf', 3, '2026-06-25 22:36:50', '2026-06-25 22:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id_prestasi` int(11) NOT NULL,
  `nama_siswa` varchar(255) DEFAULT NULL,
  `nama_prestasi` varchar(200) NOT NULL,
  `tingkat` enum('sekolah','kecamatan','kabupaten','provinsi','nasional','internasional') DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `peringkat` varchar(50) DEFAULT NULL,
  `tahun_perolehan` varchar(10) DEFAULT NULL,
  `penyelenggara` varchar(200) DEFAULT NULL,
  `file_sertifikat` varchar(255) DEFAULT NULL,
  `surat_tugas` text DEFAULT NULL,
  `dokumen_pendukung` text DEFAULT NULL,
  `status_verifikasi` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu',
  `alasan_penolakan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tanggal_pelaksanaan` date DEFAULT NULL,
  `lokasi_lomba` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`id_prestasi`, `nama_siswa`, `nama_prestasi`, `tingkat`, `kategori`, `peringkat`, `tahun_perolehan`, `penyelenggara`, `file_sertifikat`, `surat_tugas`, `dokumen_pendukung`, `status_verifikasi`, `alasan_penolakan`, `created_at`, `updated_at`, `tanggal_pelaksanaan`, `lokasi_lomba`, `created_by`) VALUES
(15, 'Dhea', 'Olimpiade', 'nasional', NULL, 'juara 1', '2026', 'dinas pendidikan ', 'uploads/prestasi/1782396862_8abdd0946ff529dad515.pdf', '[\"uploads\\/prestasi\\/1782396862_e1d8728259b939087ff3.jpg\"]', '[\"uploads\\/prestasi\\/1782396862_258c1fbea2a9e196f489.png\"]', 'disetujui', NULL, '2026-04-27 13:44:35', '2026-06-25 15:54:00', '2026-04-27', 'bogor', NULL),
(17, 'Widhi', 'Juara 2 Futsal', 'provinsi', 'Non-Akademik', 'Juara 2', '2026', 'PSSI', 'uploads/prestasi/1782398252_4149a0bfeca15ba5ddae.pdf', '[\"uploads\\/prestasi\\/1782398252_d2e52207eafb203075dc.png\"]', '[\"uploads\\/prestasi\\/1782398252_0e18d5cf344929613ae6.jpg\"]', 'menunggu', '', '2026-06-25 07:25:22', '2026-06-25 14:37:51', '2026-06-25', 'Lokasi 2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `program_osis`
--

CREATE TABLE `program_osis` (
  `id_program` int(11) NOT NULL,
  `nama_program` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `seksi` varchar(100) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status` enum('perencanaan','berjalan','selesai') DEFAULT 'perencanaan',
  `file_proposal` varchar(255) DEFAULT NULL,
  `periode` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_osis`
--

INSERT INTO `program_osis` (`id_program`, `nama_program`, `deskripsi`, `seksi`, `tanggal_mulai`, `tanggal_selesai`, `status`, `file_proposal`, `periode`, `created_by`, `created_at`) VALUES
(1, 'hari kemerdekaan', 'lomba', 'Olahraga', '2026-01-30', '2026-01-31', 'perencanaan', 'uploads/osis/1769790121_a5e875881a441fbd6c39.pdf', '2025/2026', 1, '2026-01-29 18:22:22'),
(3, 'hari kemerdekaan2', 'hgcsydfgwy', 'Olahraga', '2026-04-22', '2026-04-25', 'perencanaan', 'uploads/osis/1776861612_3d3cf1a3cff7507dc7e4.pdf', '2025/2026', 1, '2026-04-22 12:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','waka_kesiswaan','guru','kepala_sekolah') NOT NULL DEFAULT 'guru',
  `nip_nis` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `role`, `nip_nis`, `email`, `foto`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator', 'admin', '', '', 'uploads/profile/1771607840_1b6dd55426b2e0466970.png', 1, '2026-01-14 05:56:21', '2026-02-20 04:17:20'),
(3, 'waka_kesiswaan', '5c0e42676e00caf4386056ead0fe71c8', 'Dr. Budi Santoso, M.Pd', 'waka_kesiswaan', '198505152010011001', 'waka.kesiswaan@sekolah.sch.id', NULL, 1, '2026-01-17 07:59:56', '2026-06-11 05:20:37'),
(5, 'guru_osis', '9310f83135f238b04af729fec041cca8', 'Ahmad Ridwan, S.Pd', 'guru', '198707172012011001', 'ahmad.ridwan@sekolah.sch.id', NULL, 1, '2026-01-17 07:59:57', '2026-01-17 07:59:57'),
(12, 'guru', '9310f83135f238b04af729fec041cca8', 'Drs. Hendra Kusuma, M.Pd', 'guru', '198402242009011001', 'hendra.kusuma@sekolah.sch.id', NULL, 1, '2026-01-17 07:59:57', '2026-06-11 05:04:31'),
(31, 'kepala_sekolah', 'a2ed32cae296647110b3dbbf60c3f445', 'Sri Mulyati S.pd., M.pd', 'kepala_sekolah', '197505151998031001', 'kepala.sekolah@sekolah.sch.id', NULL, 1, '2026-01-17 07:59:57', '2026-04-08 10:02:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokumen_osis`
--
ALTER TABLE `dokumen_osis`
  ADD PRIMARY KEY (`id_dokumen`),
  ADD KEY `fk_dokumen_uploaded_by` (`uploaded_by`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `penanggung_jawab` (`penanggung_jawab`);

--
-- Indexes for table `laporan_kegiatan_osis`
--
ALTER TABLE `laporan_kegiatan_osis`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `fk_laporan_kegiatan_created_by` (`created_by`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id_prestasi`),
  ADD KEY `fk_prestasi_created_by` (`created_by`);

--
-- Indexes for table `program_osis`
--
ALTER TABLE `program_osis`
  ADD PRIMARY KEY (`id_program`),
  ADD KEY `fk_program_created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokumen_osis`
--
ALTER TABLE `dokumen_osis`
  MODIFY `id_dokumen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `laporan_kegiatan_osis`
--
ALTER TABLE `laporan_kegiatan_osis`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id_prestasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `program_osis`
--
ALTER TABLE `program_osis`
  MODIFY `id_program` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dokumen_osis`
--
ALTER TABLE `dokumen_osis`
  ADD CONSTRAINT `fk_dokumen_uploaded_by` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`penanggung_jawab`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `kegiatan_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `laporan_kegiatan_osis`
--
ALTER TABLE `laporan_kegiatan_osis`
  ADD CONSTRAINT `fk_laporan_kegiatan_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

--
-- Constraints for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD CONSTRAINT `fk_prestasi_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `program_osis`
--
ALTER TABLE `program_osis`
  ADD CONSTRAINT `fk_program_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNEdefaultdbCTION */;
