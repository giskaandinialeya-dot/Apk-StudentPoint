# 🗄️ E-POIN Database Schema Documentation

Dokumentasi lengkap struktur database dan relasi antar tabel.

## 📊 Database Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                        E-POIN Database                       │
│                      (epoin - MySQL)                         │
└─────────────────────────────────────────────────────────────┘
                              │
        ┌─────────────────────┼─────────────────────┐
        │                     │                     │
    ┌───▼────┐          ┌─────▼─────┐      ┌──────▼─────┐
    │  Users │          │  Siswa    │      │   Guru     │
    └───┬────┘          └─────┬─────┘      └──────┬─────┘
        │                     │                    │
        │              ┌──────▼─────────────────┐  │
        │              │    Kelas    ◄──────────┴──┘
        │              └──────┬─────────────────┐
        │                     │                 │
        └────────────┬────────┴─────┬───────────┘
                     │              │
                ┌────▼────┐    ┌────▼───┐
                │OrangTua │    │Notifikasi
                └─────────┘    └─────────┘

    ┌──────────┐  ┌──────────┐  ┌──────────┐
    │Pelanggaran├──┤Prestasi  ├──┤Absensi   │
    └───┬──────┘  └────┬─────┘  └────┬─────┘
        │              │             │
        └──────────────┴─────────────┘
                       │
        ┌──────────────┼──────────────┐
        │              │              │
    ┌───▼────┐  ┌─────▼──┐  ┌────────▼────┐
    │  Ujian ├──┤ Soal   │  │SuratPeringatan
    └────┬───┘  └────────┘  └──────────────┘
         │
    ┌────▼────┐
    │  Nilai  │
    └─────────┘
         │
    ┌────▼────┐
    │  Rapor  │
    └─────────┘
