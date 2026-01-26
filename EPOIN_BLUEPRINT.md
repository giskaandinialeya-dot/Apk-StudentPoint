# E-POIN Laravel 11 Blueprint - Panduan Lengkap

## 📋 Daftar Isi
1. [Setup Dasar](#setup-dasar)
2. [Struktur Database & Models](#struktur-database--models)
3. [Routes & Middleware](#routes--middleware)
4. [Controllers](#controllers)
5. [Views & Layouts](#views--layouts)
6. [Package Tambahan](#package-tambahan)
7. [Flow Login & Role-Based Access](#flow-login--role-based-access)

---

## Setup Dasar

### Required Packages
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
composer require spatie/laravel-permission
composer require maatwebsite/excel
composer require barryvdh/laravel-dompdf
composer require pusher/pusher-php-server
composer require laravel/echo
```

### Struktur Folder Tambahan
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   ├── Admin/
│   │   ├── Guru/
│   │   ├── Siswa/
│   │   ├── OrangTua/
│   │   └── DashboardController.php
│   ├── Middleware/
│   │   ├── CheckRole.php
│   │   └── Authenticate.php
│   ├── Requests/
│   │   ├── StorePelanggaranRequest.php
│   │   ├── StorePrestasiRequest.php
│   │   └── ...
│   └── Resources/
├── Models/
│   ├── User.php
│   ├── Siswa.php
│   ├── Guru.php
│   ├── OrangTua.php
│   ├── Kelas.php
│   ├── JenisPerlanggaran.php
│   ├── Pelanggaran.php
│   ├── Prestasi.php
│   ├── Absensi.php
│   ├── Ujian.php
│   ├── Soal.php
│   ├── Nilai.php
│   ├── Rapor.php
│   ├── SuratPeringatan.php
│   └── Notifikasi.php
├── Traits/
│   └── HasRole.php
└── Services/
    ├── PelanggaranService.php
    ├── PrestasiService.php
    └── SuratPeringatanService.php

database/
├── migrations/
│   ├── [timestamp]_create_roles_table.php
│   ├── [timestamp]_create_siswas_table.php
│   ├── [timestamp]_create_gurus_table.php
│   ├── [timestamp]_create_orang_tuas_table.php
│   ├── [timestamp]_create_kelas_table.php
│   ├── [timestamp]_create_jenis_pelanggarans_table.php
│   ├── [timestamp]_create_pelanggarans_table.php
│   ├── [timestamp]_create_prestasis_table.php
│   ├── [timestamp]_create_absentis_table.php
│   ├── [timestamp]_create_ujians_table.php
│   ├── [timestamp]_create_soals_table.php
│   ├── [timestamp]_create_nilais_table.php
│   ├── [timestamp]_create_rapors_table.php
│   ├── [timestamp]_create_surat_peringatan_table.php
│   └── [timestamp]_create_notifikasis_table.php
└── seeders/
    ├── DatabaseSeeder.php
    ├── RoleSeeder.php
    ├── UserSeeder.php
    ├── KelasSeeder.php
    └── JenisPeranggaranSeeder.php

resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php (master layout)
│   │   ├── auth.blade.php
│   │   └── _sidebar.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── dashboard/
│   │   ├── guru/
│   │   │   ├── index.blade.php
│   │   │   ├── pelanggaran.blade.php
│   │   │   ├── prestasi.blade.php
│   │   │   ├── absensi.blade.php
│   │   │   ├── ujian/
│   │   │   ├── rapor.blade.php
│   │   │   └── surat-peringatan.blade.php
│   │   ├── siswa/
│   │   │   ├── index.blade.php
│   │   │   ├── riwayat-pelanggaran.blade.php
│   │   │   ├── riwayat-prestasi.blade.php
│   │   │   └── ...
│   │   ├── orang-tua/
│   │   │   └── index.blade.php
│   │   └── admin/
│   │       └── index.blade.php
│   ├── components/
│   │   ├── sidebar.blade.php
│   │   ├── header.blade.php
│   │   ├── stat-card.blade.php
│   │   └── chart.blade.php
│   └── errors/
│       ├── 401.blade.php
│       └── 403.blade.php
```

---

## Struktur Database & Models

### Role-Based User Structure
- **Admin (Superadmin Sekolah)**: Full access ke semua menu & setting
- **Guru**: Akses menu guru (input pelanggaran, prestasi, absensi, CBT, rapor, SP)
- **Siswa**: Akses terbatas (lihat riwayat & nilai sendiri)
- **Orang Tua**: Read-only akses ke data anak

### Model Relasi

```
User (1:1 ke Siswa, Guru, atau OrangTua)
├── role (enum: admin, guru, siswa, orang_tua)
├── email
├── password
├── is_active
└── last_login

Siswa
├── user_id (FK)
├── nis
├── nama
├── kelas_id (FK)
├── tahun_ajaran
├── semester
└── foto

Guru
├── user_id (FK)
├── nip
├── nama
├── spesialisasi (mata pelajaran)
├── kelas_wali_id (FK ke Kelas)
└── foto

OrangTua
├── user_id (FK)
├── siswa_id (FK)
├── hubungan (ayah/ibu/wali)
├── nama
├── kontak
└── alamat

Kelas
├── nama (X IPA 1)
├── wali_guru_id (FK ke Guru)
├── tahun_ajaran
├── semester
└── jumlah_siswa

JenisPerlanggaran
├── nama
├── poin
├── kategori (ringan/sedang/berat)
├── keterangan
└── auto_sp_level

Pelanggaran
├── siswa_id (FK)
├── guru_input_id (FK ke User)
├── jenis_pelanggaran_id (FK)
├── tanggal
├── jam
├── deskripsi
└── bukti_file

Prestasi
├── siswa_id (FK)
├── guru_input_id (FK ke User)
├── nama_prestasi
├── poin
├── tanggal
├── tingkat (kelas/sekolah/regional/nasional)
└── bukti_file

Absensi
├── siswa_id (FK)
├── guru_input_id (FK ke User)
├── tanggal
├── jam_ke (1-8)
├── status (hadir/sakit/izin/alfa)
├── keterangan
└── sinkronisasi_at

Ujian
├── nama
├── guru_id (FK ke User)
├── kelas_id (FK)
├── mata_pelajaran
├── tipe (online/offline)
├── tanggal_mulai
├── tanggal_selesai
├── durasi_menit
├── kkm
├── jumlah_soal
└── status

Soal
├── ujian_id (FK)
├── urutan
├── pertanyaan
├── tipe (pilihan_ganda/essay/true_false)
├── opsional (A, B, C, D, E)
├── jawaban_benar
└── bobot

Nilai
├── siswa_id (FK)
├── ujian_id (FK)
├── guru_id (FK ke User)
├── skor
├── jawaban_file
├── nilai_akhir
├── status (draft/sudah_nilai/selesai)
└── tanggal_input

Rapor
├── siswa_id (FK)
├── tahun_ajaran
├── semester
├── guru_id (FK ke User)
├── mata_pelajaran
├── nilai_akhir
├── nilai_huruf
├── deskripsi
├── keterangan
└── tanggal_input

SuratPeringatan
├── siswa_id (FK)
├── level (1/2/3/4)
├── total_poin
├── tanggal_terbit
├── alasan
├── file_pdf
├── status (aktif/dibatalkan)
└── tanda_tangan_guru

Notifikasi
├── user_id (FK)
├── tipe (poin_kritis/sp/panggilan_ortu)
├── judul
├── deskripsi
├── siswa_id (FK opsional)
├── is_read
└── created_at
```

---

## Routes & Middleware

### Route Groups dengan Middleware Role

```php
// Public Routes
Route::get('/', 'HomeController@index')->name('home');
Route::post('/login', 'LoginController@store')->name('login.store');

// Authenticated Routes dengan Role Check
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Dashboard berbeda per role
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    
    // ADMIN Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::resource('users', 'Admin\UserController');
        Route::resource('kelas', 'Admin\KelasController');
        Route::resource('jenis-pelanggaran', 'Admin\JenisPelanggaranController');
        Route::get('laporan', 'Admin\LaporanController@index')->name('laporan.index');
    });
    
    // GURU Routes
    Route::middleware(['role:guru'])->prefix('guru')->group(function () {
        Route::resource('pelanggaran', 'Guru\PelanggaranController');
        Route::resource('prestasi', 'Guru\PrestasiController');
        Route::resource('absensi', 'Guru\AbsensiController');
        Route::resource('ujian', 'Guru\UjianController');
        Route::resource('soal', 'Guru\SoalController');
        Route::resource('nilai', 'Guru\NilaiController');
        Route::resource('rapor', 'Guru\RaporController');
        Route::resource('surat-peringatan', 'Guru\SuratPeringatanController');
        Route::get('laporan', 'Guru\LaporanController@index')->name('guru.laporan');
    });
    
    // SISWA Routes
    Route::middleware(['role:siswa'])->prefix('siswa')->group(function () {
        Route::get('riwayat-pelanggaran', 'Siswa\RiwayatPelanggaranController@index');
        Route::get('riwayat-prestasi', 'Siswa\RiwayatPrestasiController@index');
        Route::get('absensi', 'Siswa\AbsensiController@index');
        Route::get('nilai', 'Siswa\NilaiController@index');
        Route::get('rapor', 'Siswa\RaporController@index');
        Route::get('profil', 'Siswa\ProfilController@index');
    });
    
    // ORANG TUA Routes
    Route::middleware(['role:orang_tua'])->prefix('orang-tua')->group(function () {
        Route::get('dashboard', 'OrangTua\DashboardController@index');
        Route::get('anak/{siswa}', 'OrangTua\AnakController@show');
    });
});
```

---

## Controllers

### Main Controllers Structure
- `DashboardController` - Redirect ke dashboard sesuai role
- `Guru/PelanggaranController` - CRUD pelanggaran
- `Guru/PrestasiController` - CRUD prestasi
- `Guru/AbsensiController` - Input absensi
- `Guru/UjianController` - Kelola ujian CBT
- `Guru/NilaiController` - Input nilai
- `Guru/RaporController` - Input rapor
- `Guru/SuratPeringatanController` - Generate SP otomatis
- `Siswa/*Controller` - Read-only untuk siswa
- `OrangTua/*Controller` - Read-only untuk orang tua
- `Admin/*Controller` - Full CRUD untuk admin

---

## Views & Layouts

### Master Layout (app.blade.php)
- Header dengan user profile, notifikasi bell, logout
- Sidebar dengan menu dinamis sesuai role
- Breadcrumb navigation
- Flash message & toast notification
- Mobile responsive dengan sidebar collapse

### Sidebar Menu per Role
**GURU:**
- Dashboard
- Input Pelanggaran
- Input Prestasi
- Absensi Harian
- Absensi Per Mata Pelajaran
- Ujian CBT
- e-Rapor
- Surat Peringatan
- Laporan & Analitik
- Pengaturan

**SISWA:**
- Dashboard
- Riwayat Pelanggaran
- Riwayat Prestasi
- Absensi Saya
- Hasil Ujian & Nilai
- e-Rapor Saya
- Profil Saya

**ORANG TUA:**
- Dashboard Anak
- Riwayat Pelanggaran Anak
- Riwayat Prestasi Anak
- Absensi Anak
- Hasil Ujian & Nilai Anak
- e-Rapor Anak
- Profil Anak

**ADMIN:**
- Dashboard
- Kelola User
- Kelola Kelas
- Kelola Jenis Pelanggaran
- Setting Sekolah
- Laporan Keseluruhan

---

## Package Tambahan

```json
{
    "require": {
        "spatie/laravel-permission": "^6.0",
        "maatwebsite/excel": "^3.1",
        "barryvdh/laravel-dompdf": "^2.0",
        "pusher/pusher-php-server": "^7.2",
        "laravel/echo": "^1.17"
    },
    "require-dev": {
        "laravel/pint": "^1.0",
        "phpunit/phpunit": "^9.5"
    }
}
```

---

## Flow Login & Role-Based Access

### Login Process
1. User buka login page (satu halaman untuk semua role)
2. Input email/username + password
3. Sistem validasi user dari tabel `users`
4. Ambil `role` dari user
5. Redirect ke dashboard sesuai role via middleware
6. Dashboard menampilkan menu & konten sesuai role

### Middleware: CheckRole
```php
// Cek apakah user memiliki role yang sesuai
// Jika tidak, redirect ke 403 Forbidden
```

### Access Control
- Siswa hanya bisa lihat data diri sendiri
- Orang tua hanya bisa lihat data anak mereka
- Guru bisa lihat siswa di kelas yang diampu
- Admin bisa lihat semua data

---

## Next Steps
1. Install Breeze & Spatie Permission
2. Run migrations
3. Seed data dummy
4. Implementasi controllers
5. Buat views sesuai design
6. Testing multi-role login
7. Implementasi real-time notification
8. Export PDF/Excel untuk laporan

