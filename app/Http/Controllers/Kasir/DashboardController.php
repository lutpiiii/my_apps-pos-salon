<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksimasuk;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalTransaksi = Transaksimasuk::where('id_pengguna', Auth::id())
            ->whereDate('tanggal_t', $today)
            ->count();

        $omzet = Transaksimasuk::where('id_pengguna', Auth::id())
            ->whereDate('tanggal_t', $today)
            ->sum('totalBayar_t');

        // Assuming 1 transaction = 1 customer for now
        $pelanggan = $totalTransaksi;

        $recentTransactions = Transaksimasuk::with('detailTransaksis.menu')
            ->where('id_pengguna', Auth::id())
            ->whereDate('tanggal_t', $today)
            ->orderBy('tanggal_t', 'desc')
            ->take(5)
            ->get();

        return view('kasir.dashboard', compact('totalTransaksi', 'omzet', 'pelanggan', 'recentTransactions'));
    }
}
