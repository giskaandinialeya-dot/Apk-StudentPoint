# 🔌 E-POIN API Endpoints Reference

Dokumentasi lengkap API endpoints yang dapat dikembangkan untuk mobile app atau integrasi third-party.

---

## 📌 API Base URL

```
Development: http://localhost:8000/api
Production: https://epoin.school.com/api
```

**API Version:** v1

---

## 🔐 Authentication

### Login & Get Token

```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "guru1@epoin.com",
  "password": "password"
}

Response 200:
{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "user": {
      "id": 2,
      "name": "Guru Satu",
      "email": "guru1@epoin.com",
      "role": "guru"
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
  }
}
```

### Logout
```http
POST /api/v1/auth/logout
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "message": "Logout berhasil"
}
```

### Get Current User
```http
GET /api/v1/auth/me
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "user": {
      "id": 2,
      "name": "Guru Satu",
      "email": "guru1@epoin.com",
      "role": "guru"
    }
  }
}
```

---

## 📚 Guru Endpoints

### Dashboard Data
```http
GET /api/v1/guru/dashboard
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "stats": {
      "jumlah_siswa": 30,
      "pelanggaran_hari_ini": 2,
      "prestasi_hari_ini": 1,
      "persentase_kehadiran": 85.5
    },
    "recent_activity": [
      {
        "id": 1,
        "type": "pelanggaran",
        "siswa": "Andi Wijaya",
        "deskripsi": "Terlambat masuk kelas",
        "tanggal": "2024-01-23T08:30:00Z"
      }
    ],
    "siswa_poin_kritis": [
      {
        "id": 5,
        "nis": "005",
        "nama": "Budi Santoso",
        "total_poin": 28,
        "status_sp": "akan_sp4"
      }
    ]
  }
}
```

### List Pelanggaran (Violations)
```http
GET /api/v1/guru/pelanggaran?page=1&per_page=10&status=aktif&tanggal_dari=2024-01-01&tanggal_sampai=2024-01-31
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "siswa": {
          "id": 1,
          "nis": "001",
          "nama": "Andi Wijaya"
        },
        "jenis_pelanggaran": {
          "id": 1,
          "nama": "Terlambat Datang",
          "poin": 1,
          "kategori": "ringan"
        },
        "tanggal": "2024-01-23",
        "jam": "08:30:00",
        "deskripsi": "Terlambat 15 menit",
        "bukti_file": "https://...",
        "status": "aktif",
        "created_at": "2024-01-23T08:30:00Z"
      }
    ],
    "total": 45,
    "per_page": 10,
    "last_page": 5
  }
}
```

### Create Pelanggaran
```http
POST /api/v1/guru/pelanggaran
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
  "siswa_ids[]": [1, 2],
  "jenis_pelanggaran_id": 1,
  "tanggal": "2024-01-23",
  "jam": "08:30",
  "deskripsi": "Terlambat masuk kelas",
  "bukti_file": (file)
}

Response 201:
{
  "success": true,
  "message": "Pelanggaran berhasil ditambahkan untuk 2 siswa",
  "data": {
    "pelanggaran_ids": [45, 46],
    "total_created": 2,
    "notifikasi_sent": 2
  }
}
```

### Update Pelanggaran
```http
PUT /api/v1/guru/pelanggaran/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "jenis_pelanggaran_id": 2,
  "tanggal": "2024-01-24",
  "deskripsi": "Update deskripsi"
}

Response 200:
{
  "success": true,
  "message": "Pelanggaran berhasil diperbarui"
}
```

### Delete Pelanggaran
```http
DELETE /api/v1/guru/pelanggaran/{id}
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "message": "Pelanggaran berhasil dihapus"
}
```

### List Prestasi (Achievements)
```http
GET /api/v1/guru/prestasi?page=1&siswa_id=1
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "siswa": {"id": 1, "nama": "Andi Wijaya"},
        "nama_prestasi": "Juara 1 Lomba Matematika",
        "poin": 5,
        "tanggal": "2024-01-20",
        "tingkat": "sekolah",
        "created_at": "2024-01-20T10:00:00Z"
      }
    ],
    "total": 12
  }
}
```

### Create Prestasi
```http
POST /api/v1/guru/prestasi
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
  "siswa_ids[]": [1, 3],
  "nama_prestasi": "Juara 1 Lomba Matematika",
  "poin": 5,
  "tanggal": "2024-01-20",
  "tingkat": "sekolah"
}

Response 201:
{
  "success": true,
  "message": "Prestasi ditambahkan untuk 2 siswa"
}
```

