<?php

namespace App\Exports;

use App\Models\Transaksimasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanMasukExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Transaksimasuk::with(['pengguna', 'detailTransaksis.menu']);

        $filterType = $this->request->get('filter_type', 'harian');

        if ($filterType === 'harian' && $this->request->filled('tanggal')) {
            $query->whereDate('tanggal_t', $this->request->tanggal);
        } elseif ($filterType === 'range' && $this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('tanggal_t', [$this->request->start_date . ' 00:00:00', $this->request->end_date . ' 23:59:59']);
        } elseif ($filterType === 'tahunan' && $this->request->filled('tahun')) {
            $query->whereYear('tanggal_t', $this->request->tahun);
        }

        return $query->orderBy('tanggal_t', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal',
            'Layanan',
            'Kasir',
            'Total Bayar',
        ];
    }

    public function map($trx): array
    {
        $layanan = $trx->detailTransaksis->map(function($d) {
            return $d->menu->nama_m ?? '-';
        })->implode(', ');

        return [
            'TRX-' . $trx->id_t,
            $trx->tanggal_t->format('d/m/Y H:i'),
            $layanan,
            $trx->pengguna->nama_p ?? '-',
            'Rp ' . number_format($trx->totalBayar_t, 0, ',', '.'),
        ];
    }
}
