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
        Schema::table('reservasi', function (Blueprint $table) {
            // Change enum to string to allow more flexible status values like 'Ditolak'
            $table->string('status', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            // Revert back to enum if necessary (ensure 'Ditolak' is included in enum if reverting)
            $table->enum('status', ['Menunggu', 'Disetujui', 'Selesai', 'Dibatalkan', 'Ditolak'])->change();
        });
    }
};
