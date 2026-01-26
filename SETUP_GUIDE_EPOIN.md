# 📚 PANDUAN SETUP E-POIN LARAVEL 11

Dokumentasi lengkap untuk setup dan development E-POIN - Platform Manajemen Poin Siswa berbasis Laravel 11.

## 🚀 Instalasi Awal

### Prasyarat
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Git

### Step 1: Clone & Setup Project
```bash
# Masuk ke direktori project
cd d:\Download\cobalaravel\studentpoint

# Install PHP dependencies
composer install

# Copy file environment
copy .env.example .env

# Generate app key
php artisan key:generate

# Install JS dependencies
npm install

# Build frontend assets
npm run build
```

### Step 2: Setup Database
```bash
# Edit .env untuk konfigurasi database
# DB_HOST=localhost
# DB_DATABASE=epoin
# DB_USERNAME=root
# DB_PASSWORD=

# Buat database (MySQL)
mysql -u root -p
CREATE DATABASE epoin CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Jalankan migrations
php artisan migrate

# Seed data dummy (opsional)
php artisan db:seed
```

### Step 3: Install Laravel Breeze (untuk auth)
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
```

### Step 4: Install Packages Tambahan
```bash
# Spatie Permission untuk role management
composer require spatie/laravel-permission

# Excel & PDF handling
composer require maatwebsite/excel barryvdh/laravel-dompdf

# Publishing config
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

### Step 5: Jalankan Application
```bash
# Terminal 1: Jalankan development server
php artisan serve

# Terminal 2: Jalankan Vite dev server
npm run dev

# Akses di browser
# http://localhost:8000
```

---

## 📁 Struktur File Penting

```
studentpoint/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php          [Main redirect]
│   │   │   ├── Guru/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── PelanggaranController.php
│   │   │   │   ├── PrestasiController.php
│   │   │   │   ├── AbsensiController.php
│   │   │   │   ├── UjianController.php
│   │   │   │   ├── SoalController.php
│   │   │   │   ├── NilaiController.php
│   │   │   │   ├── RaporController.php
│   │   │   │   ├── SuratPeringatanController.php
│   │   │   │   └── LaporanController.php
│   │   │   ├── Siswa/
│   │   │   ├── OrangTua/
│   │   │   └── Admin/
│   │   ├── Middleware/
│   │   │   ├── CheckRole.php                   [Role validation]
│   │   │   └── RedirectByRole.php
│   │   └── Requests/                           [Form validation]
│   ├── Models/
│   │   ├── User.php                            [Base user model]
│   │   ├── Siswa.php
│   │   ├── Guru.php
│   │   ├── OrangTua.php
│   │   ├── Kelas.php
│   │   ├── JenisPerlanggaran.php
│   │   ├── Pelanggaran.php
│   │   ├── Prestasi.php
│   │   ├── Absensi.php
│   │   ├── Ujian.php
│   │   ├── Soal.php
│   │   ├── Nilai.php
│   │   ├── Rapor.php
│   │   ├── SuratPeringatan.php
│   │   ├── Notifikasi.php
│   │   └── OrangTua.php
│   └── Services/
│       └── SuratPeringatanService.php           [Business logic]
├── database/
│   ├── migrations/                              [All tables]
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── RoleSeeder.php
│   │   ├── UserSeeder.php
│   │   └── KelasSeeder.php
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php                   [Master layout]
│   │   │   ├── _sidebar-guru.blade.php
│   │   │   ├── _sidebar-siswa.blade.php
│   │   │   ├── _sidebar-orang-tua.blade.php
│   │   │   └── _sidebar-admin.blade.php
│   │   ├── guru/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── pelanggaran/
│   │   │   ├── prestasi/
│   │   │   ├── absensi/
│   │   │   ├── ujian/
│   │   │   ├── nilai/
│   │   │   ├── rapor/
│   │   │   └── surat-peringatan/
│   │   ├── siswa/
│   │   ├── orang-tua/
│   │   ├── admin/
│   │   ├── auth/
│   │   ├── components/
│   │   ├── errors/
│   │   └── welcome.blade.php
│   └── css/
│       └── app.css
├── routes/
│   ├── web.php                                  [Main routes]
│   ├── auth.php
│   └── api.php
├── .env.example
├── phpunit.xml
├── vite.config.js
├── tailwind.config.js
└── README.md
```

