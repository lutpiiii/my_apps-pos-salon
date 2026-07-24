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
        Schema::table('transaksimasuk', function (Blueprint $table) {
            $table->unsignedBigInteger('id_reservasi')->nullable()->after('id_pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksimasuk', function (Blueprint $table) {
            $table->dropColumn('id_reservasi');
        });
    }
};
