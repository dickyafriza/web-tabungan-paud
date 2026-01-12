# API Documentation - Sistem Tabungan PAUD

## 📋 Overview

Dokumentasi API untuk Sistem Tabungan PAUD Terpadu Cerdas. API ini menyediakan endpoint untuk manajemen tabungan siswa, pembayaran SPP, dan autentikasi pengguna.

**Base URL:** `http://localhost:8001/api`

---

## 2.7.1 Authentication (AUTH)

Sistem autentikasi menggunakan **JWT (JSON Web Token)** melalui package `tymon/jwt-auth`.

### Daftar Endpoint Authentication

| No | Endpoint | Method | Deskripsi | Auth Required | Rate Limit |
|----|----------|--------|-----------|---------------|------------|
| 1 | `/api/auth/register` | POST | Registrasi user baru | ❌ | 5/min |
| 2 | `/api/auth/login` | POST | Login dengan email & password | ❌ | 5/min |
| 3 | `/api/auth/me` | GET | Mendapatkan data user yang sedang login | ✅ Bearer Token | - |
| 4 | `/api/auth/refresh` | POST | Memperbarui JWT token yang akan expired | ✅ Bearer Token | - |
| 5 | `/api/auth/logout` | POST | Logout dan invalidate token | ✅ Bearer Token | - |

---

### 1. Register

**Endpoint:** `POST /api/auth/register`

**Rate Limit:** 5 requests/minute per IP (Tier 1 - Strict)

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
        "email": "admin@paud.com"
    }
}
```

---

### 2. Login

**Endpoint:** `POST /api/auth/login`

**Rate Limit:** 5 requests/minute per IP (Tier 1 - Strict)

**Request Body:**
```json
{
    "email": "admin@paud.com",
    "password": "password123"
}
```

**Response Success (200):**
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
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

## 2.7.2 Advanced Features

### 2.7.2.1 Throttling (Rate Limiting) - Multi-Tier

Sistem menerapkan mekanisme pembatasan request bertingkat untuk melindungi server dari serangan Brute Force dan DDoS:

| Tier | Endpoint | Limit | Keterangan |
|------|----------|-------|------------|
| **Tier 1 (Strict)** | `/api/auth/login`, `/api/auth/register` | **5 request/menit per IP** | Endpoint autentikasi |
| **Tier 2 (Moderate)** | `/api/saldo`, `/api/menabung`, `/api/tagihan`, `/api/transaksi-spp` | **60 request/menit per IP** | Endpoint publik |
| **Tier 3 (Permissive)** | `/api/tabungan`, `/api/siswa` (CRUD) | **100 request/menit per User ID** | Endpoint terproteksi untuk user login |

**Response jika limit terlampaui (HTTP 429):**
```json
{
    "message": "Too Many Attempts.",
    "retry_after": 60
}
```

**Headers Response:**
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Retry-After: 60
```

---

### 2.7.2.2 Pagination

Semua endpoint GET yang mengembalikan list data mendukung pagination.

**Parameter:**
| Parameter | Default | Keterangan |
|-----------|---------|------------|
| `?page=1` | 1 | Nomor halaman |
| `?per_page=10` | 10 | Jumlah item per halaman (max: 100) |

**Contoh Request:**
```
GET /api/tabungan?page=1&per_page=10
GET /api/siswa?page=2&per_page=20
```

**Response dengan Pagination:**
```json
{
    "data": [...],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 10,
        "total": 50,
        "from": 1,
        "to": 10
    },
    "links": {
        "first": "http://localhost:8001/api/tabungan?page=1",
        "last": "http://localhost:8001/api/tabungan?page=5",
        "prev": null,
        "next": "http://localhost:8001/api/tabungan?page=2"
    }
}
```

---

### 2.7.2.3 Filtering

Setiap endpoint memiliki parameter filter yang berbeda:

