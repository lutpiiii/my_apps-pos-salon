# NH Beauty Salon - Sistem Manajemen Laravel

Sistem Manajemen Salon & POS profesional yang dimigrasi dari PHP Native ke Laravel, menampilkan tema ungu mewah, analitik real-time, dan pelaporan lanjutan.

## 🚀 Pembaruan & Fitur Terbaru (Log Perubahan Hari Ini)

### 1. Keamanan & Autentikasi (Auth)
*   **File**: `app/Http/Controllers/AuthController.php`
    *   **L38 - L45**: Menambahkan dukungan password legacy untuk password teks biasa dari PHP Native.
    *   **L48 - L52**: Mengimplementasikan pengalihan otomatis berdasarkan peran (`admin` vs `kasir`).

### 2. Dashboard Admin Lanjutan
*   **File**: `app/Http/Controllers/Admin/DashboardController.php` (**BARU**)
    *   **L19 - L31**: Pengambilan statistik real-time (Pendapatan, Transaksi, Layanan Aktif).
    *   **L37 - L42**: Logika dinamis "Layanan Terlaris" berdasarkan data penjualan aktual.
    *   **L46 - L52**: Pemrosesan data tren penjualan 7 hari terakhir.
*   **File**: `resources/views/admin/dashboard.blade.php`
    *   **L104 - L150**: Integrasi **Chart.js** untuk diagram penjualan mingguan yang interaktif.
    *   **L13 - L34**: Kartu Selamat Datang gradasi mewah dengan tampilan tanggal dinamis.

### 3. UI & UX Manajemen (Menu & Kategori)
*   **File**: `resources/views/admin/menu/index.blade.php` & `kategori/index.blade.php`
    *   **L1 - L25**: Mengganti tabel lama dengan **Kartu Grid Interaktif Modern**.
    *   **L40 - L55**: Mengintegrasikan **Bilah Pencarian** dan **Filter Kategori** (untuk Menu).
    *   **L140 (Menu)**: Peningkatan Badge Kategori dengan kontras tinggi dan garis tepi untuk keterbacaan di perangkat seluler.

### 4. Pelaporan & Riwayat
*   **File**: `app/Http/Controllers/Admin/TransaksiController.php`
    *   **L18 - L25**: Penyaringan otomatis berdasarkan peran untuk Riwayat (Kasir hanya melihat data mereka sendiri).
    *   **L48 - L56**: Implementasi Filter 3-in-1 (**Harian, Rentang Tanggal, Tahunan**).
    *   **L105 - L120**: **Enkripsi ID** menggunakan Laravel Crypt untuk URL yang aman (menyembunyikan kunci utama numerik).
*   **File**: `resources/views/admin/laporan/masuk.blade.php`
    *   **L100 - L115**: Toggle filter JS dinamis tanpa penyegaran halaman.

### 5. Pencetakan & Ekspor
*   **File**: `app/Exports/LaporanMasukExport.php` (**BARU**)
    *   **L1 - L50**: Ekspor Excel profesional menggunakan **Maatwebsite/Laravel-Excel**.
*   **File**: `resources/views/admin/kasir/struk.blade.php` (**BARU**)
    *   **L1 - L70**: Tata letak struk siap cetak yang dioptimalkan untuk **Printer Thermal 58mm**.

### 6. Penyempurnaan UI Global
*   **File**: `public/css/dashboard-refined.css` (**BARU**)
    *   **L1 - L250**: Sistem gaya premium terkonsolidasi untuk semua dashboard.
*   **File**: `resources/views/layouts/dashboard/admin.blade.php`
    *   **L140 - L155**: Integrasi **SweetAlert2** untuk notifikasi profesional dan konfirmasi penghapusan.
    *   **L125 - L138**: Memperbaiki bug Sidebar Seluler dengan tombol Tutup dan logika Overlay.

### 7. Peningkatan Unggahan File
*   **File**: `app/Http/Controllers/Admin/GalleryController.php`
    *   **L24 - L30**: Manajemen direktori otomatis untuk mencegah kesalahan "Unable to write".
    *   **L45 - L50**: Pembersihan server otomatis (menghapus file lama saat pembaruan/penghapusan).

---

## 🛠 Teknologi Utama
*   **Framework**: Laravel 11.x
*   **Database**: MySQL
*   **UI**: Bootstrap 5, AOS (Animasi), Chart.js, SweetAlert2
*   **Library**: Laravel Excel, DomPDF

## 📝 Catatan Pengembang
Sistem sekarang sepenuhnya responsif dan dioptimalkan untuk perangkat Desktop, Tablet, dan Android. Semua transaksi menggunakan ID terenkripsi yang aman di frontend sambil mempertahankan logika backend yang andal.
