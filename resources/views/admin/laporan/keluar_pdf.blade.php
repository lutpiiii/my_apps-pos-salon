<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengeluaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #fff1f2; color: #be123c; }
        .header { text-align: center; margin-bottom: 30px; }
        .summary { margin-top: 30px; padding: 20px; background-color: #fff1f2; border-radius: 10px; }
        .text-danger { color: #be123c; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="color: #581c87; margin-bottom: 5px;">NH BEAUTY SALON</h2>
        <p style="margin: 0; font-weight: bold;">Laporan Pengeluaran ({{ ucfirst($filterType) }})</p>
        <p style="font-size: 10px; color: #666;">Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Keterangan</th>
                <th style="text-align: right;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tanggal_k->format('d/m/Y') }}</td>
                <td>{{ $item->judul_k }}</td>
                <td>{{ $item->keterangan_k }}</td>
                <td style="text-align: right;">Rp {{ number_format($item->harga_k, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <table style="border: none; margin-top: 0;">
            <tr style="border: none;">
                <td style="border: none; width: 70%; font-size: 14px; font-weight: bold;">TOTAL PENGELUARAN</td>
                <td style="border: none; width: 30%; font-size: 14px; font-weight: bold; text-align: right;" class="text-danger">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
