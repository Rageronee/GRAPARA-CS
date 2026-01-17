# 🌐 Grapara Modern (Telkomcel Halu & Indihomie Siber)

**Implementasi Basis Data - Enhanced and Perfected By [Muhammad Afnan Risandi](https://mafnanrisandi-portfolio.vercel.app/)**

![Grapara Modern Banner](https://img.shields.io/badge/Status-Production-success?style=for-the-badge) ![Laravel](https://img.shields.io/badge/Laravel-11-red?style=for-the-badge&logo=laravel) ![Tailwind](https://img.shields.io/badge/Tailwind-4-blue?style=for-the-badge&logo=tailwindcss) ![TiDB](https://img.shields.io/badge/TiDB-Serverless-pink?style=for-the-badge&logo=tidb) ![Vercel](https://img.shields.io/badge/Vercel-Deployed-black?style=for-the-badge&logo=vercel)

Aplikasi manajemen antrian dan layanan Customer Service modern dengan sentuhan humor ("Plesetan"), fitur keamanan tingkat lanjut, dan integrasi database serverless.

---

## ✨ Fitur Unggulan

### 1. 🎨 Modern & Parody Branding

- **UI Glassmorphism**: Desain antarmuka transparan dan futuristik menggunakan Tailwind CSS.
- **Parody Products**: Layanan unggulan **"Telkomcel Halu"** dan **"Indihomie Siber"**.
- **Interactive FAQ**: Bagian tanya jawab dengan animasi accordion.

### 2. 🛡️ Advanced Security

- **Strict Password Policy**: Registrasi mewajibkan password minimal 8 karakter.
- **Validation Feedback**: Pesan error realtime pada form input yang salah.
- **Anti-SQL Injection**: Menggunakan Eloquent ORM Laravel.

### 3. ☁️ Infrastruktur Serverless (Cloud)

- **Database**: Terkoneksi penuh ke **TiDB Cloud (Serverless MySQL)**. Data tersimpan aman di cloud, bukan di localhost.
- **Deployment**: Siap deploy ke **Vercel** dengan konfigurasi `vercel.json` khusus.

### 4. 🚀 Smart Queue System

- **Realtime Status**: Monitoring antrian (Menunggu, Dilayani, Selesai).
- **Dynamic Options**: Pilihan layanan spesifik (Ganti Kartu, Upgrade 4G, Lapor Gangguan).
- **Multi-Role**:
  - **Admin**: Monitor antrian & user.
  - **CS/Teller**: Memanggil dan melayani antrian.
  - **Customer**: Mengambil tiket dan melihat riwayat.

---

## 🛠️ Teknologi yang Digunakan

- **Framework**: Laravel 11.x
- **Frontend**: Blade + Alpine.js + Tailwind CSS
- **Database**: TiDB Cloud (MySQL Compatible)
- **Deployment**: Vercel (Serverless Function)

---

## 🔐 Akun Demo (Login Info)

Silakan gunakan akun berikut untuk mencoba fitur dashboard (Password untuk semua akun: `password`):

| Username | Role | Akses Dashboard |
| :--- | :--- | :--- |
| **super** | Manager | **Manager Dashboard** (Analisis Kinerja & Monitoring) |
| **cs1** | CS Staff | **CS Dashboard** (Melayani Antrian & Input Tiket) |
| **cs2** | CS Staff | **CS Dashboard** (Melayani Antrian & Input Tiket) |
| **cs3** | CS Staff | **CS Dashboard** (Melayani Antrian & Input Tiket) |

---

## ⚙️ Cara Instalasi & Menjalankan (Lokal)

### Persiapan (Prerequisites)

- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite (untuk database lokal yang ringan)

### Langkah-langkah

1. **Clone Repository**

    ```bash
    git clone https://github.com/Rageronee/GRAPARA-CS.git
    cd GRAPARA-CS
    ```

2. **Install Dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Setup Database (SQLite)**
    Aplikasi ini dioptimalkan untuk menggunakan SQLite di environment lokal agar cepat dan ringan.

    - Copy `.env.example` ke `.env`:

      ```bash
      cp .env.example .env
      ```

    - Buka file `.env` dan pastikan konfigurasi database seperti ini:

      ```env
      DB_CONNECTION=sqlite
      # DB_HOST=127.0.0.1 (Matikan/Comment konfigurasi MySQL)
      ```

    - Buat file database kosong:
      *Windows (PowerShell):*

      ```powershell
      New-Item -ItemType File database/database.sqlite
      ```

      *Mac/Linux:*

      ```bash
      touch database/database.sqlite
      ```

4. **Kunci & Migrasi**
    Generate key aplikasi dan isi database dengan data awal (Seeding):

    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```

    *> Perintah `migrate:fresh --seed` akan mereset database dan membuat akun demo otomatis.*

5. **Jalankan Aplikasi**
    Buka dua terminal:

    **Terminal 1 (Backend Server):**

    ```bash
    php artisan serve
    ```

    **Terminal 2 (Frontend Build/Watch):**

    ```bash
    npm run dev
    ```

    Buka browser di: [http://localhost:8000](http://localhost:8000)

---

## ☁️ Deployment ke Vercel

Project ini sudah dilengkapi konfigurasi `vercel.json` untuk deployment instan.

1. Import project ke Dashboard Vercel.
2. Pilih Framework Preset: **Other**.
3. **PENTING**: Biarkan **Output Directory** kosong (Default). ❌ Jangan diubah ke `public`.
4. Masukkan **Environment Variables** (Copy dari `.env` lokal Anda).
5. Deploy! 🚀

---

## 👨‍💻 Credits

**Developed for Tugas Implementasi Basis Data**

- **Author**: Muhammad Afnan Risandi
- **Portfolio**: [https://mafnanrisandi-portfolio.vercel.app](https://mafnanrisandi-portfolio.vercel.app)

> "Future Connection - Connecting People with Humor and Technology."
