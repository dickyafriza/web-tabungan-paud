# API Documentation - Sistem Tabungan PAUD

## 📋 Overview

Dokumentasi API untuk Sistem Tabungan PAUD Terpadu Cerdas. API ini menyediakan endpoint untuk manajemen tabungan siswa, pembayaran SPP, dan autentikasi pengguna.

**Base URL:** `http://localhost:8001/api`

---

## 2.7.1 Authentication (AUTH)

Sistem autentikasi menggunakan **JWT (JSON Web Token)** melalui package `tymon/jwt-auth`.

### Daftar Endpoint Authentication

| No | Endpoint | Method | Deskripsi | Auth Required |
|----|----------|--------|-----------|---------------|
| 1 | `/api/auth/register` | POST | Registrasi user baru | ❌ |
| 2 | `/api/auth/login` | POST | Login dengan email & password | ❌ |
| 3 | `/api/auth/me` | GET | Mendapatkan data user yang sedang login | ✅ Bearer Token |
| 4 | `/api/auth/refresh` | POST | Memperbarui JWT token yang akan expired | ✅ Bearer Token |
| 5 | `/api/auth/logout` | POST | Logout dan invalidate token | ✅ Bearer Token |

---

### 1. Register

**Endpoint:** `POST /api/auth/register`

**Request Body:**
```json
{
    "name": "Admin PAUD",
    "email": "admin@paud.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

| Parameter | Tipe | Wajib | Keterangan |
|-----------|------|-------|------------|
| `name` | string | ✅ | Nama lengkap pengguna (max: 255) |
| `email` | string | ✅ | Email unik pengguna |
| `password` | string | ✅ | Password minimal 6 karakter |
| `password_confirmation` | string | ✅ | Konfirmasi password |

**Response Success (200):**
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
        "id": 1,
        "name": "Admin PAUD",
        "email": "admin@paud.com",
        "created_at": "2026-01-11T16:00:00.000000Z",
        "updated_at": "2026-01-11T16:00:00.000000Z"
    }
}
```

**Response Validation Error (422):**
```json
{
    "name": ["The name field is required."],
    "email": ["The email must be a valid email address."],
    "password": ["The password must be at least 6 characters."]
}
```

---

### 2. Login

**Endpoint:** `POST /api/auth/login`

**Request Body:**
```json
{
    "email": "admin@paud.com",
    "password": "password123"
}
```

| Parameter | Tipe | Wajib | Keterangan |
|-----------|------|-------|------------|
| `email` | string | ✅ | Email pengguna |
| `password` | string | ✅ | Password pengguna |

**Response Success (200):**
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDEvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3MDQ5NjQ4MDAsImV4cCI6MTcwNDk2ODQwMH0.abc123",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
        "id": 1,
        "name": "Admin PAUD",
        "email": "admin@paud.com"
    }
}
```

**Response Unauthorized (401):**
```json
{
    "error": "Unauthorized"
}
```

---

### 3. Get Current User (Me)

**Endpoint:** `GET /api/auth/me`

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```

**Response Success (200):**
```json
{
    "id": 1,
    "name": "Admin PAUD",
    "email": "admin@paud.com",
    "email_verified_at": null,
    "created_at": "2026-01-11T16:00:00.000000Z",
    "updated_at": "2026-01-11T16:00:00.000000Z"
}
```

---

### 4. Refresh Token

**Endpoint:** `POST /api/auth/refresh`

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```

**Response Success (200):**
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.newtoken...",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
        "id": 1,
        "name": "Admin PAUD",
        "email": "admin@paud.com"
    }
}
```

---

### 5. Logout

