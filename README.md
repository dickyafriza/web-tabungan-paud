# 🏫 Web Tabungan PAUD

Sistem Manajemen Tabungan dan SPP untuk PAUD berbasis Laravel 11.

---

## 📋 Daftar Isi

- [Installation](#installation)
- [Running the Project](#running-the-project)
- [API Documentation](#api-documentation)
- [Code Overview](#code-overview)
- [Default SuperUser](#default-superuser)

---

## ⚙️ Installation

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js (optional, untuk assets)

### Langkah Instalasi

1. **Clone repository**
```bash
git clone https://github.com/dickyafriza/web-tabungan-paud.git
cd web-tabungan-paud
```

2. **Install dependencies**
```bash
composer install
```

3. **Setup environment**
```bash
cp .example.env .env
php artisan key:generate
```

4. **Setup database** (SQLite - default)
```bash
touch database/database.sqlite
php artisan migrate --seed
```

---

## 🚀 Running the Project

### Metode 1: PHP Artisan (Recommended untuk development)

```bash
php artisan serve --port=8001
```

Akses aplikasi di: **http://localhost:8001**

### Metode 2: Docker

```bash
docker-compose up -d --build
```

| Service | URL |
|---------|-----|
| Aplikasi | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |

---

## 📚 API Documentation (DOCS)

Dokumentasi API Web Tabungan PAUD telah dipublikasikan untuk memudahkan pengembang Frontend dan penguji dalam memahami cara kerja endpoint.

### 📁 File Dokumentasi

| File | Deskripsi |
|------|-----------|
| [docs/API_DOCUMENTATION.md](docs/API_DOCUMENTATION.md) | Dokumentasi lengkap dalam format Markdown |
| [docs/Web_Tabungan_PAUD_API.postman_collection.json](docs/Web_Tabungan_PAUD_API.postman_collection.json) | Postman Collection untuk testing API |

### 🔧 Cara Import ke Postman

1. Buka Postman
2. Klik **Import** → **Upload Files**
3. Pilih file `docs/Web_Tabungan_PAUD_API.postman_collection.json`
4. Collection akan otomatis tersedia

### 📖 Dokumentasi mencakup:

1. **Daftar Endpoint**: Struktur URL yang terorganisir untuk Authentication dan Transaksi Management.
2. **Request Details**: Format JSON Body untuk request POST/PUT serta parameter Query untuk filtering.
3. **Code Snippets**: Contoh kode integrasi (cURL, JavaScript Fetch, PHP, dll) yang digenerate otomatis.
4. **Example Responses**: Contoh nyata respon JSON untuk skenario Sukses (200 OK) dan Gagal (401/422).

### 🔗 API Endpoints Overview

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/auth/register` | Register user baru |
| POST | `/api/auth/login` | Login dan dapatkan JWT token |
| GET | `/api/auth/me` | Get current user info |
| POST | `/api/auth/refresh` | Refresh JWT token |
| POST | `/api/auth/logout` | Logout |
| GET | `/api/saldo/{siswa}` | Get saldo tabungan siswa |
| POST | `/api/menabung/{siswa}` | Menabung/penarikan tabungan |
| GET | `/api/tagihan/{siswa}` | Get daftar tagihan siswa |
| POST | `/api/transaksi-spp/{siswa}` | Bayar SPP |

---

## 📁 Code Overview

### Folders

| Folder | Deskripsi |
|--------|-----------|
| `app/Models` | Eloquent models |
| `app/Http/Controllers` | Controllers |
| `app/Http/Controllers/Api` | API Controllers |
| `config` | Application configuration files |
| `database/factories` | Model factories |
| `database/migrations` | Database migrations |
| `database/seeds` | Database seeders |
| `routes/api.php` | API routes |
| `routes/web.php` | Web routes |
| `docs` | API Documentation |

### Environment Variables

File `.env` berisi konfigurasi environment. Contoh konfigurasi database:

```env
# SQLite (Default - Development)
DB_CONNECTION=sqlite

# MySQL (Docker)
# DB_CONNECTION=mysql
# DB_HOST=db
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=laravel
# DB_PASSWORD=laravel
```

---

## 👤 Default SuperUser

