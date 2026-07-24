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
        Schema::create('reservasi', function (Blueprint $table) {
            $table->unsignedInteger('id_r')->autoIncrement();
            $table->string('kode_reservasi', 30)->unique();
            $table->string('nama_pelanggan', 100);
            $table->string('notelp_pelanggan', 20);
            $table->string('email_pelanggan', 100)->nullable();
            $table->unsignedInteger('id_menu')->nullable();
            $table->unsignedInteger('id_stylist')->nullable();
            $table->date('tanggal_reservasi');
            $table->time('jam_reservasi');
            $table->text('catatan')->nullable();
            $table->enum('status', ['Menunggu', 'Disetujui', 'Selesai', 'Dibatalkan'])->default('Menunggu');
            $table->timestamps();

            $table->primary('id_r');
            $table->foreign('id_menu')->references('id_m')->on('menulayanan')->onDelete('set null');
            $table->foreign('id_stylist')->references('id_p')->on('pengguna')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
