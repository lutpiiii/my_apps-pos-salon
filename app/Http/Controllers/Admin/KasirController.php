<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menulayanan;
use App\Models\Kategorilayanan;
use App\Models\Transaksimasuk;
use App\Models\Detailtransaksi;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\CoreApi;

class KasirController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }
    public function index(Request $request)
    {
        $categories = Kategorilayanan::where('is_deleted', false)->get();
        $menus = Menulayanan::where('is_deleted', false)->get();

        $bookingInfo = null;
        if ($request->has('booking_id')) {
            $booking = Reservasi::with('details.menu')->find($request->booking_id);
            if ($booking) {
                $itemIds = [];
                if ($request->has('menu_ids')) {
                    $itemIds = array_filter(explode(',', $request->menu_ids));
                } elseif ($booking->details->count() > 0) {
                    foreach ($booking->details as $d) {
                        for ($i = 0; $i < ($d->jumlah ?? 1); $i++) {
                            $itemIds[] = $d->id_menu;
                        }
                    }
                } elseif ($booking->id_menu) {
                    $itemIds[] = $booking->id_menu;
                }

                $bookingInfo = [
                    'id' => $booking->id_r,
                    'kode' => $booking->kode_reservasi,
                    'nama' => $booking->nama_pelanggan,
                    'item_ids' => $itemIds,
                ];
            }
        }

        return view('admin.kasir.index', compact('categories', 'menus', 'bookingInfo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_m' => 'required|exists:menulayanan,id_m',
            'total_bayar' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
            'booking_id' => 'nullable|exists:reservasi,id_r',
            'metode_pembayaran' => 'required|in:Tunai,QRIS',
        ]);

        try {
            DB::beginTransaction();

            $metode = $request->metode_pembayaran;
            $status_pembayaran = ($metode === 'Tunai') ? 'Selesai' : 'Pending';
            $bayar = ($metode === 'Tunai') ? $request->bayar : 0;
            $kembali = ($metode === 'Tunai') ? ($request->bayar - $request->total_bayar) : 0;

            $transaksi = Transaksimasuk::create([
                'id_pengguna' => Auth::id(),
                'id_reservasi' => $request->booking_id ?? null,
                'tanggal_t' => now(),
                'totalBayar_t' => $request->total_bayar,
                'bayar_t' => $bayar,
                'kembali_t' => $kembali,
                'metode_pembayaran' => $metode,
                'status_pembayaran' => $status_pembayaran,
            ]);

            foreach ($request->items as $item) {
                $menu = Menulayanan::find($item['id_m']);
                Detailtransaksi::create([
                    'id_masuk' => $transaksi->id_t,
                    'id_menu' => $item['id_m'],
                    'harga_saat_ini' => $menu->harga_m,
                ]);
            }

            $qrUrl = null;
            $midtransOrderId = null;

            if ($metode === 'QRIS') {
                $midtransOrderId = 'POS-' . time() . '-' . $transaksi->id_t;

                $params = [
                    'payment_type' => 'qris',
                    'transaction_details' => [
                        'order_id' => $midtransOrderId,
                        'gross_amount' => (int) $request->total_bayar,
                    ],
                    'customer_details' => [
                        'first_name' => 'Pelanggan POS',
                    ],
                ];

                $charge = CoreApi::charge($params);

                if (isset($charge->actions)) {
                    foreach ($charge->actions as $action) {
                        if ($action->name === 'generate-qr-code') {
                            $qrUrl = $action->url;
                            break;
                        }
                    }
                }

                $transaksi->update([
                    'midtrans_order_id' => $midtransOrderId,
                    'qr_url' => $qrUrl,
                ]);
            } else {
                // Update booking status if processed from reservation (Cash only for now, or move to webhook for QRIS)
                if ($request->filled('booking_id')) {
                    $booking = Reservasi::find($request->booking_id);
                    if ($booking) {
                        $booking->update(['status' => 'Selesai']);
                    }
                }
            }

            DB::commit();

            // Encrypt ID for the response (URL Safe)
            $encryptedId = \Illuminate\Support\Facades\Crypt::encryptString($transaksi->id_t);
            $urlSafeId = str_replace(['+', '/', '='], ['-', '_', ''], $encryptedId);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil' . ($metode === 'QRIS' ? ' (Menunggu Pembayaran).' : '.'),
                'id_t' => $urlSafeId,
                'qr_url' => $qrUrl,
                'order_id' => $midtransOrderId,
                'metode' => $metode
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