### List Absensi (Attendance)
```http
GET /api/v1/guru/absensi?tanggal=2024-01-23&kelas_id=1
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "tanggal": "2024-01-23",
    "kelas": {"id": 1, "nama": "X IPA 1"},
    "absensi": [
      {
        "siswa_id": 1,
        "nis": "001",
        "nama": "Andi Wijaya",
        "jam_ke": [
          {"jam": 1, "status": "hadir"},
          {"jam": 2, "status": "izin"},
          {"jam": 3, "status": "hadir"}
        ]
      }
    ]
  }
}
```

### Bulk Input Absensi
```http
POST /api/v1/guru/absensi/bulk
Authorization: Bearer {token}
Content-Type: application/json

{
  "tanggal": "2024-01-23",
  "kelas_id": 1,
  "absensi": [
    {
      "siswa_id": 1,
      "jam_ke": 1,
      "status": "hadir"
    },
    {
      "siswa_id": 1,
      "jam_ke": 2,
      "status": "izin"
    }
  ]
}

Response 200:
{
  "success": true,
  "message": "Absensi berhasil disimpan untuk 1 tanggal, 8 jam pelajaran"
}
```

---

## 👨‍🎓 Siswa Endpoints

### Dashboard
```http
GET /api/v1/siswa/dashboard
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "siswa": {
      "id": 1,
      "nis": "001",
      "nama": "Andi Wijaya",
      "kelas": "X IPA 1"
    },
    "poin": {
      "total_pelanggaran": 5,
      "total_prestasi": 8,
      "saldo": 3
    },
    "kehadiran": {
      "status_hari_ini": "hadir",
      "bulan_ini": {
        "hadir": 20,
        "sakit": 1,
        "izin": 2,
        "alfa": 0
      }
    },
    "notifikasi_sp": null
  }
}
```

### Riwayat Pelanggaran
```http
GET /api/v1/siswa/pelanggaran?page=1&bulan=01&tahun=2024
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "jenis": "Terlambat Datang",
        "poin": 1,
        "tanggal": "2024-01-23",
        "jam": "08:30",
        "keterangan": "Terlambat 15 menit",
        "guru": "Guru Satu"
      }
    ],
    "total": 5
  }
}
```

### Riwayat Prestasi
```http
GET /api/v1/siswa/prestasi?page=1
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "data": [
      {
        "id": 1,
        "nama": "Juara 1 Lomba Matematika",
        "poin": 5,
        "tanggal": "2024-01-20",
        "tingkat": "sekolah"
      }
    ],
    "total": 8
  }
}
```

### Nilai Ujian
```http
GET /api/v1/siswa/nilai?page=1
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "data": [
      {
        "id": 1,
        "ujian": "Ujian Tengah Semester Matematika",
        "mata_pelajaran": "Matematika",
        "skor": 85,
        "nilai_akhir": 85,
        "nilai_huruf": "B",
        "kkm": 70,
        "status_lulus": true,
        "tanggal": "2024-01-20"
      }
    ],
    "rata_rata_nilai": 82.5
  }
}
```

### Download e-Rapor
```http
GET /api/v1/siswa/rapor/{id}/download
Authorization: Bearer {token}

Response: PDF file (application/pdf)
```

---

## 👨‍👩‍👧 Orang Tua Endpoints

### Dashboard Anak
```http
GET /api/v1/orang-tua/dashboard
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "anak": {
      "id": 1,
      "nis": "001",
      "nama": "Andi Wijaya",
      "kelas": "X IPA 1"
    },
    "poin": {
      "saldo": 3,
      "status_kritis": false
    },
    "kehadiran_hari_ini": "hadir",
    "sp_aktif": null,
    "notifikasi_penting": []
  }
}
```

### Lihat Nilai Anak
```http
GET /api/v1/orang-tua/anak/{anak_id}/nilai?page=1
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "anak": "Andi Wijaya",
    "nilai": [
      {
        "ujian": "UTS Matematika",
        "mata_pelajaran": "Matematika",
        "nilai": 85,
        "nilai_huruf": "B",
        "kkm": 70,
        "lulus": true
      }
    ]
  }
}
```

