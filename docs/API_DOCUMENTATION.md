# 📚 Dokumentasi API - Web Tabungan PAUD

Dokumentasi API Web Tabungan PAUD telah dipublikasikan untuk memudahkan pengembang Frontend dan penguji dalam memahami cara kerja endpoint.

---

## 🔗 Link Dokumentasi Live

### Postman Collection
Import file berikut ke Postman untuk testing API:
```
docs/Web_Tabungan_PAUD_API.postman_collection.json
```

### Base URL
```
http://localhost:8001/api
```

---

## 📖 Dokumentasi ini mencakup:

1. **Daftar Endpoint**: Struktur URL yang terorganisir untuk Authentication dan Transaksi Management.
2. **Request Details**: Format JSON Body untuk request POST/PUT serta parameter Query untuk filtering.
3. **Code Snippets**: Contoh kode integrasi (cURL, JavaScript Fetch, PHP, dll) yang digenerate otomatis.
4. **Example Responses**: Contoh nyata respon JSON untuk skenario Sukses (200 OK) dan Gagal (401/422).

---

## 🔐 1. Authentication (JWT)

API menggunakan JWT (JSON Web Token) untuk autentikasi. Semua endpoint yang memerlukan autentikasi harus menyertakan header:

```
Authorization: Bearer <your_token>
```

### 1.1 Register User

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

**Success Response (200 OK):**
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

**Error Response (422 Validation Error):**
```json
{
    "name": ["The name field is required."],
    "email": ["The email must be a valid email address."],
    "password": ["The password must be at least 6 characters."]
}
```

---

### 1.2 Login

**Endpoint:** `POST /api/auth/login`

**Request Body:**
```json
{
    "email": "admin@paud.com",
    "password": "password123"
}
```

**Success Response (200 OK):**
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

**Error Response (401 Unauthorized):**
```json
{
    "error": "Unauthorized"
}
```

---

### 1.3 Get Current User

**Endpoint:** `GET /api/auth/me`

**Headers:**
```
Authorization: Bearer <your_token>
```

**Success Response (200 OK):**
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

### 1.4 Refresh Token

**Endpoint:** `POST /api/auth/refresh`

**Headers:**
```
Authorization: Bearer <your_token>
```

**Success Response (200 OK):**
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

### 1.5 Logout

**Endpoint:** `POST /api/auth/logout`

**Headers:**
```
Authorization: Bearer <your_token>
```

**Success Response (200 OK):**
```json
{
    "message": "Successfully logged out"
}
```

---

## 💰 2. Saldo Siswa

### 2.1 Get Saldo Siswa

**Endpoint:** `GET /api/saldo/{siswa_id}`

**Parameters:**
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| siswa_id | int | Optional | ID siswa yang ingin dicek saldonya |

**Success Response (200 OK):**
```json
{
    "siswa": {
        "id": 1,
        "nama": "Ahmad Fauzi",
        "nis": "2024001",
        "kelas": {
            "id": 1,
            "nama": "TK A"
        }
    },
    "saldo": 500000,
    "formatted_saldo": "Rp 500.000"
}
```

---

## 🏦 3. Transaksi Tabungan

### 3.1 Menabung / Penarikan

**Endpoint:** `POST /api/menabung/{siswa_id}`

**Parameters:**
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| siswa_id | int | Required | ID siswa |

**Request Body:**
```json
{
    "siswa_id": 1,
    "jumlah": "50000",
    "tipe": "in",
    "keperluan": "Tabungan harian"
}
```

**Request Body Fields:**
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| siswa_id | int | Required | ID siswa |
| jumlah | string | Required | Jumlah uang (dapat menggunakan pemisah ribuan) |
| tipe | string | Required | `in` untuk menabung, `out` untuk penarikan |
| keperluan | string | Optional | Catatan/keterangan transaksi |

**Success Response - Menabung (200 OK):**
```json
{
    "msg": "Berhasil melakukan transaksi"
}
```

**Success Response - Penarikan (200 OK):**
```json
{
    "msg": "Berhasil melakukan transaksi"
}
```