---

## 🔐 Sistem Authentikasi & Role

### User Roles
```php
// app/Models/User.php
- 'admin'      → Super admin sekolah
- 'guru'       → Guru/wali kelas
- 'siswa'      → Siswa aktif
- 'orang_tua'  → Orang tua/wali siswa
```

### Login Flow
```
1. User buka login page (satu form untuk semua role)
2. Input email + password
3. System validasi user dari tabel `users`
4. Ambil `role` dari user
5. Generate session/token
6. Redirect ke dashboard sesuai role
```

### Middleware CheckRole
```php
// Penggunaan di routes
Route::middleware(['role:guru'])->prefix('guru')->group(function() {
    // Route guru hanya bisa diakses guru
});

// Atau multiple roles
Route::middleware(['role:admin,guru'])->group(function() {
    // Accessible oleh admin atau guru
});
```

---

## 🗄️ Model Relationships

### User → Siswa/Guru/OrangTua
```php
User (1) ─→ (1) Siswa
User (1) ─→ (1) Guru  
User (1) ─→ (1) OrangTua
```

### Siswa → Kelas
```php
Siswa (Many) ─→ (1) Kelas
Kelas (1) ─→ (Many) Siswa
```

### Pelanggaran & Prestasi
```php
Pelanggaran (Many) ─→ (1) Siswa
Siswa (1) ─→ (Many) Pelanggaran

Prestasi (Many) ─→ (1) Siswa
Siswa (1) ─→ (Many) Prestasi
```

### Ujian → Soal → Nilai
```php
Ujian (1) ─→ (Many) Soal
Ujian (1) ─→ (Many) Nilai

Siswa (1) ─→ (Many) Nilai
```

---

## 🎯 Fitur Utama Per Role

### GURU
✅ Dashboard dengan ringkasan siswa kelas  
✅ Input Pelanggaran (multi-select siswa)  
✅ Input Prestasi  
✅ Input Absensi (harian & per jam)  
✅ Manajemen Ujian CBT  
✅ Input Nilai & e-Rapor  
✅ Generate Surat Peringatan otomatis  
✅ Laporan & Analitik  
✅ Export PDF/Excel  

### SISWA
✅ Dashboard dengan saldo poin real-time  
✅ Lihat riwayat pelanggaran (filter & search)  
✅ Lihat riwayat prestasi  
✅ Status absensi harian & bulanan  
✅ Lihat hasil ujian & nilai  
✅ Download e-Rapor PDF  
✅ Lihat profil lengkap  
❌ Tidak bisa edit/input data  

### ORANG TUA
✅ Dashboard anak dengan saldo poin  
✅ Lihat riwayat pelanggaran anak  
✅ Lihat riwayat prestasi anak  
✅ Monitor absensi anak  
✅ Lihat hasil ujian & nilai anak  
✅ Download e-Rapor anak  
✅ Notifikasi SP atau panggilan  
❌ Semua read-only (tidak bisa edit)  

### ADMIN
✅ Dashboard dengan statistik keseluruhan  
✅ Manage User (create, edit, delete, toggle status)  
✅ Manage Kelas  
✅ Manage Jenis Pelanggaran  
✅ Setting Sekolah (ambang poin, tahun ajaran, dll)  
✅ Laporan keseluruhan dengan export  
✅ Audit log (opsional)  

---

## 📊 Surat Peringatan (Automatis)

Sistem otomatis generate SP ketika poin mencapai threshold:

