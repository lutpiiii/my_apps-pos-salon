<?php

namespace App\Exports;

use App\Models\Transaksikeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanKeluarExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Transaksikeluar::query();

        $filterType = $this->request->get('filter_type', 'harian');

        if ($filterType === 'harian' && $this->request->filled('tanggal')) {
            $query->whereDate('tanggal_k', $this->request->tanggal);
        } elseif ($filterType === 'range' && $this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('tanggal_k', [$this->request->start_date, $this->request->end_date]);
        } elseif ($filterType === 'tahunan' && $this->request->filled('tahun')) {
            $query->whereYear('tanggal_k', $this->request->tahun);
        }

        return $query->orderBy('tanggal_k', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Judul',
            'Keterangan',
            'Jumlah (Rp)',
        ];
    }

    public function map($item): array
    {
        static $no = 1;
        return [
            $no++,
            $item->tanggal_k->format('d/m/Y'),
            $item->judul_k,
            $item->keterangan_k,
            'Rp ' . number_format($item->harga_k, 0, ',', '.'),
        ];
    }
}