```

## 📋 Tabel-tabel Utama

### 1. **users** (Base User Table)

```sql
CREATE TABLE `users` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `email_verified_at` timestamp NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa','orang_tua') NOT NULL,
  `is_active` boolean DEFAULT true,
  `last_login` timestamp NULL,
  `remember_token` varchar(100) NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  KEY `idx_email`,
  KEY `idx_role`,
  KEY `idx_is_active`
);
```

**Role:**
- `admin` → Super admin sekolah
- `guru` → Guru/wali kelas
- `siswa` → Siswa aktif
- `orang_tua` → Orang tua/wali siswa

---

### 2. **siswas**

```sql
CREATE TABLE `siswas` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `user_id` bigint(20) UNIQUE NOT NULL FOREIGN KEY REFERENCES users(id),
  `nis` varchar(50) UNIQUE NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan'),
  `tempat_lahir` varchar(255),
  `tanggal_lahir` date,
  `agama` varchar(50),
  `alamat` text,
  `kelas_id` bigint(20) FOREIGN KEY REFERENCES kelas(id),
  `tahun_ajaran` varchar(20),
  `semester` tinyint(1),
  `foto` varchar(255),
  `status` enum('aktif','nonaktif','lulus','pindah','dikeluarkan'),
  `tanggal_masuk` date,
  `tanggal_keluar` date,
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  KEY `idx_nis`,
  KEY `idx_kelas_id`,
  KEY `idx_tahun_semester`,
  KEY `idx_status`
);
```

**Relasi:**
- 1 siswa = 1 user
- 1 siswa = 1 kelas
- 1 siswa = many pelanggaran
- 1 siswa = many prestasi
- 1 siswa = many absensi

---

### 3. **kelas**

```sql
CREATE TABLE `kelas` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `tingkat` varchar(5),
  `wali_guru_id` bigint(20) FOREIGN KEY REFERENCES users(id),
  `tahun_ajaran` varchar(20),
  `semester` tinyint(1),
  `tahun_kelulusan` year,
  `status` enum('aktif','nonaktif'),
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  UNIQUE KEY `unique_kelas` (`nama`, `tahun_ajaran`, `semester`),
  KEY `idx_tingkat`,
  KEY `idx_wali_guru_id`
);
```

**Contoh Data:**
```
- X IPA 1 (Tingkat 10, IPA)
- X IPA 2
- X IPS 1
- XI IPA 1 (Tingkat 11)
- XII IPA 1 (Tingkat 12)
```

---

### 4. **gurus**

```sql
CREATE TABLE `gurus` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `user_id` bigint(20) UNIQUE NOT NULL FOREIGN KEY REFERENCES users(id),
  `nip` varchar(50) UNIQUE NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan'),
  `tempat_lahir` varchar(255),
  `tanggal_lahir` date,
  `agama` varchar(50),
  `alamat` text,
  `spesialisasi` varchar(100),
  `kelas_wali_id` bigint(20) FOREIGN KEY REFERENCES kelas(id),
  `foto` varchar(255),
  `status` enum('aktif','nonaktif','pensiun'),
  `tanggal_masuk` date,
  `tanggal_keluar` date,
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  KEY `idx_nip`,
  KEY `idx_spesialisasi`,
  KEY `idx_kelas_wali_id`
);
```

---

### 5. **jenis_pelanggarans** (Jenis Pelanggaran)

```sql
CREATE TABLE `jenis_pelanggarans` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `poin` int DEFAULT 1,
  `kategori` enum('ringan','sedang','berat'),
  `keterangan` text,
  `auto_sp_level` tinyint(1),
  `status` enum('aktif','nonaktif'),
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  KEY `idx_kategori`,
  KEY `idx_poin`
);
```

**Contoh:**
```
- Terlambat Datang (1 poin, ringan)
- Tidak Mengerjakan PR (2 poin, ringan)
- Bolos Kelas (5 poin, sedang)
- Menyontek (15 poin, berat, auto SP1)
- Terlibat Perkelahian (20 poin, berat, auto SP2)
```

---

### 6. **pelanggarans**

```sql
CREATE TABLE `pelanggarans` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `siswa_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES siswas(id),
  `guru_input_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES users(id),
  `jenis_pelanggaran_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES jenis_pelanggarans(id),
  `tanggal` date NOT NULL,
  `jam` time,
  `deskripsi` text,
  `bukti_file` varchar(255),
  `status` enum('aktif','dibatalkan'),
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  KEY `idx_siswa_id`,
  KEY `idx_guru_input_id`,
  KEY `idx_tanggal`,
  KEY `idx_status`
);
```

**Flow:**
1. Guru input pelanggaran → poin langsung terhitung
2. System check poin siswa
3. Jika >= threshold → generate SP otomatis
4. Notifikasi ke orang tua

---

### 7. **prestasis**

```sql
CREATE TABLE `prestasis` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `siswa_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES siswas(id),
  `guru_input_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES users(id),
  `nama_prestasi` varchar(255) NOT NULL,
  `poin` int NOT NULL,
  `tanggal` date NOT NULL,
  `tingkat` enum('kelas','sekolah','regional','nasional'),
  `bukti_file` varchar(255),
  `status` enum('aktif','dibatalkan'),
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  KEY `idx_siswa_id`,
  KEY `idx_tingkat`,
  KEY `idx_tanggal`
);
```

---

### 8. **absentis** (Absensi)

```sql
CREATE TABLE `absentis` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `siswa_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES siswas(id),
  `guru_input_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES users(id),
  `tanggal` date NOT NULL,
  `jam_ke` tinyint(1),
  `status` enum('hadir','sakit','izin','alfa'),
  `keterangan` varchar(255),
  `sinkronisasi_at` timestamp NULL,
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  UNIQUE KEY `unique_absensi` (`siswa_id`, `tanggal`, `jam_ke`),
  KEY `idx_status`
);
```

**Status:**
- `hadir` → Siswa hadir
- `sakit` → Sakit dengan surat
- `izin` → Izin dengan surat
- `alfa` → Tanpa keterangan

