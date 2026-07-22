<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksimasuk;
use App\Models\Menulayanan;
use App\Models\Kategorilayanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Today's Revenue
        $pendapatanHariIni = Transaksimasuk::whereDate('tanggal_t', $today)->sum('totalBayar_t');

        // 2. Completed Transactions today
        $transaksiSelesai = Transaksimasuk::whereDate('tanggal_t', $today)->count();

        // 3. Total Customers (Unique transactions for today)
        $totalPelanggan = Transaksimasuk::whereDate('tanggal_t', $today)->count(); // Simplified for now

        // 4. Active Services
        $layananAktif = Menulayanan::where('is_deleted', false)->count();

        // 5. Recent Transactions
        $recentTransactions = Transaksimasuk::with(['pengguna', 'detailTransaksis.menu'])
            ->orderBy('tanggal_t', 'desc')
            ->take(5)
            ->get();

        // 6. Top Services (Most ordered)
        $topServices = DB::table('detailtransaksi')
            ->join('menulayanan', 'detailtransaksi.id_menu', '=', 'menulayanan.id_m')
            ->select('menulayanan.nama_m', DB::raw('count(*) as total'))
            ->groupBy('menulayanan.nama_m')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // 7. Sales Chart Data (Last 7 Days)
        $salesData = [];
        $salesLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $salesLabels[] = $date->format('d M');
            $salesData[] = Transaksimasuk::whereDate('tanggal_t', $date)->sum('totalBayar_t');
        }

        return view('admin.dashboard', compact(
            'pendapatanHariIni',
            'transaksiSelesai',
            'totalPelanggan',
            'layananAktif',
            'recentTransactions',
            'topServices',
            'salesData',
            'salesLabels'
        ));
    }
}