**Error Response - Saldo Tidak Cukup:**
```json
{
    "msg": "Transaksi gagal"
}
```

---

## 📋 4. Tagihan SPP

### 4.1 Get Tagihan Siswa

**Endpoint:** `GET /api/tagihan/{siswa_id}`

**Parameters:**
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| siswa_id | int | Required | ID siswa |

**Success Response (200 OK):**
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

---

### 4.2 Bayar SPP

**Endpoint:** `POST /api/transaksi-spp/{siswa_id}`

**Parameters:**
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| siswa_id | int | Required | ID siswa |

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

**Request Body Fields:**
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| tagihan_id | int | Required | ID tagihan yang dibayar |
| jumlah | string | Required | Jumlah pembayaran |
| diskon | int | Optional | Potongan harga (default: 0) |
| via | string | Required | Metode pembayaran: `tunai` atau `tabungan` |
| keterangan | string | Optional | Catatan pembayaran |

**Success Response (200 OK):**
```json
{
    "msg": "transaksi berhasil dilakukan"
}
```

---

## 🛠️ Code Snippets

### cURL

```bash
# Login
curl -X POST http://localhost:8001/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@paud.com", "password": "password123"}'

# Get Saldo
curl -X GET http://localhost:8001/api/saldo/1 \
  -H "Accept: application/json"

# Menabung
curl -X POST http://localhost:8001/api/menabung/1 \
  -H "Content-Type: application/json" \
  -d '{"siswa_id": 1, "jumlah": "50000", "tipe": "in", "keperluan": "Tabungan harian"}'
```

### JavaScript Fetch

```javascript
// Login
const login = async () => {
    const response = await fetch('http://localhost:8001/api/auth/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            email: 'admin@paud.com',
            password: 'password123'
        })
    });
    const data = await response.json();
    return data.access_token;
};

// Get Saldo
const getSaldo = async (siswaId) => {
    const response = await fetch(`http://localhost:8001/api/saldo/${siswaId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    });
    return await response.json();
};

// Menabung
const menabung = async (siswaId, jumlah, tipe) => {
    const response = await fetch(`http://localhost:8001/api/menabung/${siswaId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            siswa_id: siswaId,
            jumlah: jumlah,
            tipe: tipe,
            keperluan: 'Tabungan harian'
        })
    });
    return await response.json();
};
```

### PHP

```php
<?php

// Login
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8001/api/auth/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'email' => 'admin@paud.com',
    'password' => 'password123'
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$data = json_decode($response, true);
$token = $data['access_token'];

// Get Saldo
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8001/api/saldo/1');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$saldo = json_decode($response, true);

// Menabung
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8001/api/menabung/1');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'siswa_id' => 1,
    'jumlah' => '50000',
    'tipe' => 'in',
    'keperluan' => 'Tabungan harian'
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
```

---

## ⚠️ Rate Limiting

API ini menerapkan rate limiting untuk melindungi server:

| Endpoint Group | Limit |
|----------------|-------|
| Protected Routes (auth required) | 5 requests per minute |
| Public Routes | 60 requests per minute |

---

## 📊 HTTP Status Codes

| Status Code | Description |
|-------------|-------------|
| 200 | OK - Request berhasil |
| 201 | Created - Resource berhasil dibuat |
| 400 | Bad Request - Request tidak valid |
| 401 | Unauthorized - Token tidak valid atau expired |
| 404 | Not Found - Resource tidak ditemukan |
| 422 | Unprocessable Entity - Validasi gagal |
| 429 | Too Many Requests - Rate limit exceeded |
| 500 | Internal Server Error - Kesalahan server |

---

## 📝 Catatan

- Semua response dalam format JSON
- Semua request yang memerlukan body harus menggunakan `Content-Type: application/json`
- Token JWT expired dalam 60 menit, gunakan endpoint refresh untuk memperbarui token
- Untuk pengujian, gunakan Postman Collection yang telah disediakan

---

**Last Updated:** 11 Januari 2026