#### Endpoint `/api/tabungan`:
| Filter | Parameter | Contoh |
|--------|-----------|--------|
| By Siswa | `?siswa_id={id}` | `?siswa_id=1` |
| By Tipe | `?tipe={in/out}` | `?tipe=in` (menabung) atau `?tipe=out` (penarikan) |
| Date Range | `?start_date=...&end_date=...` | `?start_date=2026-01-01&end_date=2026-01-31` |

#### Endpoint `/api/siswa`:
| Filter | Parameter | Contoh |
|--------|-----------|--------|
| By Kelas | `?kelas_id={id}` | `?kelas_id=1` |
| By Jenis Kelamin | `?jenis_kelamin={L/P}` | `?jenis_kelamin=L` |
| By Status Yatim | `?is_yatim={0/1}` | `?is_yatim=1` |

**Contoh Penggunaan:**
```
GET /api/tabungan?siswa_id=1&tipe=in&start_date=2026-01-01
GET /api/siswa?kelas_id=1&jenis_kelamin=L
```

---

### 2.7.2.4 Search

Fitur pencarian tersedia di endpoint dengan parameter `search`:

| Endpoint | Parameter | Field yang Dicari |
|----------|-----------|-------------------|
| `/api/tabungan` | `?search=keyword` | keperluan |
| `/api/siswa` | `?search=keyword` | nama, nama_wali, alamat |

**Contoh:**
```
GET /api/tabungan?search=tabungan%20harian
GET /api/siswa?search=Ahmad
```

---

### 2.7.2.5 Sorting

Pengguna dapat mengurutkan data secara dinamis:

| Parameter | Keterangan |
|-----------|------------|
| `?sort_by={column}` | Kolom yang akan diurutkan |
| `?order={asc/desc}` | Urutan (default: desc) |

**Contoh Penggunaan:**
| Request | Hasil |
|---------|-------|
| `?sort_by=created_at&order=desc` | Terbaru → Terlama (default) |
| `?sort_by=nama&order=asc` | Alfabetis A → Z |
| `?sort_by=jumlah&order=desc` | Nominal terbesar → terkecil |

**Contoh Lengkap dengan Semua Parameter:**
```
GET /api/siswa?page=1&per_page=10&kelas_id=1&search=Ahmad&sort_by=nama&order=asc
```

---

## 2.7.3 Protected API Endpoints (CRUD)

Endpoint ini memerlukan autentikasi JWT. Rate limit: **100 request/menit per User ID**.

### Tabungan CRUD

| No | Endpoint | Method | Deskripsi |
|----|----------|--------|-----------|
| 1 | `/api/tabungan` | GET | List semua tabungan (with pagination, filtering, sorting) |
| 2 | `/api/tabungan/{id}` | GET | Detail tabungan by ID |
| 3 | `/api/tabungan` | POST | Create transaksi tabungan baru |
| 4 | `/api/tabungan/{id}` | PUT | Update tabungan |
| 5 | `/api/tabungan/{id}` | DELETE | Hapus tabungan |

### Siswa CRUD

| No | Endpoint | Method | Deskripsi |
|----|----------|--------|-----------|
| 1 | `/api/siswa` | GET | List semua siswa (with pagination, filtering, sorting) |
| 2 | `/api/siswa/{id}` | GET | Detail siswa by ID (termasuk saldo & recent transactions) |

---

