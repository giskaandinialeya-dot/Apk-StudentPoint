# 🎓 StudentPoint – Aplikasi Pengelolaan Data Siswa

StudentPoint adalah aplikasi berbasis web yang digunakan untuk mengelola data siswa dan pengguna dalam lingkungan akademik.  
Aplikasi ini dikembangkan menggunakan Framework Laravel sebagai bagian dari tugas perkuliahan dan media pembelajaran.

---

## Fitur Utama

### 1. Manajemen Data Siswa
- Tambah, edit, dan hapus data siswa
- Menampilkan daftar siswa
- Pencarian data siswa
- Validasi input data

### 2. Manajemen Pengguna
- Pengelolaan akun pengguna
- Hak akses pengguna
- Autentikasi login dan logout

### 3. Autentikasi & Keamanan
- Sistem login pengguna
- Proteksi halaman menggunakan middleware
- Password hashing
- CSRF protection

### 4. Dashboard
- Tampilan dashboard utama
- Ringkasan data aplikasi
- Navigasi fitur aplikasi

## Teknologi

- Framework: Laravel
- Bahasa Pemrograman: PHP
- Database: MySQL / MariaDB
- Frontend: Blade Template
- Web Server: Laragon
- Version Control: Git & GitHub

## Instalasi

### Prerequisites

Pastikan sudah terinstall:
- PHP >= 8.x
- Composer
- MySQL / MariaDB
- Laragon

### Langkah Instalasi

1. Clone repository

    git clone https://github.com/giskaandinialeya-dot/Apk-StudentPoint.git
    cd Apk-StudentPoint
    
2. Install dependency

    composer install
    
3. Konfigurasi environment

    Salin file `.env.example` menjadi `.env`:

    copy .env.example .env

    Atur konfigurasi database pada file `.env`:

    env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=studentpoint
    DB_USERNAME=root
    DB_PASSWORD=


4. Generate application key
   
    php artisan key:generate

6. Import Database

    File database tersedia pada folder:
    database_dump/studentpoint.sql

    Import melalui phpMyAdmin atau MySQL CLI.

7. Jalankan aplikasi

    php artisan serve
    
    Akses melalui browser:
   
    http://localhost:8000
   

## Akun Login Demo

Gunakan akun berikut untuk mencoba aplikasi:

## Akun Login Demo

Gunakan akun berikut untuk mencoba aplikasi StudentPoint:

| Role  | Email              | Password     |
|------|--------------------|--------------|
| Admin | admin1@epoin.com   | password123 |
| Guru  | guru1@epoin.com    | password123 |
| Siswa | Aleya@gmail.com    | 123456      |

> *Akun ini digunakan untuk keperluan demo dan pembelajaran.*


## Struktur Folder

- app/ → Logic aplikasi
- routes/ → Routing
- resources/ → View (Blade)
- database/ → Migration & Seeder
- database_dump/ → File database (.sql)



## Penggunaan

1. Login ke aplikasi menggunakan akun demo
2. Masuk ke dashboard utama
3. Kelola data siswa melalui menu yang tersedia
4. Kelola akun pengguna sesuai kebutuhan



## Catatan

- Aplikasi ini dibuat untuk keperluan akademik
- Tidak digunakan untuk production
- Konfigurasi disesuaikan dengan server lokal


## Developer

- Aleya Giska Andini
- Reki Regian M Sapiq


## Lisensi

Aplikasi ini dibuat untuk keperluan pembelajaran dan tugas perkuliahan.
