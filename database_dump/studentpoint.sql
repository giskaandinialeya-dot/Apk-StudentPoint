-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2026 at 07:53 AM
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
-- Database: `studentpoint`
--

-- --------------------------------------------------------

--
-- Table structure for table `absentis`
--

CREATE TABLE `absentis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `guru_input_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_ke` tinyint(4) DEFAULT NULL,
  `status` enum('hadir','sakit','izin','alfa') NOT NULL DEFAULT 'hadir',
  `keterangan` varchar(255) DEFAULT NULL,
  `sinkronisasi_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absentis`
--

INSERT INTO `absentis` (`id`, `siswa_id`, `guru_input_id`, `tanggal`, `jam_ke`, `status`, `keterangan`, `sinkronisasi_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 4, 10, '2026-01-23', NULL, 'alfa', NULL, NULL, NULL, '2026-01-23 16:09:55', '2026-01-23 16:12:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gurus`
--

CREATE TABLE `gurus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `agama` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `spesialisasi` varchar(255) NOT NULL,
  `kelas_wali_id` bigint(20) UNSIGNED DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif','pensiun') NOT NULL DEFAULT 'aktif',
  `tanggal_masuk` date DEFAULT NULL,
  `tanggal_keluar` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gurus`
--

INSERT INTO `gurus` (`id`, `user_id`, `nip`, `nama_lengkap`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `agama`, `alamat`, `spesialisasi`, `kelas_wali_id`, `foto`, `status`, `tanggal_masuk`, `tanggal_keluar`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, '198505152010011001', 'Budi Santoso, S.Pd.', 'laki-laki', 'Jakarta', '1985-05-15', 'Islam', 'Jl. Merdeka No. 123, Jakarta', 'Matematika', NULL, NULL, 'aktif', NULL, NULL, NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(2, 3, '199012082015032002', 'Siti Rahma, S.Pd.', 'perempuan', 'Bandung', '1990-12-08', 'Islam', 'Jl. Sudirman No. 456, Bandung', 'Bahasa Indonesia', NULL, NULL, 'aktif', NULL, NULL, NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(3, 11, '123', 'agu', 'laki-laki', NULL, NULL, NULL, NULL, 'Informatika', NULL, NULL, 'aktif', NULL, NULL, NULL, '2026-01-23 10:45:57', '2026-01-23 10:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pelanggarans`
--

CREATE TABLE `jenis_pelanggarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `poin` int(11) NOT NULL,
  `kategori` enum('ringan','sedang','berat') NOT NULL,
  `keterangan` text DEFAULT NULL,
  `auto_sp_level` tinyint(4) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_pelanggarans`
--

INSERT INTO `jenis_pelanggarans` (`id`, `nama`, `poin`, `kategori`, `keterangan`, `auto_sp_level`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Terlambat Datang', 1, 'ringan', 'Terlambat datang ke sekolah maksimal 15 menit', NULL, 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(2, 'Tidak Mengerjakan PR', 2, 'ringan', 'Tidak mengumpulkan pekerjaan rumah', NULL, 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(3, 'Seragam Tidak Rapi', 1, 'ringan', 'Seragam tidak rapi atau tidak sesuai peraturan', NULL, 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(4, 'Bolos Kelas', 5, 'sedang', 'Tidak hadir di kelas tanpa surat izin', NULL, 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(5, 'Merusak Fasilitas Sekolah', 7, 'sedang', 'Merusak sarana dan prasarana sekolah', NULL, 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(6, 'Bermain Handphone di Kelas', 4, 'sedang', 'Menggunakan handphone di dalam kelas tanpa izin', NULL, 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(7, 'Menyontek Saat Ujian', 15, 'berat', 'Melakukan tindakan curang pada saat ujian', 1, 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(8, 'Terlibat Perkelahian', 20, 'berat', 'Terlibat dalam perkelahian dengan sesama siswa', 2, 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(9, 'Membawa Benda Terlarang', 25, 'berat', 'Membawa senjata, narkoba, atau benda berbahaya', 3, 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(10, 'Pelanggaran Moral/Etika', 30, 'berat', 'Melakukan tindakan amoral atau tidak etis', 3, 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(11, 'Makan di Kelas', 2, 'ringan', 'Pelanggaran custom: Makan di Kelas', NULL, 'aktif', NULL, '2026-01-23 14:42:37', '2026-01-23 14:42:37'),
(12, 'Tidak Mengikuti Upacara', 5, 'sedang', 'Pelanggaran custom: Tidak Mengikuti Upacara', NULL, 'aktif', NULL, '2026-01-23 14:42:37', '2026-01-23 14:42:37'),
(13, 'Membawa Minuman Beralkohol', 15, 'berat', 'Pelanggaran custom: Membawa Minuman Beralkohol', NULL, 'aktif', NULL, '2026-01-23 14:42:37', '2026-01-23 14:42:37'),
(14, 'main hp', 10, 'ringan', 'Dibuat oleh guru', NULL, 'aktif', NULL, '2026-01-23 15:08:59', '2026-01-23 15:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `wali_guru_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `semester` tinyint(4) NOT NULL DEFAULT 1,
  `tahun_kelulusan` year(4) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama`, `tingkat`, `wali_guru_id`, `tahun_ajaran`, `semester`, `tahun_kelulusan`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'X IPA 1', 'X', 1, '2024/2025', 1, '2027', 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(2, 'X IPA 2', 'X', 2, '2024/2025', 1, '2027', 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(3, 'X IPS 1', 'X', NULL, '2024/2025', 1, '2027', 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(4, 'XI IPA 1', 'XI', NULL, '2024/2025', 1, '2026', 'aktif', NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_23_000001_create_kelas_table', 1),
(6, '2024_01_23_000002_create_siswas_table', 1),
(7, '2024_01_23_000003_create_gurus_table', 1),
(8, '2024_01_23_000004_create_orang_tuas_table', 1),
(9, '2024_01_23_000005_create_jenis_pelanggarans_table', 1),
(10, '2024_01_23_000006_create_pelanggarans_table', 1),
(11, '2024_01_23_000007_create_prestasis_table', 1),
(12, '2024_01_23_000008_create_absentis_table', 1),
(13, '2024_01_23_000009_create_ujians_table', 1),
(14, '2024_01_23_000010_create_soals_table', 1),
(15, '2024_01_23_000011_create_nilais_table', 1),
(16, '2024_01_23_000012_create_rapors_table', 1),
(17, '2024_01_23_000013_create_surat_peringatan_table', 1),
(19, '2024_01_23_000014_create_notifikasis_table', 2),
(20, '2024_01_25_000001_remove_orang_tua_role', 2);

-- --------------------------------------------------------

--
-- Table structure for table `nilais`
--

CREATE TABLE `nilais` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `ujian_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `skor` int(11) DEFAULT NULL,
  `jawaban_file` varchar(255) DEFAULT NULL,
  `nilai_akhir` int(11) DEFAULT NULL,
  `status` enum('draft','sudah_dinilai','selesai') NOT NULL DEFAULT 'draft',
  `tanggal_input` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasis`
--

CREATE TABLE `notifikasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tipe` enum('poin_kritis','surat_peringatan','panggilan_ortu','nilai_input','absensi_update') NOT NULL DEFAULT 'poin_kritis',
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggarans`
--

CREATE TABLE `pelanggarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `guru_input_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_pelanggaran_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `bukti_file` varchar(255) DEFAULT NULL,
  `status` enum('aktif','dibatalkan') NOT NULL DEFAULT 'aktif',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggarans`
--

INSERT INTO `pelanggarans` (`id`, `siswa_id`, `guru_input_id`, `jenis_pelanggaran_id`, `tanggal`, `jam`, `deskripsi`, `bukti_file`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 12, '2026-01-23', '05:46:00', NULL, NULL, 'aktif', NULL, '2026-01-23 14:45:17', '2026-01-23 15:13:22'),
(2, 4, 2, 14, '2026-01-23', '05:09:00', NULL, NULL, 'aktif', NULL, '2026-01-23 15:09:12', '2026-01-23 15:09:12'),
(3, 4, 2, 14, '2026-01-23', '05:09:00', NULL, NULL, 'aktif', NULL, '2026-01-23 15:10:29', '2026-01-23 15:10:29');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prestasis`
--

CREATE TABLE `prestasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `guru_input_id` bigint(20) UNSIGNED NOT NULL,
  `nama_prestasi` varchar(255) NOT NULL,
  `poin` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `tingkat` enum('kelas','sekolah','regional','nasional') NOT NULL DEFAULT 'sekolah',
  `bukti_file` varchar(255) DEFAULT NULL,
  `status` enum('aktif','dibatalkan') NOT NULL DEFAULT 'aktif',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rapors`
--

CREATE TABLE `rapors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `mata_pelajaran` varchar(255) NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `semester` tinyint(4) NOT NULL,
  `nilai_pengetahuan` int(11) DEFAULT NULL,
  `nilai_keterampilan` int(11) DEFAULT NULL,
  `nilai_sikap` int(11) DEFAULT NULL,
  `nilai_akhir` int(11) DEFAULT NULL,
  `nilai_huruf` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tanggal_input` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswas`
--

CREATE TABLE `siswas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `agama` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `semester` tinyint(4) NOT NULL DEFAULT 1,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif','lulus','pindah') NOT NULL DEFAULT 'aktif',
  `tanggal_masuk` date DEFAULT NULL,
  `tanggal_keluar` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswas`
--

INSERT INTO `siswas` (`id`, `user_id`, `nis`, `nama_lengkap`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `agama`, `alamat`, `kelas_id`, `tahun_ajaran`, `semester`, `foto`, `status`, `tanggal_masuk`, `tanggal_keluar`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 10, '123', 'aleya', 'perempuan', 'sukabumi', '2026-01-24', NULL, NULL, 2, '2026/2027', 1, NULL, 'aktif', NULL, NULL, NULL, '2026-01-23 10:42:47', '2026-01-23 14:28:32');

-- --------------------------------------------------------

--
-- Table structure for table `soals`
--

CREATE TABLE `soals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ujian_id` bigint(20) UNSIGNED NOT NULL,
  `urutan` int(11) NOT NULL,
  `pertanyaan` longtext NOT NULL,
  `tipe` enum('pilihan_ganda','essay','true_false') NOT NULL DEFAULT 'pilihan_ganda',
  `opsi_a` text DEFAULT NULL,
  `opsi_b` text DEFAULT NULL,
  `opsi_c` text DEFAULT NULL,
  `opsi_d` text DEFAULT NULL,
  `opsi_e` text DEFAULT NULL,
  `jawaban_benar` varchar(255) DEFAULT NULL,
  `bobot` int(11) NOT NULL DEFAULT 1,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_peringatan`
--

CREATE TABLE `surat_peringatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `guru_tanda_tangan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `level` tinyint(4) NOT NULL,
  `total_poin` int(11) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `alasan` text DEFAULT NULL,
  `file_pdf` varchar(255) DEFAULT NULL,
  `status` enum('aktif','dibatalkan') NOT NULL DEFAULT 'aktif',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_peringatan`
--

INSERT INTO `surat_peringatan` (`id`, `siswa_id`, `guru_tanda_tangan_id`, `level`, `total_poin`, `tanggal_terbit`, `alasan`, `file_pdf`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, 1, 15, '2026-01-23', 'Siswa telah mencapai poin pelanggaran 15. Berdasarkan peraturan sekolah, diberikan Surat Peringatan I.', NULL, 'aktif', NULL, '2026-01-23 15:09:12', '2026-01-23 15:09:12'),
(2, 4, NULL, 2, 25, '2026-01-23', 'Siswa telah mencapai poin pelanggaran 25. Berdasarkan peraturan sekolah, diberikan Surat Peringatan II.', NULL, 'aktif', NULL, '2026-01-23 15:10:29', '2026-01-23 15:10:29');

-- --------------------------------------------------------

--
-- Table structure for table `ujians`
--

CREATE TABLE `ujians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `mata_pelajaran` varchar(255) NOT NULL,
  `tipe` enum('online','offline') NOT NULL DEFAULT 'online',
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_selesai` datetime NOT NULL,
  `durasi_menit` int(11) NOT NULL DEFAULT 60,
  `kkm` int(11) NOT NULL DEFAULT 70,
  `jumlah_soal` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `status` enum('draft','berlangsung','selesai') NOT NULL DEFAULT 'draft',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin E-POIN', 'admin@epoin.com', '2026-01-23 08:56:36', '$2y$10$C6jROjSWLCVHRKANila0l.E7YuOgaqYtMdD9.42l/3W4dKN.nm8QK', 'admin', 1, NULL, '2026-01-23 08:56:36', '2026-01-23 10:57:34'),
(2, 'Budi Santoso, S.Pd.', 'guru1@epoin.com', '2026-01-23 08:56:36', '$2y$10$RpQFf0qLEzQBv8.Efa9e6eFWL/VKVTYwta74f5RQtflxF3b0Aohk2', 'guru', 1, NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(3, 'Siti Rahma, S.Pd.', 'guru2@epoin.com', '2026-01-23 08:56:36', '$2y$10$60yj33Kx21mBGjft01e0ceuRy774lU.04NmUQ0/773CxmPGEtC7PG', 'guru', 1, NULL, '2026-01-23 08:56:36', '2026-01-23 08:56:36'),
(9, 'aleya', 'asd@gmail.com', NULL, '$2y$10$I5s15X830F6IurO1cm25q.Ewkut5qIP05gI3kg8hABmehZKN7EPSS', 'siswa', 1, NULL, '2026-01-23 10:40:34', '2026-01-23 10:40:34'),
(10, 'aleya', 'Aleya@gmail.com', NULL, '$2y$10$.iljcrmDKCIuy3pxKxaT.ey8hqQn.BngzASTzaX5f9YzRcuGAyDpO', 'siswa', 1, NULL, '2026-01-23 10:42:47', '2026-01-23 14:28:21'),
(11, 'agu', 'agus@gmail.com', NULL, '$2y$10$jf3Ot.ksjAGukALnbbXwgezro2E7UecStsjIRrNUFNQO5x.SFh716', 'siswa', 1, NULL, '2026-01-23 10:45:57', '2026-01-23 10:45:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absentis`
--
ALTER TABLE `absentis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `absentis_siswa_id_tanggal_jam_ke_deleted_at_unique` (`siswa_id`,`tanggal`,`jam_ke`,`deleted_at`),
  ADD KEY `absentis_siswa_id_index` (`siswa_id`),
  ADD KEY `absentis_guru_input_id_index` (`guru_input_id`),
  ADD KEY `absentis_tanggal_index` (`tanggal`),
  ADD KEY `absentis_status_index` (`status`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gurus`
--
ALTER TABLE `gurus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gurus_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `gurus_nip_unique` (`nip`),
  ADD KEY `gurus_status_index` (`status`),
  ADD KEY `gurus_spesialisasi_index` (`spesialisasi`),
  ADD KEY `gurus_kelas_wali_id_index` (`kelas_wali_id`);

--
-- Indexes for table `jenis_pelanggarans`
--
ALTER TABLE `jenis_pelanggarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis_pelanggarans_kategori_status_index` (`kategori`,`status`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelas_nama_tahun_ajaran_semester_deleted_at_unique` (`nama`,`tahun_ajaran`,`semester`,`deleted_at`),
  ADD KEY `kelas_wali_guru_id_foreign` (`wali_guru_id`),
  ADD KEY `kelas_tahun_ajaran_semester_index` (`tahun_ajaran`,`semester`),
  ADD KEY `kelas_status_index` (`status`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilais`
--
ALTER TABLE `nilais`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nilais_siswa_id_ujian_id_deleted_at_unique` (`siswa_id`,`ujian_id`,`deleted_at`),
  ADD KEY `nilais_siswa_id_index` (`siswa_id`),
  ADD KEY `nilais_ujian_id_index` (`ujian_id`),
  ADD KEY `nilais_guru_id_index` (`guru_id`),
  ADD KEY `nilais_status_index` (`status`);

--
-- Indexes for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasis_user_id_index` (`user_id`),
  ADD KEY `notifikasis_is_read_index` (`is_read`),
  ADD KEY `notifikasis_tipe_index` (`tipe`),
  ADD KEY `notifikasis_siswa_id_index` (`siswa_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pelanggarans`
--
ALTER TABLE `pelanggarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggarans_jenis_pelanggaran_id_foreign` (`jenis_pelanggaran_id`),
  ADD KEY `pelanggarans_siswa_id_index` (`siswa_id`),
  ADD KEY `pelanggarans_guru_input_id_index` (`guru_input_id`),
  ADD KEY `pelanggarans_tanggal_index` (`tanggal`),
  ADD KEY `pelanggarans_status_index` (`status`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `prestasis`
--
ALTER TABLE `prestasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prestasis_siswa_id_index` (`siswa_id`),
  ADD KEY `prestasis_guru_input_id_index` (`guru_input_id`),
  ADD KEY `prestasis_tanggal_index` (`tanggal`),
  ADD KEY `prestasis_tingkat_index` (`tingkat`);

--
-- Indexes for table `rapors`
--
ALTER TABLE `rapors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rapors_siswa_id_index` (`siswa_id`),
  ADD KEY `rapors_guru_id_index` (`guru_id`),
  ADD KEY `rapors_tahun_ajaran_semester_index` (`tahun_ajaran`,`semester`);

--
-- Indexes for table `siswas`
--
ALTER TABLE `siswas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswas_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `siswas_nis_unique` (`nis`),
  ADD KEY `siswas_kelas_id_status_index` (`kelas_id`,`status`),
  ADD KEY `siswas_tahun_ajaran_semester_index` (`tahun_ajaran`,`semester`);

--
-- Indexes for table `soals`
--
ALTER TABLE `soals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `soals_ujian_id_urutan_deleted_at_unique` (`ujian_id`,`urutan`,`deleted_at`),
  ADD KEY `soals_ujian_id_index` (`ujian_id`),
  ADD KEY `soals_urutan_index` (`urutan`);

--
-- Indexes for table `surat_peringatan`
--
ALTER TABLE `surat_peringatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_peringatan_guru_tanda_tangan_id_foreign` (`guru_tanda_tangan_id`),
  ADD KEY `surat_peringatan_siswa_id_index` (`siswa_id`),
  ADD KEY `surat_peringatan_level_index` (`level`),
  ADD KEY `surat_peringatan_status_index` (`status`),
  ADD KEY `surat_peringatan_tanggal_terbit_index` (`tanggal_terbit`);

--
-- Indexes for table `ujians`
--
ALTER TABLE `ujians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ujians_guru_id_index` (`guru_id`),
  ADD KEY `ujians_kelas_id_index` (`kelas_id`),
  ADD KEY `ujians_status_index` (`status`),
  ADD KEY `ujians_tanggal_mulai_index` (`tanggal_mulai`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absentis`
--
ALTER TABLE `absentis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gurus`
--
ALTER TABLE `gurus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jenis_pelanggarans`
--
ALTER TABLE `jenis_pelanggarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `nilais`
--
ALTER TABLE `nilais`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelanggarans`
--
ALTER TABLE `pelanggarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prestasis`
--
ALTER TABLE `prestasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rapors`
--
ALTER TABLE `rapors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswas`
--
ALTER TABLE `siswas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `soals`
--
ALTER TABLE `soals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_peringatan`
--
ALTER TABLE `surat_peringatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ujians`
--
ALTER TABLE `ujians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absentis`
--
ALTER TABLE `absentis`
  ADD CONSTRAINT `absentis_guru_input_id_foreign` FOREIGN KEY (`guru_input_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `absentis_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gurus`
--
ALTER TABLE `gurus`
  ADD CONSTRAINT `gurus_kelas_wali_id_foreign` FOREIGN KEY (`kelas_wali_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gurus_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_wali_guru_id_foreign` FOREIGN KEY (`wali_guru_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `nilais`
--
ALTER TABLE `nilais`
  ADD CONSTRAINT `nilais_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `nilais_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilais_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujians` (`id`);

--
-- Constraints for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pelanggarans`
--
ALTER TABLE `pelanggarans`
  ADD CONSTRAINT `pelanggarans_guru_input_id_foreign` FOREIGN KEY (`guru_input_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pelanggarans_jenis_pelanggaran_id_foreign` FOREIGN KEY (`jenis_pelanggaran_id`) REFERENCES `jenis_pelanggarans` (`id`),
  ADD CONSTRAINT `pelanggarans_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prestasis`
--
ALTER TABLE `prestasis`
  ADD CONSTRAINT `prestasis_guru_input_id_foreign` FOREIGN KEY (`guru_input_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `prestasis_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rapors`
--
ALTER TABLE `rapors`
  ADD CONSTRAINT `rapors_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rapors_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswas`
--
ALTER TABLE `siswas`
  ADD CONSTRAINT `siswas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `siswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `soals`
--
ALTER TABLE `soals`
  ADD CONSTRAINT `soals_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujians` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surat_peringatan`
--
ALTER TABLE `surat_peringatan`
  ADD CONSTRAINT `surat_peringatan_guru_tanda_tangan_id_foreign` FOREIGN KEY (`guru_tanda_tangan_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `surat_peringatan_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ujians`
--
ALTER TABLE `ujians`
  ADD CONSTRAINT `ujians_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ujians_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
