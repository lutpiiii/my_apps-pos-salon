<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksikeluar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKeluarExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksikeluar::query();

        $filterType = $request->input('filter_type', 'harian');

        if ($filterType === 'harian' && $request->filled('tanggal')) {
            $query->whereDate('tanggal_k', $request->tanggal);
        } elseif ($filterType === 'range' && $request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_k', [$request->start_date, $request->end_date]);
        } elseif ($filterType === 'tahunan' && $request->filled('tahun')) {
            $query->whereYear('tanggal_k', $request->tahun);
        }

        if ($request->has('export')) {
            $type = $request->export;
            if ($type === 'excel') {
                return Excel::download(new LaporanKeluarExport($request), 'laporan_pengeluaran.xlsx');
            } elseif ($type === 'pdf') {
                $totalPengeluaran = $query->sum('harga_k');
                $transaksi = $query->orderBy('tanggal_k', 'desc')->get();
                $pdf = Pdf::loadView('admin.laporan.keluar_pdf', compact('transaksi', 'totalPengeluaran', 'filterType'));
                return $pdf->download('laporan_pengeluaran.pdf');
            }
        }

        $totalPengeluaran = $query->sum('harga_k');
        $transaksi = $query->orderBy('tanggal_k', 'desc')->paginate(15);

        return view('admin.laporan.keluar', compact('transaksi', 'totalPengeluaran', 'filterType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_k' => 'required|string|max:255',
            'keterangan_k' => 'required|string',
            'harga_k' => 'required|numeric|min:0',
            'tanggal_k' => 'required|date',
        ]);

        Transaksikeluar::create([
            'judul_k' => $request->judul_k,
            'keterangan_k' => $request->keterangan_k,
            'harga_k' => $request->harga_k,
            'tanggal_k' => $request->tanggal_k,
        ]);

        return redirect()->route('admin.laporan.keluar')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksikeluar::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('admin.laporan.keluar')->with('success', 'Catatan pengeluaran berhasil dihapus.');
    }
}
