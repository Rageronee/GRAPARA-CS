# Grapara Modern (Laravel 11)

Ini adalah versi upgrade dari aplikasi Customer Service Grapara, dibangun menggunakan **Laravel 11** dan **Tailwind CSS**.

## Fitur Baru

- **Modern UI**: Menggunakan Tailwind CSS + Glassmorphism aesthetic.
- **Secure Auth**: Sistem login aman dengan hashing password (Anti SQL Injection).
- **Role Management**: Dashboard terpisah untuk Admin, CS, dan Manager.
- **Smart Queue**: Sistem antrian digital (A-001, B-001) dengan status realtime.

## 🚀 Cara Menjalankan (PENTING)

Karena proses instalasi otomatis memakan waktu (download dependencies), ikuti langkah ini:

### 1. Pastikan Instalasi Selesai

Tunggu hingga perintah `composer create-project` di terminal selesai sepenuhnya. Folder `vendor` harus ada.

### 2. Setup Database

1. Buka XAMPP/MySQL, buat database baru bernama: `grapara_modern`.
2. Edit file `.env` di dalam folder `grapara-modern`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=grapara_modern
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 3. Install Database & Data Awal

Jalankan perintah ini di terminal (di dalam folder `grapara-modern`):

```bash
php artisan key:generate
php artisan migrate --seed
```

*Ini akan membuat tabel dan user default (Admin, CS, Manager).*

### 4. Jalankan Aplikasi

Buka dua terminal:
**Terminal 1 (Backend):**

```bash
php artisan serve
```

**Terminal 2 (Frontend - Optional jika pakai CDN):**

```bash
npm install && npm run dev
```

### 5. Login Default

Akses: `http://localhost:8000`

- **Admin**: `admin` / `password`
- **CS**: `afnan` / `password`
- **Manager**: `faris` / `password`

## Struktur Kode

- **Migrations**: `database/migrations/` (Struktur tabel modern).
- **Controllers**: `app/Http/Controllers/` (Logika backend).
- **Views**: `resources/views/` (Tampilan Blade + Tailwind).
- **Routes**: `routes/web.php` (Definisi URL).