---

### 9. **ujians** (Ujian/CBT)

```sql
CREATE TABLE `ujians` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `guru_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES users(id),
  `kelas_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES kelas(id),
  `mata_pelajaran` varchar(255) NOT NULL,
  `tipe` enum('online','offline'),
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_selesai` datetime NOT NULL,
  `durasi_menit` int DEFAULT 60,
  `kkm` int DEFAULT 70,
  `jumlah_soal` int,
  `deskripsi` text,
  `status` enum('draft','berlangsung','selesai'),
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  KEY `idx_guru_id`,
  KEY `idx_kelas_id`,
  KEY `idx_status`,
  KEY `idx_tanggal_mulai`
);
```

---

### 10. **soals** (Soal Ujian)

```sql
CREATE TABLE `soals` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `ujian_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES ujians(id),
  `urutan` int NOT NULL,
  `pertanyaan` longtext NOT NULL,
  `tipe` enum('pilihan_ganda','essay','true_false'),
  `opsi_a` text,
  `opsi_b` text,
  `opsi_c` text,
  `opsi_d` text,
  `opsi_e` text,
  `jawaban_benar` varchar(255),
  `bobot` int DEFAULT 1,
  `status` enum('aktif','nonaktif'),
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  UNIQUE KEY `unique_soal` (`ujian_id`, `urutan`),
  KEY `idx_urutan`
);
```

---

### 11. **nilais** (Nilai Ujian)

```sql
CREATE TABLE `nilais` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `siswa_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES siswas(id),
  `ujian_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES ujians(id),
  `guru_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES users(id),
  `skor` int,
  `jawaban_file` varchar(255),
  `nilai_akhir` int,
  `status` enum('draft','sudah_dinilai','selesai'),
  `tanggal_input` datetime,
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  UNIQUE KEY `unique_nilai` (`siswa_id`, `ujian_id`),
  KEY `idx_guru_id`,
  KEY `idx_status`
);
```

---

### 12. **rapors** (E-Rapor)

```sql
CREATE TABLE `rapors` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `siswa_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES siswas(id),
  `guru_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES users(id),
  `mata_pelajaran` varchar(255) NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `semester` tinyint(1) NOT NULL,
  `nilai_pengetahuan` int,
  `nilai_keterampilan` int,
  `nilai_sikap` int,
  `nilai_akhir` int,
  `nilai_huruf` varchar(1),
  `deskripsi` text,
  `keterangan` varchar(255),
  `tanggal_input` datetime,
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  UNIQUE KEY `unique_rapor` (`siswa_id`, `guru_id`, `mata_pelajaran`, `tahun_ajaran`, `semester`),
  KEY `idx_tahun_semester`
);
```

---

### 13. **surat_peringatan**

```sql
CREATE TABLE `surat_peringatan` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `siswa_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES siswas(id),
  `guru_tanda_tangan_id` bigint(20) FOREIGN KEY REFERENCES users(id),
  `level` tinyint(1),
  `total_poin` int,
  `tanggal_terbit` date NOT NULL,
  `alasan` text,
  `file_pdf` varchar(255),
  `status` enum('aktif','dibatalkan'),
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  KEY `idx_siswa_id`,
  KEY `idx_level`,
  KEY `idx_status`,
  KEY `idx_tanggal_terbit`
);
```

**Level:**
- 1 → SP1 (Ringan)
- 2 → SP2 (Sedang)
- 3 → SP3 (Berat)
- 4 → SP4 (Dikeluarkan)

---

### 14. **orang_tuas**