**Endpoint:** `POST /api/auth/logout`

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```

**Response Success (200):**
```json
{
    "message": "Successfully logged out"
}
```

---

## 2.7.2 Public API Endpoints

Endpoint publik untuk operasi tabungan dan pembayaran SPP. Tidak memerlukan autentikasi.

### Daftar Endpoint Publik

| No | Endpoint | Method | Deskripsi |
|----|----------|--------|-----------|
| 1 | `/api/saldo/{siswa_id}` | GET | Mendapatkan saldo tabungan siswa |
| 2 | `/api/menabung/{siswa_id}` | POST | Melakukan transaksi menabung/penarikan |
| 3 | `/api/tagihan/{siswa_id}` | GET | Mendapatkan daftar tagihan SPP siswa |
| 4 | `/api/transaksi-spp/{siswa_id}` | POST | Melakukan pembayaran SPP |

---

### 1. Get Saldo Siswa

**Endpoint:** `GET /api/saldo/{siswa_id}`

**Parameters:**
| Parameter | Lokasi | Wajib | Keterangan |
|-----------|--------|-------|------------|
| `siswa_id` | path | ✅ | ID siswa yang ingin dicek saldonya |

**Response Success (200):**
```json
{
    "saldo": 500000,
    "sal": "Rp 500.000"
}
```

**Response Not Found (404):**
```json
{
    "msg": "siswa tidak ditemukan"
}
```

**Response Siswa Belum Ada Tabungan:**
```json
{
    "saldo": "0",
    "sal": "0"
}
```

---

### 2. Menabung / Penarikan

**Endpoint:** `POST /api/menabung/{siswa_id}`

**Parameters:**
| Parameter | Lokasi | Wajib | Keterangan |
|-----------|--------|-------|------------|
| `siswa_id` | path | ✅ | ID siswa |

**Request Body:**
```json
{
    "siswa_id": 1,
    "jumlah": "50000",
    "tipe": "in",
    "keperluan": "Tabungan harian"
}
```

| Parameter | Tipe | Wajib | Keterangan |
|-----------|------|-------|------------|
| `siswa_id` | integer | ✅ | ID siswa |
| `jumlah` | string | ✅ | Jumlah uang (format: angka atau dengan pemisah ribuan, contoh: "50000" atau "50,000") |
| `tipe` | string | ✅ | Tipe transaksi: `in` = menabung, `out` = penarikan |
| `keperluan` | string | ❌ | Catatan/keterangan transaksi |

**Response Success - Menabung (200):**
```json
{
    "msg": "Berhasil melakukan transaksi"
}
```

**Response Success - Penarikan (200):**
```json
{
    "msg": "Berhasil melakukan transaksi"
}
```

**Response Gagal - Saldo Tidak Cukup (200):**
```json
{
    "msg": "Transaksi gagal"
}
```

---

### 3. Get Tagihan Siswa

**Endpoint:** `GET /api/tagihan/{siswa_id}`

**Parameters:**
| Parameter | Lokasi | Wajib | Keterangan |
|-----------|--------|-------|------------|
| `siswa_id` | path | ✅ | ID siswa |

**Response Success (200):**
```json
[
    {
        "id": 1,
        "nama": "SPP Januari 2026",
        "jumlah": 150000,
        "wajib_semua": "1",
        "kelas_id": null,
        "created_at": "2026-01-01T00:00:00.000000Z"
    },
    {
        "id": 2,
        "nama": "SPP Februari 2026",
        "jumlah": 150000,
        "wajib_semua": "1",
        "kelas_id": null,
        "created_at": "2026-02-01T00:00:00.000000Z"
    }
]
```

**Keterangan Field:**
| Field | Keterangan |
|-------|------------|
| `wajib_semua` | `"1"` = tagihan berlaku untuk semua siswa |
| `kelas_id` | Jika tidak null, tagihan hanya untuk kelas tertentu |

---

### 4. Bayar SPP

**Endpoint:** `POST /api/transaksi-spp/{siswa_id}`

**Parameters:**
| Parameter | Lokasi | Wajib | Keterangan |
|-----------|--------|-------|------------|
| `siswa_id` | path | ✅ | ID siswa |

**Request Body:**
```json
{
    "tagihan_id": 1,
    "jumlah": "150000",
    "diskon": 0,
    "via": "tunai",
    "keterangan": "Pembayaran SPP Januari"
}
```

| Parameter | Tipe | Wajib | Keterangan |
|-----------|------|-------|------------|
| `tagihan_id` | integer | ✅ | ID tagihan yang dibayar |
| `jumlah` | string | ✅ | Jumlah pembayaran |
| `diskon` | integer | ❌ | Potongan harga (default: 0) |
| `via` | string | ✅ | Metode pembayaran: `tunai` atau `tabungan` |
| `keterangan` | string | ❌ | Catatan pembayaran |

**Response Success - Tunai (200):**
```json
{
    "msg": "transaksi berhasil dilakukan"
}
```

**Response Success - via Tabungan (200):**
```json
{
    "msg": "transaksi berhasil dilakukan"
}
```

> **Note:** Jika `via: "tabungan"`, saldo tabungan siswa akan otomatis dikurangi sesuai jumlah pembayaran.

---

## 2.7.3 Advanced Features

### 2.7.3.1 Throttling (Rate Limiting) - Multi-Tier

Sistem menerapkan mekanisme pembatasan request bertingkat untuk melindungi server dari serangan Brute Force dan DDoS:

| Tier | Endpoint | Limit | Keterangan |
|------|----------|-------|------------|
| **Tier 1 (Strict)** | Protected Routes (`/api/user`) | 5 request/menit per IP | Endpoint yang memerlukan autentikasi |
| **Tier 2 (Moderate)** | Public Routes (`/api/saldo`, `/api/menabung`, `/api/tagihan`, `/api/transaksi-spp`) | 60 request/menit per IP | Endpoint publik untuk operasi tabungan & SPP |

**Response jika limit terlampaui (HTTP 429):**
```json
{
    "message": "Too Many Attempts.",
    "retry_after": 60
}
```

**Headers Response Rate Limit:**
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Retry-After: 60
```

---

### 2.7.3.2 Pagination

Endpoint web view menggunakan pagination untuk mengoptimalkan performa.

