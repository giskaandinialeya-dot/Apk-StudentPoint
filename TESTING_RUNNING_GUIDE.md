# 🚀 E-POIN Testing & Running Guide

Panduan lengkap untuk menjalankan, testing, dan troubleshooting aplikasi E-POIN.

---

## ✅ Pre-Run Checklist

Sebelum menjalankan aplikasi, pastikan:

- [ ] PHP 8.3+ ter-install (`php -v`)
- [ ] Composer ter-install (`composer --version`)
- [ ] Node.js & npm ter-install (`node -v`, `npm -v`)
- [ ] MySQL/MariaDB running (`mysql -u root`)
- [ ] `.env` file sudah dikonfigurasi (copy dari `.env.example`)
- [ ] `APP_KEY` sudah generate (`php artisan key:generate`)

---

## 🔧 Setup Awal (First Time)

### 1. Clone/Extract Repository
```bash
cd d:\Download\cobalaravel\studentpoint
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Frontend Dependencies
```bash
npm install
```

### 4. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Edit .env untuk database
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=epoin_db
# DB_USERNAME=root
# DB_PASSWORD=
```

### 5. Create Database
```bash
# Gunakan MySQL/MariaDB admin tool atau:
mysql -u root -p -e "CREATE DATABASE epoin_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 6. Run Migrations & Seeders
```bash
# Run semua migrations
php artisan migrate

# Seed database dengan test data
php artisan db:seed

# Atau gabung dalam satu command
php artisan migrate --seed
```

**Expected Output:**
```
Migrating: 2024_01_23_000001_create_users_table
Migrated: 2024_01_23_000001_create_users_table (1.23s)
...
Seeding: Database\Seeders\UserSeeder
Seeded: Database\Seeders\UserSeeder (0.45s)
✓ Database ready!
```

---

## 🎯 Running Application

### Development Mode

#### Terminal 1 - Laravel Development Server
```bash
php artisan serve
# Output: Laravel development server started: http://127.0.0.1:8000
```

#### Terminal 2 - Vite Frontend Build (Watch Mode)
```bash
npm run dev
# Output: VITE v5.0.0 ready in 245 ms
#         ➜  Local:   http://localhost:5173/
```

**Akses aplikasi:** http://localhost:8000

---

### Production Mode (Local Testing)

#### 1. Build Frontend Assets
```bash
npm run build
```

#### 2. Setup for Production
```bash
# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

#### 3. Run Server
```bash
php artisan serve
```

---

## 🔐 Test Credentials

Setelah `php artisan migrate --seed`, test dengan akun berikut:

### Admin
```
Email: admin@epoin.com
Password: password
Role: Admin
```

### Guru (Teacher)
```
Email: guru1@epoin.com
Password: password
Role: Guru
Kelas Wali: X IPA 1

Email: guru2@epoin.com
Password: password
Role: Guru
Kelas Wali: X IPA 2
```

### Siswa (Student)
```
Email: siswa1@epoin.com
Password: password
Role: Siswa
NIS: 001
Kelas: X IPA 1

Email: siswa2@epoin.com
Password: password
Role: Siswa
NIS: 002
Kelas: X IPA 1

Email: siswa3@epoin.com
Password: password
Role: Siswa
NIS: 003
Kelas: X IPA 2
```

### Orang Tua (Parent)
```
Email: ortu1@epoin.com
Password: password
Role: Orang Tua
Anak: siswa1 (X IPA 1)

Email: ortu2@epoin.com
Password: password
Role: Orang Tua
Anak: siswa2 (X IPA 1)
```

---

## 🧪 Testing Workflows

### Test 1: Role-Based Authentication Flow

1. **Login sebagai Admin**
   - Go to: http://localhost:8000/login
   - Email: `admin@epoin.com`, Password: `password`
   - Expected: Redirect to `/dashboard` → `/admin/dashboard`

