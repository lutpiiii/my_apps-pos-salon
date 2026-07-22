<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalonqNativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profilesalon')->insert([
            [
                'id_prf' => 1,
                'nama_prf' => 'NH Beauty Salon',
                'keterangan_prf' => 'Selamat datang di salon kami, tempat untuk merawat dan menyempurnakan penampilan Anda dengan pelayanan yang profesional dan ramah. Kami menyediakan berbagai layanan perawatan rambut dan wajah menggunakan produk berkualitas untuk memberikan hasil yang memuaskan. Kepuasan dan kenyamanan pelanggan adalah prioritas kami agar setiap kunjungan menjadi pengalaman yang menyenangkan. Cantik Alami, Percaya Diri Setiap Hari.',
                'notelp_prf' => '085257968838',
                'email_prf' => 'uswa@gmail.com',
            ],
        ]);

        DB::table('infosalon')->insert([
            ['id_inf' => 13, 'judul_inf' => 'potong rambut wanita ', 'foto_inf' => 'img_6a49e8b763df09.55547567.jpeg', 'keterangan_inf' => 'potong rambut dan hasil smoothing'],
            ['id_inf' => 14, 'judul_inf' => 'hairs mask', 'foto_inf' => 'img_6a49e8d55803e6.74715510.jpeg', 'keterangan_inf' => 'masker rambut'],
            ['id_inf' => 15, 'judul_inf' => 'smoothing', 'foto_inf' => 'img_6a49e90a9254c2.57113017.jpeg', 'keterangan_inf' => 'befor after smoothing'],
            ['id_inf' => 16, 'judul_inf' => 'coloring', 'foto_inf' => 'img_6a49e95cee2777.30542501.jpeg', 'keterangan_inf' => 'warna rambut'],
            ['id_inf' => 17, 'judul_inf' => 'ruangan salon', 'foto_inf' => 'img_6a49e9e3e5a807.04672033.jpeg', 'keterangan_inf' => 'ibu owner sedang melayani customer salon'],
            ['id_inf' => 18, 'judul_inf' => 'rungan salon', 'foto_inf' => 'img_6a49eb704921c0.82068285.jpeg', 'keterangan_inf' => 'nyaman dan bersih'],
            ['id_inf' => 19, 'judul_inf' => 'logo salon', 'foto_inf' => 'img_6a49eba79bd698.46250737.jpeg', 'keterangan_inf' => 'NH beauty salon'],
            ['id_inf' => 20, 'judul_inf' => 'hiasan salon', 'foto_inf' => 'img_6a49ebf22fcc52.38709075.jpeg', 'keterangan_inf' => 'bunga bungan yang memperindah ruangan'],
            ['id_inf' => 21, 'judul_inf' => 'coloring ', 'foto_inf' => 'img_6a49f6c811db90.36637930.jpeg', 'keterangan_inf' => 'warna blode'],
            ['id_inf' => 22, 'judul_inf' => 'blow variasi', 'foto_inf' => 'img_6a49f7167b0465.19877707.jpeg', 'keterangan_inf' => 'catok rambut anak kecil '],
            ['id_inf' => 23, 'judul_inf' => 'keriting ', 'foto_inf' => 'img_6a49f75a98bf81.06191687.jpeg', 'keterangan_inf' => 'rambut di jadikan keriting '],
            ['id_inf' => 24, 'judul_inf' => 'coloring', 'foto_inf' => 'img_6a49f7975daf44.23832736.jpeg', 'keterangan_inf' => 'warna rambut yellow'],
            ['id_inf' => 25, 'judul_inf' => 'extention', 'foto_inf' => 'img_6a49f7d80a1115.19733128.jpeg', 'keterangan_inf' => 'untuk sambung rambut'],
            ['id_inf' => 26, 'judul_inf' => 'smoothing', 'foto_inf' => 'img_6a49f85f022d98.38264731.jpeg', 'keterangan_inf' => 'smoothing rambut'],
        ]);

        DB::table('kategorilayanan')->insert([
            ['id_k' => 1, 'nama_k' => 'rambut', 'is_deleted' => 0],
            ['id_k' => 2, 'nama_k' => 'potong rambut', 'is_deleted' => 1],
            ['id_k' => 5, 'nama_k' => 'perawatan rambut', 'is_deleted' => 1],
            ['id_k' => 6, 'nama_k' => 'massage', 'is_deleted' => 1],
            ['id_k' => 7, 'nama_k' => 'wajah', 'is_deleted' => 0],
            ['id_k' => 8, 'nama_k' => 'punggung', 'is_deleted' => 0],
            ['id_k' => 9, 'nama_k' => 'kulit', 'is_deleted' => 1],
            ['id_k' => 10, 'nama_k' => 'kewanitaan', 'is_deleted' => 1],
        ]);

        DB::table('menulayanan')->insert([
            ['id_m' => 1, 'id_kategori' => 2, 'nama_m' => 'potong rambut cowok', 'harga_m' => 10000.00, 'is_deleted' => 1],
            ['id_m' => 2, 'id_kategori' => 2, 'nama_m' => 'potong rambut cewe', 'harga_m' => 15000.00, 'is_deleted' => 1],
            ['id_m' => 4, 'id_kategori' => 6, 'nama_m' => 'totok wajah', 'harga_m' => 60000.00, 'is_deleted' => 1],
            ['id_m' => 5, 'id_kategori' => 6, 'nama_m' => 'keriting rambut', 'harga_m' => 300000.00, 'is_deleted' => 1],
            ['id_m' => 6, 'id_kategori' => 5, 'nama_m' => 'smooting cirateen', 'harga_m' => 120000.00, 'is_deleted' => 1],
            ['id_m' => 7, 'id_kategori' => 1, 'nama_m' => 'kriting', 'harga_m' => 300000.00, 'is_deleted' => 0],
            ['id_m' => 8, 'id_kategori' => 1, 'nama_m' => 'potong rambut wanita', 'harga_m' => 25000.00, 'is_deleted' => 0],
            ['id_m' => 9, 'id_kategori' => 1, 'nama_m' => 'potong rambut pria', 'harga_m' => 10000.00, 'is_deleted' => 0],
            ['id_m' => 10, 'id_kategori' => 1, 'nama_m' => 'creambath', 'harga_m' => 60000.00, 'is_deleted' => 0],
            ['id_m' => 11, 'id_kategori' => 7, 'nama_m' => 'facial', 'harga_m' => 60000.00, 'is_deleted' => 0],
            ['id_m' => 12, 'id_kategori' => 7, 'nama_m' => 'totok wajah', 'harga_m' => 60000.00, 'is_deleted' => 1],
            ['id_m' => 13, 'id_kategori' => 1, 'nama_m' => 'catok rambut', 'harga_m' => 20000.00, 'is_deleted' => 0],
            ['id_m' => 14, 'id_kategori' => 8, 'nama_m' => 'pijet punggung', 'harga_m' => 100000.00, 'is_deleted' => 0],
            ['id_m' => 15, 'id_kategori' => 1, 'nama_m' => 'keramas', 'harga_m' => 45000.00, 'is_deleted' => 0],
            ['id_m' => 16, 'id_kategori' => 8, 'nama_m' => 'sauna', 'harga_m' => 75000.00, 'is_deleted' => 0],
            ['id_m' => 17, 'id_kategori' => 1, 'nama_m' => 'sambung rambut', 'harga_m' => 200000.00, 'is_deleted' => 0],
            ['id_m' => 18, 'id_kategori' => 1, 'nama_m' => 'cuci free hair tonic', 'harga_m' => 20000.00, 'is_deleted' => 0],
            ['id_m' => 19, 'id_kategori' => 1, 'nama_m' => 'creambath tradisional', 'harga_m' => 75000.00, 'is_deleted' => 0],
            ['id_m' => 20, 'id_kategori' => 8, 'nama_m' => 'terapi punggung leher', 'harga_m' => 30000.00, 'is_deleted' => 0],
            ['id_m' => 21, 'id_kategori' => 1, 'nama_m' => 'hair spa loreal', 'harga_m' => 80000.00, 'is_deleted' => 0],
            ['id_m' => 22, 'id_kategori' => 1, 'nama_m' => 'creambath makarizo', 'harga_m' => 80000.00, 'is_deleted' => 0],
            ['id_m' => 23, 'id_kategori' => 1, 'nama_m' => 'hair masker matrix', 'harga_m' => 80000.00, 'is_deleted' => 0],
            ['id_m' => 24, 'id_kategori' => 1, 'nama_m' => 'hair masker lokal', 'harga_m' => 60000.00, 'is_deleted' => 0],
            ['id_m' => 25, 'id_kategori' => 7, 'nama_m' => 'facial latulip', 'harga_m' => 50000.00, 'is_deleted' => 0],
            ['id_m' => 26, 'id_kategori' => 7, 'nama_m' => 'facial biocos', 'harga_m' => 60000.00, 'is_deleted' => 0],
            ['id_m' => 27, 'id_kategori' => 7, 'nama_m' => 'totok aura', 'harga_m' => 50000.00, 'is_deleted' => 0],
            ['id_m' => 28, 'id_kategori' => 7, 'nama_m' => 'Ear candle', 'harga_m' => 30000.00, 'is_deleted' => 0],
            ['id_m' => 29, 'id_kategori' => 10, 'nama_m' => 'ratus', 'harga_m' => 50000.00, 'is_deleted' => 1],
            ['id_m' => 30, 'id_kategori' => 8, 'nama_m' => 'sauna', 'harga_m' => 50000.00, 'is_deleted' => 0],
            ['id_m' => 31, 'id_kategori' => 1, 'nama_m' => 'toning', 'harga_m' => 60000.00, 'is_deleted' => 0],
            ['id_m' => 32, 'id_kategori' => 1, 'nama_m' => 'blow variasi', 'harga_m' => 50000.00, 'is_deleted' => 0],
            ['id_m' => 33, 'id_kategori' => 1, 'nama_m' => 'coloring', 'harga_m' => 150000.00, 'is_deleted' => 0],
            ['id_m' => 34, 'id_kategori' => 1, 'nama_m' => 'smoothing makarizo', 'harga_m' => 200000.00, 'is_deleted' => 0],
            ['id_m' => 35, 'id_kategori' => 1, 'nama_m' => 'smoothing matrix', 'harga_m' => 250000.00, 'is_deleted' => 0],
            ['id_m' => 36, 'id_kategori' => 1, 'nama_m' => 'smoothing loreal', 'harga_m' => 300000.00, 'is_deleted' => 0],
            ['id_m' => 37, 'id_kategori' => 7, 'nama_m' => 'paket hair extention', 'harga_m' => 375000.00, 'is_deleted' => 0],
        ]);

        DB::table('pengguna')->insert([
            ['id_p' => 1, 'nama_p' => 'Administrator', 'username_p' => 'admin', 'password_p' => '$2y$10$LAtDPzlToZETX5tDqbFjD.U2ssJqkX5xCkGj62Kqk1nnPjzyXXvYa', 'foto_p' => null, 'role_p' => 'Admin'],
            ['id_p' => 3, 'nama_p' => 'HANA SYAFIYA', 'username_p' => 'hana', 'password_p' => '$2y$10$mEXepZnc8lDODu.BeL59e.PXV9JBMe7HZS.REhtph2vRM6BsuJEM6', 'foto_p' => null, 'role_p' => 'Kasir'],
            ['id_p' => 4, 'nama_p' => 'elia', 'username_p' => 'elia', 'password_p' => '$2y$10$vOY/rJ1LCxq7jF02VoSsjuot0giKr8HhKNx7GlSOO0QYmcxlsLz8W', 'foto_p' => null, 'role_p' => 'Kasir'],
        ]);

        DB::table('transaksikeluar')->insert([
            ['id_tk' => 1, 'judul_k' => 'tes', 'keterangan_k' => 'bayar liustrik', 'harga_k' => 900000.00, 'tanggal_k' => '2026-04-08'],
            ['id_tk' => 2, 'judul_k' => 'tes lagi', 'keterangan_k' => 'hasgyewgywed', 'harga_k' => 90000.00, 'tanggal_k' => '2026-04-08'],
            ['id_tk' => 3, 'judul_k' => 'tes lagi', 'keterangan_k' => 'hasgyewgywed', 'harga_k' => 90000.00, 'tanggal_k' => '2026-04-08'],
            ['id_tk' => 4, 'judul_k' => 'beli vitamin rambut ', 'keterangan_k' => '', 'harga_k' => 60000.00, 'tanggal_k' => '2026-04-20'],
            ['id_tk' => 5, 'judul_k' => 'obat netral smoothing', 'keterangan_k' => '', 'harga_k' => 150000.00, 'tanggal_k' => '2026-06-13'],
            ['id_tk' => 6, 'judul_k' => 'listrik salon', 'keterangan_k' => '', 'harga_k' => 20000.00, 'tanggal_k' => '2026-06-29'],
            ['id_tk' => 7, 'judul_k' => 'warna', 'keterangan_k' => 'warca green', 'harga_k' => 150.00, 'tanggal_k' => '2026-07-06'],
            ['id_tk' => 8, 'judul_k' => 'shampo', 'keterangan_k' => '', 'harga_k' => 250000.00, 'tanggal_k' => '2026-07-06'],
        ]);

        DB::table('transaksimasuk')->insert([
            ['id_t' => 1, 'id_pengguna' => 1, 'tanggal_t' => '2026-04-08 11:39:35', 'totalBayar_t' => 827567.00, 'bayar_t' => 0.00, 'kembali_t' => 0.00],
            ['id_t' => 2, 'id_pengguna' => 1, 'tanggal_t' => '2026-04-08 11:42:52', 'totalBayar_t' => 827567.00, 'bayar_t' => 0.00, 'kembali_t' => 0.00],
            ['id_t' => 3, 'id_pengguna' => 1, 'tanggal_t' => '2026-04-08 11:51:04', 'totalBayar_t' => 58899.00, 'bayar_t' => 100000.00, 'kembali_t' => 41101.00],
            ['id_t' => 4, 'id_pengguna' => 1, 'tanggal_t' => '2026-04-09 12:09:42', 'totalBayar_t' => 820466.00, 'bayar_t' => 1000000.00, 'kembali_t' => 179534.00],
            ['id_t' => 5, 'id_pengguna' => 1, 'tanggal_t' => '2026-04-20 18:39:18', 'totalBayar_t' => 120000.00, 'bayar_t' => 150000.00, 'kembali_t' => 30000.00],
            ['id_t' => 6, 'id_pengguna' => 1, 'tanggal_t' => '2026-04-20 18:39:51', 'totalBayar_t' => 120000.00, 'bayar_t' => 150000.00, 'kembali_t' => 30000.00],
            ['id_t' => 7, 'id_pengguna' => 1, 'tanggal_t' => '2026-04-27 20:58:59', 'totalBayar_t' => 60000.00, 'bayar_t' => 100000.00, 'kembali_t' => 40000.00],
            ['id_t' => 8, 'id_pengguna' => 3, 'tanggal_t' => '2026-04-27 21:06:40', 'totalBayar_t' => 60000.00, 'bayar_t' => 60000.00, 'kembali_t' => 0.00],
            ['id_t' => 9, 'id_pengguna' => 3, 'tanggal_t' => '2026-04-27 21:08:02', 'totalBayar_t' => 10000.00, 'bayar_t' => 10000.00, 'kembali_t' => 0.00],
            ['id_t' => 10, 'id_pengguna' => 1, 'tanggal_t' => '2026-06-09 18:58:16', 'totalBayar_t' => 60000.00, 'bayar_t' => 60000.00, 'kembali_t' => 0.00],
            ['id_t' => 11, 'id_pengguna' => 1, 'tanggal_t' => '2026-06-09 18:58:31', 'totalBayar_t' => 10000.00, 'bayar_t' => 20000.00, 'kembali_t' => 10000.00],
            ['id_t' => 12, 'id_pengguna' => 1, 'tanggal_t' => '2026-06-09 19:26:37', 'totalBayar_t' => 80000.00, 'bayar_t' => 100000.00, 'kembali_t' => 20000.00],
            ['id_t' => 13, 'id_pengguna' => 3, 'tanggal_t' => '2026-06-09 19:32:13', 'totalBayar_t' => 95000.00, 'bayar_t' => 100000.00, 'kembali_t' => 5000.00],
            ['id_t' => 14, 'id_pengguna' => 1, 'tanggal_t' => '2026-06-09 19:52:31', 'totalBayar_t' => 80000.00, 'bayar_t' => 100000.00, 'kembali_t' => 20000.00],
            ['id_t' => 15, 'id_pengguna' => 1, 'tanggal_t' => '2026-06-11 17:35:42', 'totalBayar_t' => 60000.00, 'bayar_t' => 100000.00, 'kembali_t' => 40000.00],
            ['id_t' => 16, 'id_pengguna' => 1, 'tanggal_t' => '2026-06-13 17:59:22', 'totalBayar_t' => 60000.00, 'bayar_t' => 100000.00, 'kembali_t' => 40000.00],
            ['id_t' => 17, 'id_pengguna' => 3, 'tanggal_t' => '2026-06-16 14:39:48', 'totalBayar_t' => 10000.00, 'bayar_t' => 20000.00, 'kembali_t' => 10000.00],
            ['id_t' => 18, 'id_pengguna' => 1, 'tanggal_t' => '2026-06-29 18:12:25', 'totalBayar_t' => 60000.00, 'bayar_t' => 70000.00, 'kembali_t' => 10000.00],
            ['id_t' => 19, 'id_pengguna' => 1, 'tanggal_t' => '2026-06-29 18:18:54', 'totalBayar_t' => 180000.00, 'bayar_t' => 200000.00, 'kembali_t' => 20000.00],
            ['id_t' => 20, 'id_pengguna' => 3, 'tanggal_t' => '2026-06-29 18:30:20', 'totalBayar_t' => 55000.00, 'bayar_t' => 60000.00, 'kembali_t' => 5000.00],
            ['id_t' => 21, 'id_pengguna' => 1, 'tanggal_t' => '2026-07-06 19:54:49', 'totalBayar_t' => 110000.00, 'bayar_t' => 200000.00, 'kembali_t' => 90000.00],
            ['id_t' => 22, 'id_pengguna' => 1, 'tanggal_t' => '2026-07-06 19:55:06', 'totalBayar_t' => 30000.00, 'bayar_t' => 50000.00, 'kembali_t' => 20000.00],
            ['id_t' => 23, 'id_pengguna' => 1, 'tanggal_t' => '2026-07-06 19:55:17', 'totalBayar_t' => 20000.00, 'bayar_t' => 50000.00, 'kembali_t' => 30000.00],
            ['id_t' => 24, 'id_pengguna' => 1, 'tanggal_t' => '2026-07-06 19:55:29', 'totalBayar_t' => 60000.00, 'bayar_t' => 100000.00, 'kembali_t' => 40000.00],
        ]);

        DB::table('detailtransaksi')->insert([
            ['id_detail' => 1, 'id_masuk' => 1, 'id_menu' => 4, 'harga_saat_ini' => 28000.00],
            ['id_detail' => 2, 'id_masuk' => 1, 'id_menu' => 5, 'harga_saat_ini' => 789567.00],
            ['id_detail' => 3, 'id_masuk' => 1, 'id_menu' => 1, 'harga_saat_ini' => 10000.00],
            ['id_detail' => 4, 'id_masuk' => 2, 'id_menu' => 4, 'harga_saat_ini' => 28000.00],
            ['id_detail' => 5, 'id_masuk' => 2, 'id_menu' => 5, 'harga_saat_ini' => 789567.00],
            ['id_detail' => 6, 'id_masuk' => 2, 'id_menu' => 1, 'harga_saat_ini' => 10000.00],
            ['id_detail' => 7, 'id_masuk' => 3, 'id_menu' => 1, 'harga_saat_ini' => 10000.00],
            ['id_detail' => 8, 'id_masuk' => 3, 'id_menu' => 2, 'harga_saat_ini' => 20899.00],
            ['id_detail' => 9, 'id_masuk' => 3, 'id_menu' => 4, 'harga_saat_ini' => 28000.00],
            ['id_detail' => 10, 'id_masuk' => 4, 'id_menu' => 2, 'harga_saat_ini' => 20899.00],
            ['id_detail' => 11, 'id_masuk' => 4, 'id_menu' => 1, 'harga_saat_ini' => 10000.00],
            ['id_detail' => 12, 'id_masuk' => 4, 'id_menu' => 5, 'harga_saat_ini' => 789567.00],
            ['id_detail' => 13, 'id_masuk' => 5, 'id_menu' => 6, 'harga_saat_ini' => 120000.00],
            ['id_detail' => 14, 'id_masuk' => 6, 'id_menu' => 6, 'harga_saat_ini' => 120000.00],
            ['id_detail' => 15, 'id_masuk' => 7, 'id_menu' => 10, 'harga_saat_ini' => 60000.00],
            ['id_detail' => 16, 'id_masuk' => 8, 'id_menu' => 11, 'harga_saat_ini' => 60000.00],
            ['id_detail' => 17, 'id_masuk' => 9, 'id_menu' => 9, 'harga_saat_ini' => 10000.00],
            ['id_detail' => 18, 'id_masuk' => 10, 'id_menu' => 10, 'harga_saat_ini' => 60000.00],
            ['id_detail' => 19, 'id_masuk' => 11, 'id_menu' => 9, 'harga_saat_ini' => 10000.00],
            ['id_detail' => 20, 'id_masuk' => 12, 'id_menu' => 13, 'harga_saat_ini' => 20000.00],
            ['id_detail' => 21, 'id_masuk' => 12, 'id_menu' => 11, 'harga_saat_ini' => 60000.00],
            ['id_detail' => 22, 'id_masuk' => 13, 'id_menu' => 13, 'harga_saat_ini' => 20000.00],
            ['id_detail' => 23, 'id_masuk' => 13, 'id_menu' => 10, 'harga_saat_ini' => 60000.00],
            ['id_detail' => 24, 'id_masuk' => 13, 'id_menu' => 8, 'harga_saat_ini' => 15000.00],
            ['id_detail' => 25, 'id_masuk' => 14, 'id_menu' => 13, 'harga_saat_ini' => 20000.00],
            ['id_detail' => 26, 'id_masuk' => 14, 'id_menu' => 10, 'harga_saat_ini' => 60000.00],
            ['id_detail' => 27, 'id_masuk' => 15, 'id_menu' => 10, 'harga_saat_ini' => 60000.00],
            ['id_detail' => 28, 'id_masuk' => 16, 'id_menu' => 10, 'harga_saat_ini' => 60000.00],
            ['id_detail' => 29, 'id_masuk' => 17, 'id_menu' => 9, 'harga_saat_ini' => 10000.00],
            ['id_detail' => 30, 'id_masuk' => 18, 'id_menu' => 8, 'harga_saat_ini' => 15000.00],
            ['id_detail' => 31, 'id_masuk' => 18, 'id_menu' => 15, 'harga_saat_ini' => 45000.00],
            ['id_detail' => 32, 'id_masuk' => 19, 'id_menu' => 14, 'harga_saat_ini' => 120000.00],
            ['id_detail' => 33, 'id_masuk' => 19, 'id_menu' => 10, 'harga_saat_ini' => 60000.00],
            ['id_detail' => 34, 'id_masuk' => 20, 'id_menu' => 15, 'harga_saat_ini' => 45000.00],
            ['id_detail' => 35, 'id_masuk' => 20, 'id_menu' => 9, 'harga_saat_ini' => 10000.00],
            ['id_detail' => 36, 'id_masuk' => 21, 'id_menu' => 10, 'harga_saat_ini' => 60000.00],
            ['id_detail' => 37, 'id_masuk' => 21, 'id_menu' => 32, 'harga_saat_ini' => 50000.00],
            ['id_detail' => 38, 'id_masuk' => 22, 'id_menu' => 28, 'harga_saat_ini' => 30000.00],
            ['id_detail' => 39, 'id_masuk' => 23, 'id_menu' => 18, 'harga_saat_ini' => 20000.00],
            ['id_detail' => 40, 'id_masuk' => 24, 'id_menu' => 26, 'harga_saat_ini' => 60000.00],
        ]);
    }
}