**Parameter:**
| Parameter | Default | Keterangan |
|-----------|---------|------------|
| `?page=1` | 1 | Nomor halaman |

**Output Metadata:**
```json
{
    "current_page": 1,
    "data": [...],
    "first_page_url": "http://localhost:8001/siswa?page=1",
    "from": 1,
    "last_page": 5,
    "last_page_url": "http://localhost:8001/siswa?page=5",
    "next_page_url": "http://localhost:8001/siswa?page=2",
    "path": "http://localhost:8001/siswa",
    "per_page": 15,
    "prev_page_url": null,
    "to": 15,
    "total": 75
}
```

---

### 2.7.3.3 Filtering

Tersedia di endpoint web (dashboard), dengan parameter berikut:

| Filter | Parameter | Contoh | Keterangan |
|--------|-----------|--------|------------|
| By Siswa | `?siswa_id={id}` | `?siswa_id=1` | Filter transaksi berdasarkan siswa |
| By Kelas | `?kelas_id={id}` | `?kelas_id=2` | Filter siswa berdasarkan kelas |
| By Tipe Transaksi | `?tipe={in/out}` | `?tipe=in` | Filter transaksi tabungan |
| By Jenis Kelamin | `?jenis_kelamin={L/P}` | `?jenis_kelamin=L` | Filter siswa berdasarkan gender |
| By Status Yatim | `?is_yatim={0/1}` | `?is_yatim=1` | Filter siswa yatim/tidak |

**Date Range Filter:**
| Parameter | Contoh | Keterangan |
|-----------|--------|------------|
| `?start_date=YYYY-MM-DD` | `?start_date=2026-01-01` | Tanggal mulai |
| `?end_date=YYYY-MM-DD` | `?end_date=2026-01-31` | Tanggal akhir |

**Contoh Penggunaan:**
```
GET /tabungan?siswa_id=1&tipe=in&start_date=2026-01-01&end_date=2026-01-31
```

---

### 2.7.3.4 Search

Fitur pencarian tersedia di endpoint web dengan parameter:

| Parameter | Contoh | Field yang Dicari |
|-----------|--------|-------------------|
| `?search={keyword}` | `?search=Ahmad` | nama, nama_wali, alamat |
| `?q={keyword}` | `?q=Ahmad` | nama, nama_wali, alamat |

**Contoh Penggunaan:**
```
GET /siswa?search=Ahmad
GET /siswa?q=Jalan
```

---

### 2.7.3.5 Sorting

Pengguna dapat mengurutkan data secara dinamis dengan parameter:

| Parameter | Keterangan |
|-----------|------------|
| `?sort_by={column}` | Kolom yang akan diurutkan |
| `?sort_order={asc/desc}` | Urutan ascending/descending |

**Contoh Penggunaan:**
| Request | Hasil |
|---------|-------|
| `?sort_by=created_at&sort_order=desc` | Terbaru → Terlama (default) |
| `?sort_by=nama&sort_order=asc` | Alfabetis A → Z |
| `?sort_by=jumlah&sort_order=desc` | Nominal terbesar → terkecil |

**Kolom yang Dapat Di-sort:**
- `created_at` - Tanggal dibuat
- `nama` - Nama siswa
- `jumlah` - Nominal transaksi
- `saldo` - Saldo tabungan

---

## 2.7.4 Error Responses

### HTTP Status Codes

| HTTP Code | Status | Keterangan |
|-----------|--------|------------|
| 200 | OK | Request berhasil |
| 401 | Unauthorized | Token tidak valid atau tidak ada |
| 404 | Not Found | Resource tidak ditemukan |
| 422 | Unprocessable Entity | Validation error |
| 429 | Too Many Requests | Rate limit terlampaui |
| 500 | Internal Server Error | Error di server |

### Contoh Response Error

**401 Unauthorized:**
```json
{
    "error": "Unauthorized"
}
```

**404 Not Found:**
```json
{
    "msg": "Siswa tidak ditemukan"
}
```

**422 Validation Error:**
```json
{
    "email": ["The email field is required."],
    "password": ["The password field is required."]
}
```

**429 Too Many Requests:**
```json
{
    "message": "Too Many Attempts.",
    "retry_after": 60
}
```

---

## 📌 Quick Reference

### Base URL
```
http://localhost:8001/api
```

### Headers untuk Protected Endpoints
```
Authorization: Bearer {access_token}
Content-Type: application/json
Accept: application/json
```

### Flow Autentikasi
1. **Register** atau **Login** untuk mendapatkan `access_token`
2. Simpan `access_token` 
3. Gunakan token di header `Authorization: Bearer {token}` untuk endpoint protected
4. **Refresh** token sebelum expired (default: 60 menit)
5. **Logout** untuk invalidate token

---

## 📥 Postman Collection

Import file berikut ke Postman untuk testing:
```
docs/Web_Tabungan_PAUD_API.postman_collection.json
```

---

*Dokumentasi ini dibuat berdasarkan implementasi kode pada Sistem Tabungan PAUD v1.0*
