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
        Schema::create('detailreservasi', function (Blueprint $table) {
            $table->unsignedInteger('id_dr')->autoIncrement();
            $table->unsignedInteger('id_reservasi');
            $table->unsignedInteger('id_menu')->nullable();
            $table->decimal('harga_saat_ini', 10, 2);
            $table->integer('jumlah')->default(1);
            $table->timestamps();

            $table->primary('id_dr');
            $table->foreign('id_reservasi')->references('id_r')->on('reservasi')->onDelete('cascade');
            $table->foreign('id_menu')->references('id_m')->on('menulayanan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailreservasi');
    }
};