### GET /api/tabungan

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```

**Query Parameters:**
| Parameter | Tipe | Default | Keterangan |
|-----------|------|---------|------------|
| `page` | int | 1 | Nomor halaman |
| `per_page` | int | 10 | Item per halaman (max: 100) |
| `siswa_id` | int | - | Filter by siswa |
| `tipe` | string | - | Filter by tipe: `in` atau `out` |
| `search` | string | - | Search dalam keperluan |
| `start_date` | date | - | Filter tanggal mulai |
| `end_date` | date | - | Filter tanggal akhir |
| `sort_by` | string | created_at | Kolom sorting |
| `order` | string | desc | asc atau desc |

**Response Success (200):**
```json
{
    "data": [
        {
            "id": 1,
            "siswa_id": 1,
            "tipe": "in",
            "jumlah": 50000,
            "saldo": 50000,
            "keperluan": "Tabungan harian",
            "created_at": "2026-01-12T10:00:00.000000Z",
            "siswa": {
                "id": 1,
                "nama": "Ahmad Fauzi",
                "kelas": {
                    "id": 1,
                    "nama": "TK A"
                }
            }
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "per_page": 10,
        "total": 1,
        "from": 1,
        "to": 1
    },
    "links": {...}
}
```

---

### GET /api/siswa

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```

**Query Parameters:**
| Parameter | Tipe | Default | Keterangan |
|-----------|------|---------|------------|
| `page` | int | 1 | Nomor halaman |
| `per_page` | int | 10 | Item per halaman (max: 100) |
| `kelas_id` | int | - | Filter by kelas |
| `jenis_kelamin` | string | - | Filter: `L` atau `P` |
| `is_yatim` | int | - | Filter: `0` atau `1` |
| `search` | string | - | Search dalam nama, nama_wali, alamat |
| `sort_by` | string | created_at | Kolom sorting |
| `order` | string | desc | asc atau desc |

**Response Success (200):**
```json
{
    "data": [
        {
            "id": 1,
            "nama": "Ahmad Fauzi",
            "tempat_lahir": "Jakarta",
            "tanggal_lahir": "2020-05-15",
            "jenis_kelamin": "L",
            "alamat": "Jl. Merdeka No. 1",
            "nama_wali": "Budi Santoso",
            "telp_wali": "08123456789",
            "is_yatim": 0,
            "saldo": 500000,
            "saldo_formatted": "Rp 500.000",
            "kelas": {
                "id": 1,
                "nama": "TK A"
            }
        }
    ],
    "meta": {...},
    "links": {...}
}
```

---

## 2.7.4 Public API Endpoints

Endpoint publik tidak memerlukan autentikasi. Rate limit: **60 request/menit per IP**.

| No | Endpoint | Method | Deskripsi |
|----|----------|--------|-----------|
| 1 | `/api/saldo/{siswa_id}` | GET | Cek saldo tabungan siswa |
| 2 | `/api/menabung/{siswa_id}` | POST | Menabung atau tarik tabungan |
| 3 | `/api/tagihan/{siswa_id}` | GET | List tagihan SPP siswa |
| 4 | `/api/transaksi-spp/{siswa_id}` | POST | Bayar SPP |
| 5 | `/api/health` | GET | Health check endpoint |

---

## 2.7.5 Error Responses

### HTTP Status Codes

| HTTP Code | Status | Keterangan |
|-----------|--------|------------|
| 200 | OK | Request berhasil |
| 401 | Unauthorized | Token tidak valid atau tidak ada |
| 404 | Not Found | Resource tidak ditemukan |
| 422 | Unprocessable Entity | Validation error |
| 429 | Too Many Requests | Rate limit terlampaui |
| 500 | Internal Server Error | Error di server |

---

## 📌 Quick Reference

### Base URL
```
Production: https://web-tabungan-paud.onrender.com/api
Local: http://localhost:8001/api
```

### Rate Limit Summary
| Tier | Limit | Endpoints |
|------|-------|-----------|
| Strict | 5/min | Login, Register |
| Moderate | 60/min | Saldo, Menabung, Tagihan, SPP |
| Permissive | 100/min | Tabungan CRUD, Siswa CRUD |

### Flow Autentikasi
1. **Register** atau **Login** untuk mendapatkan `access_token`
2. Simpan `access_token` 
3. Gunakan token di header `Authorization: Bearer {token}`
4. **Refresh** token sebelum expired (default: 60 menit)
5. **Logout** untuk invalidate token

---

*Dokumentasi ini dibuat berdasarkan implementasi kode pada Sistem Tabungan PAUD v1.0*