```sql
CREATE TABLE `orang_tuas` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `user_id` bigint(20) UNIQUE NOT NULL FOREIGN KEY REFERENCES users(id),
  `siswa_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES siswas(id),
  `hubungan` enum('ayah','ibu','wali'),
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan'),
  `tempat_lahir` varchar(255),
  `tanggal_lahir` date,
  `agama` varchar(50),
  `alamat` text,
  `pekerjaan` varchar(255),
  `nomor_telepon` varchar(20),
  `email_pribadi` varchar(255),
  `status` enum('aktif','nonaktif'),
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  KEY `idx_siswa_id`,
  KEY `idx_hubungan`
);
```

---

### 15. **notifikasis** (Notifikasi)

```sql
CREATE TABLE `notifikasis` (
  `id` bigint(20) PRIMARY KEY AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL FOREIGN KEY REFERENCES users(id),
  `siswa_id` bigint(20) FOREIGN KEY REFERENCES siswas(id),
  `tipe` enum('poin_kritis','surat_peringatan','panggilan_ortu','nilai_input','absensi_update'),
  `judul` varchar(255) NOT NULL,
  `deskripsi` text,
  `is_read` boolean DEFAULT false,
  `read_at` datetime,
  `deleted_at` timestamp NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  
  KEY `idx_user_id`,
  KEY `idx_is_read`,
  KEY `idx_tipe`,
  KEY `idx_siswa_id`
);
```

---

## 🔍 Query Examples

### Total Poin Siswa
```sql
SELECT 
  s.id, s.nis, s.nama_lengkap,
  COALESCE(SUM(CASE WHEN p.status='aktif' THEN j.poin ELSE 0 END), 0) as total_pelanggaran,
  COALESCE(SUM(CASE WHEN pr.status='aktif' THEN pr.poin ELSE 0 END), 0) as total_prestasi
FROM siswas s
LEFT JOIN pelanggarans p ON s.id = p.siswa_id
LEFT JOIN jenis_pelanggarans j ON p.jenis_pelanggaran_id = j.id
LEFT JOIN prestasis pr ON s.id = pr.siswa_id
WHERE s.status = 'aktif'
GROUP BY s.id;
```

### Ranking Poin Kelas
```sql
SELECT 
  s.nis, s.nama_lengkap,
  SUM(j.poin) - COALESCE(SUM(pr.poin), 0) as saldo_poin
FROM siswas s
LEFT JOIN pelanggarans p ON s.id = p.siswa_id
LEFT JOIN jenis_pelanggarans j ON p.jenis_pelanggaran_id = j.id
LEFT JOIN prestasis pr ON s.id = pr.siswa_id
WHERE s.kelas_id = ? AND s.status = 'aktif'
GROUP BY s.id
ORDER BY saldo_poin ASC;
```

### Siswa Dengan SP Status
```sql
SELECT DISTINCT
  s.id, s.nis, s.nama_lengkap,
  sp.level, sp.tanggal_terbit
FROM siswas s
JOIN surat_peringatan sp ON s.id = sp.siswa_id
WHERE sp.status = 'aktif'
ORDER BY sp.level DESC, sp.tanggal_terbit DESC;
```

---

## 📊 Indices & Performance

**Recommended Indices:**
```sql
-- User lookups
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);

-- Student data
CREATE INDEX idx_siswas_nis ON siswas(nis);
CREATE INDEX idx_siswas_kelas ON siswas(kelas_id);

-- Pelanggaran queries
CREATE INDEX idx_pelanggarans_siswa_tanggal ON pelanggarans(siswa_id, tanggal);
CREATE INDEX idx_pelanggarans_guru ON pelanggarans(guru_input_id);

-- Notifikasi lookups
CREATE INDEX idx_notifikasis_user_read ON notifikasis(user_id, is_read);
```

---

## 🔐 Data Privacy & Security

```sql
-- Soft deletes untuk audit trail
-- Semua tabel punya 'deleted_at' column

-- Passwords selalu di-hash
-- Gunakan bcrypt di Laravel: bcrypt($password)

-- Access control by role
-- Middleware CheckRole mengecek permission sebelum query
```

---

**Last Updated:** January 2026  
**Database Engine:** MySQL 8.0+  
**Charset:** utf8mb4_unicode_ci
