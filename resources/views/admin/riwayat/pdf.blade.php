<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f5f3ff; color: #581c87; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { text-align: right; margin-top: 30px; font-weight: bold; }
        .badge { background: #f5f3ff; color: #581c87; padding: 2px 8px; border-radius: 10px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="color: #581c87; margin-bottom: 5px;">NH BEAUTY SALON</h2>
        <p style="margin: 0;">Laporan Riwayat Transaksi</p>
        <p style="font-size: 10px; color: #666;">Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Kasir</th>
                <th>Layanan</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tanggal_t->format('d/m/Y H:i') }}</td>
                <td>{{ $item->kode_t }}</td>
                <td>{{ $item->pengguna->nama_p }}</td>
                <td>
                    @foreach($item->detailTransaksis as $detail)
                        {{ $detail->menu->nama_m }}{{ !$loop->last ? ',' : '' }}
                    @endforeach
                </td>
                <td>Rp {{ number_format($item->totalBayar_t, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
