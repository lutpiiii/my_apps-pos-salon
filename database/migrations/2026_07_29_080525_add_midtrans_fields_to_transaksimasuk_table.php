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
            $table->enum('metode_pembayaran', ['Tunai', 'QRIS'])->default('Tunai')->after('id_reservasi');
            $table->string('status_pembayaran', 50)->default('Selesai')->after('metode_pembayaran');
            $table->string('midtrans_order_id', 100)->nullable()->after('status_pembayaran');
            $table->text('qr_url')->nullable()->after('midtrans_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksimasuk', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'status_pembayaran', 'midtrans_order_id', 'qr_url']);
        });
    }
};
