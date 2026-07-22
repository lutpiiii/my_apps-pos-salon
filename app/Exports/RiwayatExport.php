<?php

namespace App\Exports;

use App\Models\Transaksimasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RiwayatExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Transaksimasuk::with(['pengguna', 'detailTransaksis.menu']);

        // Filter by user ID if the user is a cashier
        if (auth()->user()->role_p === 'kasir') {
            $query->where('id_pengguna', auth()->id());
        } elseif ($this->request->filled('id_pengguna')) {
            $query->where('id_pengguna', $this->request->id_pengguna);
        }

        if ($this->request->filled('tanggal')) {
            $query->whereDate('tanggal_t', $this->request->tanggal);
        }

        return $query->orderBy('tanggal_t', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Kasir',
            'Total Bayar',
            'Layanan',
        ];
    }

    public function map($trx): array
    {
        static $no = 1;
        $layanan = $trx->detailTransaksis->map(function($d) {
            return $d->menu->nama_m ?? '-';
        })->implode(', ');

        return [
            $no++,
            $trx->tanggal_t->format('d/m/Y H:i'),
            $trx->pengguna->nama_p ?? '-',
            'Rp ' . number_format($trx->totalBayar_t, 0, ',', '.'),
            $layanan,
        ];
    }
}