2. **Login sebagai Guru**
   - Logout dan login dengan `guru1@epoin.com`
   - Expected: Redirect to `/guru/dashboard`
   - Verify: See "X IPA 1" in sidebar

3. **Login sebagai Siswa**
   - Logout dan login dengan `siswa1@epoin.com`
   - Expected: Redirect to `/siswa/dashboard`
   - Verify: See personal data

4. **Login sebagai Orang Tua**
   - Logout dan login dengan `ortu1@epoin.com`
   - Expected: Redirect to `/orang-tua/dashboard`
   - Verify: See child's data

---

### Test 2: Guru Dashboard

**Akun:** guru1@epoin.com

1. Go to: http://localhost:8000/guru/dashboard
2. Verify sections:
   - [ ] Stat cards (Jumlah Siswa, Pelanggaran, Prestasi, Kehadiran)
   - [ ] Recent Activity (10 items)
   - [ ] Siswa Poin Kritis (alert jika ada)
   - [ ] Ranking Saldo Poin (top 5)
   - [ ] Kelas Info

---

### Test 3: Input Pelanggaran (Violation)

**Akun:** guru1@epoin.com

1. Go to: http://localhost:8000/guru/pelanggaran
2. Click "Tambah Pelanggaran"
3. **Form Inputs:**
   - Siswa: `siswa1` (select)
   - Jenis Pelanggaran: `Terlambat Datang` (1 poin)
   - Tanggal: Today
   - Jam: 08:00
   - Deskripsi: "Terlambat masuk kelas 15 menit"
   - Bukti File: (optional)
4. Click "Simpan"
5. **Expected:**
   - Pelanggaran record created
   - siswa1 total poin updated
   - Notifikasi created for parent
   - ✓ Redirect to `/guru/pelanggaran`

**Database Verification:**
```bash
mysql> SELECT * FROM pelanggarans WHERE siswa_id = 1 ORDER BY created_at DESC LIMIT 1;
mysql> SELECT * FROM notifikasis WHERE siswa_id = 1 ORDER BY created_at DESC LIMIT 1;
```

---

### Test 4: Trigger Surat Peringatan (Auto-SP Generation)

**Goal:** Test automatic SP generation saat poin > threshold

1. **As guru1, input 10 pelanggaran untuk siswa1:**
   - Setiap 1 poin → 10x input Terlambat (1 poin each)
   - Total = 10 poin → Trigger SP1

2. **Verification:**
   ```bash
   # Check surat_peringatan table
   mysql> SELECT * FROM surat_peringatan WHERE siswa_id = 1;
   # Expected: 1 record dengan level=1
   ```

3. **Next Test:**
   - Input 10 more violations → total 20 poin
   - Expected: SP2 created

---

### Test 5: Siswa Dashboard

**Akun:** siswa1@epoin.com

1. Go to: http://localhost:8000/siswa/dashboard
2. Verify display:
   - [ ] Saldo Poin (current calculation)
   - [ ] Total Pelanggaran
   - [ ] Total Prestasi
   - [ ] Kehadiran Hari Ini
   - [ ] Recent Activity
   - [ ] Warning jika ada SP aktif

---

### Test 6: Orang Tua Dashboard

**Akun:** ortu1@epoin.com

1. Go to: http://localhost:8000/orang-tua/dashboard
2. Verify display:
   - [ ] Anak name (siswa1)
   - [ ] Saldo poin anak
   - [ ] Kehadiran anak
   - [ ] Notifikasi SP jika ada

---

## 🐛 Troubleshooting

### Error: "No application key has been generated"
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000]: General error: 1030"
```bash
# Database hasn't been created
mysql -u root -p
mysql> CREATE DATABASE epoin_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Or reset database
php artisan migrate:fresh --seed
```

### Error: "Class 'App\Models\Siswa' not found"
```bash
# Autoloader hasn't been updated
composer dump-autoload
```

