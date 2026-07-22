<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f5f3ff; color: #581c87; }
        .header { text-align: center; margin-bottom: 30px; }
        .summary { margin-top: 30px; padding: 20px; background-color: #f5f3ff; border-radius: 10px; }
        .text-purple { color: #581c87; }
    </style>
</head>
<body>
    <div class="header">
        <h2 class="text-purple" style="margin-bottom: 5px;">NH BEAUTY SALON</h2>
        <p style="margin: 0; font-weight: bold;">Laporan Pendapatan ({{ ucfirst($filterType) }})</p>
        <p style="font-size: 10px; color: #666;">Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>ID TRX</th>
                <th>Layanan</th>
                <th>Kasir</th>
                <th style="text-align: right;">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tanggal_t->format('d/m/Y H:i') }}</td>
                <td>#TRX-{{ $item->id_t }}</td>
                <td>
                    @foreach($item->detailTransaksis as $detail)
                        {{ $detail->menu->nama_m }}{{ !$loop->last ? ',' : '' }}
                    @endforeach
                </td>
                <td>{{ $item->pengguna->nama_p }}</td>
                <td style="text-align: right;">Rp {{ number_format($item->totalBayar_t, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <table style="border: none; margin-top: 0;">
            <tr style="border: none;">
                <td style="border: none; width: 70%; font-size: 14px; font-weight: bold;">TOTAL PENDAPATAN</td>
                <td style="border: none; width: 30%; font-size: 14px; font-weight: bold; text-align: right;" class="text-purple">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
