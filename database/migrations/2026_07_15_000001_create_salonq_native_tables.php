<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->unsignedInteger('id_p')->autoIncrement();
            $table->string('nama_p', 100);
            $table->string('username_p', 50)->unique();
            $table->string('password_p');
            $table->string('foto_p')->nullable();
            $table->enum('role_p', ['Admin', 'Kasir', 'Stylist']);
            $table->primary('id_p');
        });

        Schema::create('kategorilayanan', function (Blueprint $table) {
            $table->unsignedInteger('id_k')->autoIncrement();
            $table->string('nama_k', 50);
            $table->boolean('is_deleted')->default(false);
            $table->primary('id_k');
        });

        Schema::create('menulayanan', function (Blueprint $table) {
            $table->unsignedInteger('id_m')->autoIncrement();
            $table->unsignedInteger('id_kategori')->nullable();
            $table->string('nama_m', 100);
            $table->decimal('harga_m', 10, 2);
            $table->boolean('is_deleted')->default(false);
            $table->primary('id_m');
            $table->foreign('id_kategori')->references('id_k')->on('kategorilayanan');
        });

        Schema::create('transaksimasuk', function (Blueprint $table) {
            $table->unsignedInteger('id_t')->autoIncrement();
            $table->unsignedInteger('id_pengguna')->nullable();
            $table->dateTime('tanggal_t')->useCurrent();
            $table->decimal('totalBayar_t', 10, 2)->default(0.00);
            $table->decimal('bayar_t', 10, 2)->default(0.00);
            $table->decimal('kembali_t', 10, 2)->default(0.00);
            $table->primary('id_t');
            $table->foreign('id_pengguna')->references('id_p')->on('pengguna');
        });

        Schema::create('detailtransaksi', function (Blueprint $table) {
            $table->unsignedInteger('id_detail')->autoIncrement();
            $table->unsignedInteger('id_masuk')->nullable();
            $table->unsignedInteger('id_menu')->nullable();
            $table->decimal('harga_saat_ini', 10, 2)->nullable();
            $table->primary('id_detail');
            $table->foreign('id_masuk')->references('id_t')->on('transaksimasuk')->onDelete('cascade');
            $table->foreign('id_menu')->references('id_m')->on('menulayanan');
        });

        Schema::create('profilesalon', function (Blueprint $table) {
            $table->unsignedInteger('id_prf')->autoIncrement();
            $table->string('nama_prf', 100);
            $table->text('keterangan_prf')->nullable();
            $table->string('notelp_prf', 20)->nullable();
            $table->string('email_prf', 100)->nullable();
            $table->primary('id_prf');
        });

        Schema::create('infosalon', function (Blueprint $table) {
            $table->unsignedInteger('id_inf')->autoIncrement();
            $table->string('judul_inf', 200)->nullable();
            $table->string('foto_inf', 255)->nullable();
            $table->text('keterangan_inf')->nullable();
            $table->primary('id_inf');
        });

        Schema::create('transaksikeluar', function (Blueprint $table) {
            $table->unsignedInteger('id_tk')->autoIncrement();
            $table->string('judul_k', 100);
            $table->text('keterangan_k')->nullable();
            $table->decimal('harga_k', 10, 2);
            $table->date('tanggal_k');
            $table->primary('id_tk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailtransaksi');
        Schema::dropIfExists('transaksimasuk');
        Schema::dropIfExists('transaksikeluar');
        Schema::dropIfExists('infosalon');
        Schema::dropIfExists('profilesalon');
        Schema::dropIfExists('menulayanan');
        Schema::dropIfExists('kategorilayanan');
        Schema::dropIfExists('pengguna');
    }
};