### Error: "npm ERR! code ERESOLVE"
```bash
# Dependency conflict - force resolve
npm install --legacy-peer-deps
```

### Error: "VITE not found" or "npm run dev fails"
```bash
# Reinstall frontend dependencies
rm -rf node_modules package-lock.json
npm install
npm run dev
```

### Port 8000 already in use
```bash
# Use different port
php artisan serve --port=8001
```

### Routes not showing in `/routes`
```bash
# Clear route cache
php artisan route:clear
```

### Migrations failing
```bash
# Rollback all migrations
php artisan migrate:reset

# Create fresh database
php artisan migrate --seed
```

---

## 📊 Database Inspection

### Check Users
```bash
mysql> SELECT id, name, email, role FROM users;
```

### Check Siswas
```bash
mysql> SELECT s.id, s.nis, s.nama_lengkap, k.nama as kelas FROM siswas s LEFT JOIN kelas k ON s.kelas_id = k.id;
```

### Check Pelanggaran
```bash
mysql> SELECT p.id, s.nama_lengkap, jp.nama, p.tanggal FROM pelanggarans p 
       JOIN siswas s ON p.siswa_id = s.id 
       JOIN jenis_pelanggarans jp ON p.jenis_pelanggaran_id = jp.id;
```

### Check Surat Peringatan
```bash
mysql> SELECT sp.id, sp.level, s.nama_lengkap, sp.tanggal_terbit, sp.status 
       FROM surat_peringatan sp 
       JOIN siswas s ON sp.siswa_id = s.id;
```

---

## 📋 Testing Checklist

| Feature | Test Case | Status |
|---------|-----------|--------|
| Admin Login | Access `/admin/dashboard` | [ ] |
| Guru Login | Access `/guru/dashboard` | [ ] |
| Siswa Login | Access `/siswa/dashboard` | [ ] |
| OrangTua Login | Access `/orang-tua/dashboard` | [ ] |
| Input Pelanggaran | Create violation record | [ ] |
| Auto SP Generation | SP1 created at 10 poin | [ ] |
| Notifikasi | Notification created | [ ] |
| Role Access Control | Siswa cannot access guru routes | [ ] |
| Sidebar Display | Correct menu per role | [ ] |
| Database Relations | All foreign keys working | [ ] |

---

## 🚀 Deployment Checklist

Before deploying to production:

- [ ] `.env` configured for production
- [ ] `APP_DEBUG=false`
- [ ] Database backed up
- [ ] Frontend assets built (`npm run build`)
- [ ] Routes cached (`php artisan route:cache`)
- [ ] Config cached (`php artisan config:cache`)
- [ ] Views cached (`php artisan view:cache`)
- [ ] SSL certificate installed
- [ ] Database migrations run on production (`php artisan migrate`)
- [ ] Cron job configured for scheduled tasks
- [ ] Mail service configured (for notifications)
- [ ] Storage permissions set correctly

---

## 💬 Common Tasks

### Reset Database
```bash
php artisan migrate:fresh --seed
```

### Create New User (Manual)
```bash
php artisan tinker
```
```php
$user = User::create([
    'name' => 'Test User',
    'email' => 'test@epoin.com',
    'password' => bcrypt('password'),
    'role' => 'siswa'
]);
```

### Export Database
```bash
mysqldump -u root epoin_db > backup.sql
```

### Import Database
```bash
mysql -u root epoin_db < backup.sql
```

### View Application Logs
```bash
tail -f storage/logs/laravel.log

# Or
php artisan log:tail
```

---

**Next Steps:**
1. Run `php artisan migrate --seed`
2. Start dev server: `php artisan serve`
3. Open http://localhost:8000
4. Login and test workflows above
5. Report issues with screenshots & logs

**Need Help?**
- Check logs: `storage/logs/laravel.log`
- Database issues: `php artisan tinker`
- Clear cache: `php artisan cache:clear`
- Debug mode: `APP_DEBUG=true` in `.env`
