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

class KasirController extends Controller
{
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
        ]);

        try {
            DB::beginTransaction();

            $transaksi = Transaksimasuk::create([
                'id_pengguna' => Auth::id(),
                'id_reservasi' => $request->booking_id ?? null,
                'tanggal_t' => now(),
                'totalBayar_t' => $request->total_bayar,
                'bayar_t' => $request->bayar,
                'kembali_t' => $request->bayar - $request->total_bayar,
            ]);

            foreach ($request->items as $item) {
                $menu = Menulayanan::find($item['id_m']);
                Detailtransaksi::create([
                    'id_masuk' => $transaksi->id_t,
                    'id_menu' => $item['id_m'],
                    'harga_saat_ini' => $menu->harga_m,
                ]);
            }

            // Update booking status if processed from reservation
            if ($request->filled('booking_id')) {
                $booking = Reservasi::find($request->booking_id);
                if ($booking) {
                    $booking->update(['status' => 'Selesai']);
                }
            }

            DB::commit();

            // Encrypt ID for the response (URL Safe)
            $encryptedId = \Illuminate\Support\Facades\Crypt::encryptString($transaksi->id_t);
            $urlSafeId = str_replace(['+', '/', '='], ['-', '_', ''], $encryptedId);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil.',
                'id_t' => $urlSafeId
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