### Lihat Pelanggaran Anak
```http
GET /api/v1/orang-tua/anak/{anak_id}/pelanggaran?page=1
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "anak": "Andi Wijaya",
    "total_poin": 5,
    "pelanggaran": [
      {
        "id": 1,
        "jenis": "Terlambat",
        "poin": 1,
        "tanggal": "2024-01-23"
      }
    ]
  }
}
```

---

## 🛠️ Utility Endpoints

### List Jenis Pelanggaran
```http
GET /api/v1/jenis-pelanggaran
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nama": "Terlambat Datang",
      "poin": 1,
      "kategori": "ringan"
    },
    {
      "id": 2,
      "nama": "Bolos Kelas",
      "poin": 5,
      "kategori": "sedang"
    }
  ]
}
```

### List Kelas
```http
GET /api/v1/kelas?tahun_ajaran=2024/2025
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nama": "X IPA 1",
      "tingkat": "10",
      "wali_guru": "Guru Satu",
      "total_siswa": 30
    }
  ]
}
```

### Get Siswa by Kelas
```http
GET /api/v1/kelas/{id}/siswa
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "kelas": "X IPA 1",
    "siswa": [
      {
        "id": 1,
        "nis": "001",
        "nama": "Andi Wijaya",
        "saldo_poin": 3
      }
    ]
  }
}
```

### Statistik Guru Bulanan
```http
GET /api/v1/guru/statistik?bulan=01&tahun=2024
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "bulan": "Januari",
    "tahun": 2024,
    "total_pelanggaran": 15,
    "total_prestasi": 8,
    "siswa_kritis": 2,
    "rata_kehadiran": 92.5,
    "trend": {
      "minggu_1": 3,
      "minggu_2": 4,
      "minggu_3": 5,
      "minggu_4": 3
    }
  }
}
```

---

## 🔍 Query Parameters

### Pagination
```
?page=1&per_page=10
```

### Filtering
```
?status=aktif
?tanggal_dari=2024-01-01&tanggal_sampai=2024-01-31
?bulan=01&tahun=2024
?siswa_id=1
?kelas_id=1
```

### Sorting
```
?sort=created_at&order=desc
?sort=nama&order=asc
```

---

## 📊 Response Format

### Success Response
```json
{
  "success": true,
  "message": "Data retrieved successfully",
  "data": {}
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message here",
  "errors": {
    "field_name": ["Error detail"]
  }
}
```

### Validation Error (422)
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "siswa_ids": ["Pilih minimal 1 siswa"],
    "jenis_pelanggaran_id": ["Jenis pelanggaran harus dipilih"],
    "tanggal": ["Tanggal harus valid"]
  }
}
```

---

## 🔐 Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Request successful |
| 201 | Created - Resource created |
| 204 | No Content - Success with no response body |
| 400 | Bad Request - Invalid parameters |
| 401 | Unauthorized - Invalid or missing token |
| 403 | Forbidden - Insufficient permissions |
| 404 | Not Found - Resource not found |
| 422 | Unprocessable Entity - Validation error |
| 500 | Internal Server Error |

---

## 🚀 Example: Complete Workflow

### 1. Login
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "guru1@epoin.com",
    "password": "password"
  }'
```

**Response:** Token received

### 2. Get Dashboard
```bash
curl -X GET http://localhost:8000/api/v1/guru/dashboard \
  -H "Authorization: Bearer {token}"
```

### 3. Input Pelanggaran
```bash
curl -X POST http://localhost:8000/api/v1/guru/pelanggaran \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "siswa_ids": [1],
    "jenis_pelanggaran_id": 1,
    "tanggal": "2024-01-23",
    "jam": "08:30",
    "deskripsi": "Terlambat"
  }'
```

---

## 📱 Mobile App Integration

### Recommended Flow
1. **Login** → Get token (simpan di local storage/secure storage)
2. **Load Dashboard** → Show stats & recent activity
3. **List Pelanggaran** → With pagination & filters
4. **Create Pelanggaran** → Multi-select siswa, upload bukti
5. **View Profil Siswa** → Detailed info & history
6. **Logout** → Clear token

### Token Refresh (Optional Enhancement)
```http
POST /api/v1/auth/refresh
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "token": "new_token_here"
}
```

---

## 📝 Rate Limiting (Recommended)

```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
X-RateLimit-Reset: 1234567890
```

Max 60 requests per minute per user.

---

**API Version:** v1.0  
**Last Updated:** January 2026  
**Base URL:** `/api/v1`

---

**Next Step:** 
Consider implementing these endpoints using Laravel Resources & API Routes for mobile app development!