```php
// Threshold default
SP1 → 10 poin
SP2 → 20 poin
SP3 → 30 poin
SP4 → 40 poin (Dikeluarkan)

// Event: Saat create Pelanggaran
- Call SuratPeringatanService::checkAndCreateSuratPeringatan()
- Generate PDF SP
- Send notifikasi ke orang tua & guru
- Jika SP4, ubah status siswa ke 'dikeluarkan'
```

---

## 🧪 Testing & Seed Data

### Setup Dummy Data
```bash
# Jalankan seeder
php artisan db:seed

# Atau seeder spesifik
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=KelasSeeder
```

### Test User Credentials
```
Admin:
Email: admin@epoin.com
Password: password

Guru:
Email: guru@epoin.com
Password: password

Siswa:
Email: siswa@epoin.com
Password: password

Orang Tua:
Email: orang-tua@epoin.com
Password: password
```

---

## 🛠️ Development Commands

```bash
# Jalankan development server
php artisan serve

# Rebuild Tailwind CSS (jika perlu)
npm run build

# Jalankan queue (untuk async tasks)
php artisan queue:listen

# Generate API docs (jika pakai)
php artisan scribe:generate

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Migrate ulang (reset database)
php artisan migrate:refresh --seed
```

---

## 📱 Mobile Responsiveness

- Sidebar collapse di mobile (trigger button)
- Cards stack vertically di mobile
- Table horizontal scroll di mobile
- Touch-friendly buttons
- Tailwind CSS responsive utilities

---

## 🔄 Workflow Umum

### Input Pelanggaran
1. Guru klik "Input Pelanggaran"
2. Pilih kelas, pilih siswa (multi-select)
3. Pilih jenis pelanggaran → auto-calc poin
4. Input tanggal, jam, deskripsi, bukti (opsional)
5. Submit
6. System otomatis check poin → generate SP jika threshold tercapai
7. Create notifikasi untuk orang tua

### Lihat Status Siswa (Siswa/Orang Tua)
1. Buka Dashboard
2. Lihat saldo poin real-time
3. Lihat grafik tren poin bulanan
4. Lihat notifikasi SP (jika ada)
5. Klik "Riwayat Pelanggaran/Prestasi" untuk detail

### Input Nilai & Rapor (Guru)
1. Guru input nilai siswa per ujian
2. System auto-calculate rata-rata
3. Generate e-Rapor dengan deskripsi template
4. Siswa dapat download PDF rapor

---

## 🐛 Troubleshooting

### "Class not found" Error
- Jalankan: `composer dump-autoload`

### Permission Denied di folder storage
```bash
chmod -R 775 storage bootstrap/cache
```

### Migration error
```bash
php artisan migrate:reset
php artisan migrate
```

### Views tidak ditemukan
- Cek path di `config/view.php`
- Pastikan file `.blade.php` ada di `resources/views/`

---

## 📈 Roadmap Future

1. **Real-time Notifications** (Push notifications + WebSocket)
2. **Advanced Analytics** (Chart.js, data export)
3. **Mobile App** (Flutter/React Native)
4. **E-Jurnal Mengajar** (Documentation modul)
5. **E-Jurnal 7 KAIH** (Komponen penilaian)
6. **Integration dengan Google Classroom**
7. **Automated SMS/Email** untuk notifikasi penting
8. **Multi-school Support** (SaaS model)
9. **API untuk 3rd party integration**
10. **Advanced Reporting** (Pivot tables, custom reports)

---

## 📞 Support & Kontribusi

Untuk pertanyaan atau kontribusi:
- Fork repository
- Buat branch baru: `git checkout -b feature/nama-fitur`
- Commit changes: `git commit -m 'Add nama-fitur'`
- Push: `git push origin feature/nama-fitur`
- Buat Pull Request

---

## 📄 Lisensi

MIT License - Bebas digunakan untuk komersial & pribadi

---

**Last Updated:** January 2026  
**Version:** 1.0.0  
**Laravel Version:** 11.x
