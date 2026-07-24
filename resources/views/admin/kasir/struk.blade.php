<!DOCTYPE html>
<html>
<head>
    <style>
        @page { size: 58mm 200mm; margin: 0; }
        body { font-family: 'Courier New', Courier, monospace; width: 58mm; padding: 5mm; margin: 0; font-size: 10px; color: #000; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }
        .header { margin-bottom: 10px; }
        .header h3 { margin: 0; font-size: 14px; }
        .item { margin-bottom: 5px; }
        .footer { margin-top: 15px; }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center header">
        <h3 style="color: #581c87;">NH BEAUTY SALON</h3>
        <p>Jl. Raya Indah No. 123, Surabaya<br>Telp: 628993959351</p>
    </div>

    <div class="line"></div>

    <div>
        No: {{ $transaksi->kode_t }}<br>
        Tgl: {{ $transaksi->tanggal_t->format('d/m/Y H:i') }}<br>
        Kasir: {{ $transaksi->pengguna->nama_p }}
    </div>

    <div class="line"></div>

    @foreach($transaksi->detailTransaksis as $detail)
    <div class="item">
        <div style="display: flex; justify-content: space-between;">
            <span style="flex: 1;">{{ $detail->menu->nama_m }}</span>
            <span style="text-align: right; white-space: nowrap;">{{ $detail->jumlah }} x {{ number_format($detail->harga_saat_ini, 0, ',', '.') }}</span>
        </div>
    </div>
    @endforeach

    <div class="line"></div>

    <table style="width: 100%;">
        <tr>
            <td>TOTAL:</td>
            <td class="text-right">Rp {{ number_format($transaksi->totalBayar_t, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>BAYAR:</td>
            <td class="text-right">Rp {{ number_format($transaksi->bayar_t, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>KEMBALI:</td>
            <td class="text-right">Rp {{ number_format($transaksi->kembali_t, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="text-center footer">
        <p>TERIMA KASIH ATAS<br>KUNJUNGAN ANDA</p>
        <p>Glow Up with Us!</p>
    </div>
</body>
</html>
