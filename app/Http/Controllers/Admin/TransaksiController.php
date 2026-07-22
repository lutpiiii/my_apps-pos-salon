<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksimasuk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanMasukExport;
use App\Exports\RiwayatExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;

class TransaksiController extends Controller
{
    public function riwayat(Request $request)
    {
        $query = Transaksimasuk::with(['pengguna', 'detailTransaksis.menu']);

        // Filter by user ID if the user is a cashier
        if (auth()->user()->role_p === 'kasir') {
            $query->where('id_pengguna', auth()->id());
        } elseif ($request->filled('id_pengguna')) {
            // Admin can filter by any user
            $query->where('id_pengguna', $request->id_pengguna);
        }

        // Single Date Filter (Daily Only)
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_t', $request->tanggal);
        }

        if ($request->has('export')) {
            $type = $request->export;
            if ($type === 'excel') {
                return Excel::download(new RiwayatExport($request), 'riwayat_transaksi.xlsx');
            } elseif ($type === 'pdf') {
                $transaksi = $query->orderBy('tanggal_t', 'desc')->get();
                $pdf = Pdf::loadView('admin.riwayat.pdf', compact('transaksi'));
                return $pdf->download('riwayat_transaksi.pdf');
            }
        }

        $transaksi = $query->orderBy('tanggal_t', 'desc')->paginate(10);

        // Encrypt IDs for view
        foreach ($transaksi as $item) {
            $item->encrypted_id = Crypt::encryptString($item->id_t);
        }

        $users = auth()->user()->role_p === 'admin' ? \App\Models\Pengguna::all() : collect();

        return view('admin.riwayat.index', compact('transaksi', 'users'));
    }

    public function laporanMasuk(Request $request)
    {
        $query = Transaksimasuk::with(['pengguna', 'detailTransaksis.menu']);

        $filterType = $request->input('filter_type', 'harian');

        if ($filterType === 'harian' && $request->filled('tanggal')) {
            $query->whereDate('tanggal_t', $request->tanggal);
        } elseif ($filterType === 'range' && $request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_t', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($filterType === 'tahunan' && $request->filled('tahun')) {
            $query->whereYear('tanggal_t', $request->tahun);
        }

        if ($request->has('export')) {
            $type = $request->export;
            if ($type === 'excel') {
                return Excel::download(new LaporanMasukExport($request), 'laporan_pendapatan.xlsx');
            } elseif ($type === 'pdf') {
                $totalPendapatan = $query->sum('totalBayar_t');
                $transaksi = $query->orderBy('tanggal_t', 'desc')->get();
                $pdf = Pdf::loadView('admin.laporan.masuk_pdf', compact('transaksi', 'totalPendapatan', 'filterType'));
                return $pdf->download('laporan_pendapatan.pdf');
            }
        }

        $totalPendapatan = $query->sum('totalBayar_t');
        $transaksi = $query->orderBy('tanggal_t', 'desc')->paginate(15);

        return view('admin.laporan.masuk', compact('transaksi', 'totalPendapatan', 'filterType'));
    }

    public function show($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
            $transaksi = Transaksimasuk::with(['pengguna', 'detailTransaksis.menu'])->findOrFail($decryptedId);
        } catch (\Exception $e) {
            // Fallback for non-encrypted ID (during transition or if needed)
            $transaksi = Transaksimasuk::with(['pengguna', 'detailTransaksis.menu'])->findOrFail($id);
        }

        // Security check for cashier
        if (auth()->user()->role_p === 'kasir' && $transaksi->id_pengguna !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($transaksi);
    }

    public function cetakStruk($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
            $transaksi = Transaksimasuk::with(['pengguna', 'detailTransaksis.menu'])->findOrFail($decryptedId);
        } catch (\Exception $e) {
            $transaksi = Transaksimasuk::with(['pengguna', 'detailTransaksis.menu'])->findOrFail($id);
        }

        // Security check for cashier
        if (auth()->user()->role_p === 'kasir' && $transaksi->id_pengguna !== auth()->id()) {
            abort(403);
        }

        $profile = \App\Models\Profilesalon::first();
        return view('admin.kasir.struk', compact('transaksi', 'profile'));
    }
}
