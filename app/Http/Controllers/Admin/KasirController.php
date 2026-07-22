<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menulayanan;
use App\Models\Kategorilayanan;
use App\Models\Transaksimasuk;
use App\Models\Detailtransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        $categories = Kategorilayanan::where('is_deleted', false)->get();
        $menus = Menulayanan::where('is_deleted', false)->get();
        return view('admin.kasir.index', compact('categories', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_m' => 'required|exists:menulayanan,id_m',
            'total_bayar' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $transaksi = Transaksimasuk::create([
                'id_pengguna' => Auth::id(),
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

            DB::commit();

            // Encrypt ID for the response
            $encryptedId = \Illuminate\Support\Facades\Crypt::encryptString($transaksi->id_t);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil.',
                'id_t' => $encryptedId
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
