<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Menulayanan;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with(['details.menu', 'menu', 'stylist'])->orderBy('created_at', 'desc');

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_reservasi', $request->tanggal);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('kode_reservasi', 'like', "%{$search}%")
                    ->orWhere('nama_pelanggan', 'like', "%{$search}%")
                    ->orWhere('notelp_pelanggan', 'like', "%{$search}%");
            });
        }

        $reservasiList = $query->paginate(15);
        $totalPending = Reservasi::where('status', 'Menunggu')->count();
        $totalDisetujui = Reservasi::where('status', 'Disetujui')->count();

        return view('admin.reservasi.index', compact('reservasiList', 'totalPending', 'totalDisetujui'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Selesai,Dibatalkan',
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status reservasi ' . $reservasi->kode_reservasi . ' berhasil diperbarui ke ' . $request->status);
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->delete();

        return redirect()->back()->with('success', 'Data reservasi berhasil dihapus.');
    }

    public function prosesKeKasir($id)
    {
        $reservasi = Reservasi::with('details.menu')->findOrFail($id);

        $menuIds = [];
        if ($reservasi->details && $reservasi->details->count() > 0) {
            foreach ($reservasi->details as $d) {
                for ($i = 0; $i < ($d->jumlah ?? 1); $i++) {
                    $menuIds[] = $d->id_menu;
                }
            }
        } elseif ($reservasi->id_menu) {
            $menuIds[] = $reservasi->id_menu;
        }

        // Redirect to Kasir POS with booking pre-filled info
        return redirect()->route('admin.kasir.index', [
            'booking_id' => $reservasi->id_r,
            'menu_ids' => implode(',', $menuIds),
            'nama' => $reservasi->nama_pelanggan,
        ])->with('success', 'Reservasi ' . $reservasi->kode_reservasi . ' dimuat ke Kasir POS.');
    }
}
