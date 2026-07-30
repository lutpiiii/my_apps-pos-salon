<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksimasuk;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function callback(Request $request)
    {
        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status;

            $transaksi = Transaksimasuk::where('midtrans_order_id', $orderId)->first();

            if (!$transaksi) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $transaksi->status_pembayaran = 'Challenge';
                } else if ($fraudStatus == 'accept') {
                    $transaksi->status_pembayaran = 'Settlement';
                }
            } else if ($transactionStatus == 'settlement') {
                $transaksi->status_pembayaran = 'Settlement';
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $transaksi->status_pembayaran = $transactionStatus;
            } else if ($transactionStatus == 'pending') {
                $transaksi->status_pembayaran = 'Pending';
            }

            if ($transaksi->status_pembayaran === 'Settlement' || $transaksi->status_pembayaran === 'capture') {
                $transaksi->bayar_t = $transaksi->totalBayar_t;
                $transaksi->kembali_t = 0;
                $transaksi->status_pembayaran = 'Settlement'; // Normalize to Settlement for polling

                // Update booking status if exists
                if ($transaksi->id_reservasi) {
                    $booking = Reservasi::find($transaksi->id_reservasi);
                    if ($booking) {
                        $booking->update(['status' => 'Selesai']);
                    }
                }
            }

            $transaksi->save();

            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function checkStatus($orderId)
    {
        $transaksi = Transaksimasuk::where('midtrans_order_id', $orderId)->first();

        if (!$transaksi) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.']);
        }

        // Add manual check to Midtrans API to be more reliable in Sandbox
        if ($transaksi->status_pembayaran !== 'Settlement') {
            try {
                $status = \Midtrans\Transaction::status($orderId);
                $transactionStatus = $status->transaction_status;

                if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                    $transaksi->status_pembayaran = 'Settlement';
                    $transaksi->bayar_t = $transaksi->totalBayar_t;
                    $transaksi->kembali_t = 0;
                    $transaksi->save();

                    if ($transaksi->id_reservasi) {
                        $booking = Reservasi::find($transaksi->id_reservasi);
                        if ($booking) {
                            $booking->update(['status' => 'Selesai']);
                        }
                    }
                }
            } catch (\Exception $e) {
                // Ignore errors from Midtrans API during polling
            }
        }

        return response()->json([
            'success' => true,
            'status' => $transaksi->status_pembayaran,
            'id_t' => \Illuminate\Support\Facades\Crypt::encryptString($transaksi->id_t)
        ]);
    }
}
