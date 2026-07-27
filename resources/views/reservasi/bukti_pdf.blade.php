<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Reservasi - {{ $reservasi->kode_reservasi }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #581c87;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #581c87;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #666;
        }
        .kode-container {
            background-color: #f3e8ff;
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .kode-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #7e22ce;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .kode-value {
            font-size: 22px;
            font-weight: bold;
            color: #581c87;
            letter-spacing: 2px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #581c87;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px 0;
            font-size: 13px;
        }
        .info-label {
            width: 30%;
            color: #666;
        }
        .info-value {
            width: 70%;
            font-weight: bold;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .item-table th {
            background-color: #f9fafb;
            text-align: left;
            padding: 10px;
            font-size: 12px;
            color: #581c87;
            border-bottom: 1px solid #ddd;
        }
        .item-table td {
            padding: 10px;
            font-size: 13px;
            border-bottom: 1px solid #eee;
        }
        .text-right {
            text-align: right;
        }
        .total-row td {
            padding-top: 15px;
            font-size: 16px;
            font-weight: bold;
            color: #581c87;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #999;
        }
        .catatan {
            background-color: #fffbeb;
            padding: 10px;
            border-left: 4px solid #f59e0b;
            font-size: 12px;
            font-style: italic;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>NH BEAUTY SALON</h1>
        <p>Jl. Raya Indah No. 123, Surabaya | Telp: 628993959351</p>
    </div>

    <div class="kode-container">
        <span class="kode-label">Kode Reservasi Anda</span>
        <span class="kode-value">{{ $reservasi->kode_reservasi }}</span>
    </div>

    <div class="section-title">Data Pelanggan & Jadwal</div>
    <table class="info-table">
        <tr>
            <td class="info-label">Nama Lengkap</td>
            <td class="info-value">: {{ $reservasi->nama_pelanggan }}</td>
        </tr>
        <tr>
            <td class="info-label">No. WhatsApp</td>
            <td class="info-value">: {{ $reservasi->notelp_pelanggan }}</td>
        </tr>
        <tr>
            <td class="info-label">Tanggal Kunjungan</td>
            <td class="info-value">: {{ date('d F Y', strtotime($reservasi->tanggal_reservasi)) }}</td>
        </tr>
        <tr>
            <td class="info-label">Jam Kedatangan</td>
            <td class="info-value">: {{ date('H:i', strtotime($reservasi->jam_reservasi)) }} WIB</td>
        </tr>
        <tr>
            <td class="info-label">Status</td>
            <td class="info-value">: {{ $reservasi->status }}</td>
        </tr>
    </table>

    <div class="section-title">Rincian Layanan</div>
    <table class="item-table">
        <thead>
            <tr>
                <th>Nama Layanan</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @if($reservasi->details && $reservasi->details->count() > 0)
                @foreach($reservasi->details as $item)
                @php $total += ($item->harga_saat_ini * $item->jumlah); @endphp
                <tr>
                    <td>{{ $item->menu->nama_m }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_saat_ini, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->jumlah }}x</td>
                    <td class="text-right">Rp {{ number_format($item->harga_saat_ini * $item->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @elseif($reservasi->menu)
                @php $total = $reservasi->menu->harga_m; @endphp
                <tr>
                    <td>{{ $reservasi->menu->nama_m }}</td>
                    <td class="text-right">Rp {{ number_format($reservasi->menu->harga_m, 0, ',', '.') }}</td>
                    <td class="text-right">1x</td>
                    <td class="text-right">Rp {{ number_format($reservasi->menu->harga_m, 0, ',', '.') }}</td>
                </tr>
            @endif
            <tr class="total-row">
                <td colspan="3" class="text-right">Estimasi Total Biaya:</td>
                <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    @if($reservasi->catatan)
    <div class="catatan">
        <strong>Catatan Khusus:</strong><br>
        "{{ $reservasi->catatan }}"
    </div>
    @endif

    <div class="footer">
        <p>Terima kasih telah mempercayakan perawatan Anda kepada NH Beauty Salon.<br>
        Harap tunjukkan bukti ini saat kedatangan Anda.</p>
        <p style="margin-top: 10px;"><em>Dokumen ini dihasilkan secara otomatis oleh sistem reservasi online.</em></p>
    </div>
</body>
</html>
