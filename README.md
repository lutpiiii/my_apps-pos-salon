# NH Beauty Salon - Sistem Manajemen & POS (Laravel 12)

Aplikasi manajemen operasional salon kecantikan yang mencakup sistem Reservasi Online, Point of Sales (Kasir), Manajemen Menu/Layanan, dan Laporan Keuangan.

---

## 🛠️ Persyaratan Sistem
Sebelum memindahkan aplikasi ke komputer lain, pastikan perangkat tersebut sudah memiliki:
*   **PHP Version**: Minimal **8.2** (Wajib, karena menggunakan Laravel 12).
*   **Web Server**: XAMPP (dengan PHP 8.2), Laragon, atau Nginx.
*   **Database**: MySQL / MariaDB.
*   **Composer**: Untuk mengelola library PHP.

---

## 🚀 Langkah-langkah Menjalankan di Komputer Baru

Ikuti urutan langkah di bawah ini agar aplikasi berjalan tanpa error:

### 1. Persiapan Folder & Database
1.  Copy seluruh folder project ke komputer baru.
2.  Buat database baru di **phpMyAdmin** (misal nama database: `pos-salon`).

### 2. Konfigurasi Environment (`.env`)
1.  Cek apakah file `.env` sudah ada. Jika belum, copy dari `.env.example` dan ubah namanya menjadi `.env`.
2.  Sesuaikan pengaturan database di file `.env`:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=pos-salon
    DB_USERNAME=root
    DB_PASSWORD=
    ```

### 3. Instalasi Library & Inisialisasi Database
Buka terminal (CMD / PowerShell / Git Bash) di dalam folder project, lalu jalankan perintah berikut secara berurutan:

```bash
# 1. Install semua library pendukung
composer install

# 2. Generate kunci keamanan aplikasi (Wajib agar login tidak error)
php artisan key:generate

# 3. Membuat struktur tabel database secara otomatis (Migrate)
php artisan migrate

# 4. (Opsional) Memasukkan data awal/dummy jika diperlukan
# php artisan db:seed

# 5. Hubungkan folder penyimpanan gambar
php artisan storage:link

# 6. Bersihkan cache dari komputer lama
php artisan optimize:clear
```

### 4. Perbaikan Izin Akses Folder (Wajib di Windows)
Agar fitur **Upload Gambar** dan **Login** lancar, lakukan langkah ini:
1.  Masuk ke folder `public/assets/`.
2.  Jika folder `uploads` belum ada, buat manual.
3.  **Klik Kanan** folder `uploads` -> **Properties**.
4.  Hilangkan centang **Read-only**.
5.  Masuk ke tab **Security** -> Klik **Edit** -> Pilih user **Everyone** (tambah jika belum ada) -> Centang **Full Control**.

### 5. Menjalankan Aplikasi
Terakhir, jalankan server Laravel:
```bash
php artisan serve
```
Buka browser dan akses: `http://127.0.0.1:8000`

---

## 🔑 Akun Akses Default
Jika Anda menggunakan data dari *Seeder* atau data bawaan, akun defaultnya adalah:
*   **Admin**: `admin` | Password: `12345678` (Atau sesuai data awal Anda).
*   **Kasir**: `kasir` | Password: `12345678`.

---

## 🛠️ Tips Jika Terjadi Error
*   **Error 419 Page Expired**: Jalankan `php artisan key:generate` dan `php artisan config:clear`.
*   **Gambar Tidak Muncul**: Pastikan sudah menjalankan `php artisan storage:link`.
*   **Sidebar Tertukar**: Jalankan `php artisan view:clear`.
*   **Database Error**: Pastikan koneksi di `.env` sudah benar dan sudah menjalankan `php artisan migrate`.

---
*Glow Up with Us! - NH Beauty Salon Development Team*
