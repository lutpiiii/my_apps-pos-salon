@extends('layouts.dashboard.admin')

@section('styles')
<style>
    .welcome-card {
        background: linear-gradient(135deg, var(--purple-main), var(--purple-medium));
        border-radius: 35px;
        padding: 40px;
        color: white;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }
    .welcome-card::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    .chart-container {
        height: 350px;
        width: 100%;
    }
    .top-service-item {
        border-left: 4px solid var(--purple-medium);
        transition: all 0.3s ease;
    }
    .top-service-item:hover {
        transform: scale(1.02);
        background: white !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Welcome Header -->
    <div class="welcome-card animate__animated animate__fadeIn">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold mb-2">Selamat Datang, {{ Auth::user()->nama_p }}! 👋</h1>
                <p class="opacity-75 fs-5 mb-0">Berikut adalah laporan performa salon Anda untuk hari ini.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="bg-opacity-20 d-inline-block p-3 rounded-4 backdrop-blur">
                    <h5 class="mb-0 fw-bold">{{ date('l, d F Y') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card-gradient shadow-sm" style="background: linear-gradient(135deg, #6366f1, #818cf8);">
                <div class="icon-box-refined"><i class="bi bi-wallet2"></i></div>
                <h6 class="opacity-75 small mb-1 mt-3 fw-bold text-uppercase">Pendapatan Hari Ini</h6>
                <h3 class="fw-bold mb-0">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-gradient shadow-sm" style="background: linear-gradient(135deg, #10b981, #34d399);">
                <div class="icon-box-refined"><i class="bi bi-cart-check"></i></div>
                <h6 class="opacity-75 small mb-1 mt-3 fw-bold text-uppercase">Transaksi Selesai</h6>
                <h3 class="fw-bold mb-0">{{ $transaksiSelesai }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-gradient shadow-sm" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                <div class="icon-box-refined"><i class="bi bi-people"></i></div>
                <h6 class="opacity-75 small mb-1 mt-3 fw-bold text-uppercase">Total Pelanggan</h6>
                <h3 class="fw-bold mb-0">{{ $totalPelanggan }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-gradient shadow-sm" style="background: linear-gradient(135deg, #ec4899, #f472b6);">
                <div class="icon-box-refined"><i class="bi bi-box-seam"></i></div>
                <h6 class="opacity-75 small mb-1 mt-3 fw-bold text-uppercase">Layanan Aktif</h6>
                <h3 class="fw-bold mb-0">{{ $layananAktif }}</h3>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <!-- Sales Chart -->
        <div class="col-lg-8">
            <div class="card card-refined border-0 shadow-sm p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-dark">Grafik Penjualan (7 Hari Terakhir)</h5>
                    <div class="badge bg-purple-ultra-light text-purple-600 rounded-pill px-3">Mingguan</div>
                </div>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Services -->
        <div class="col-lg-4">
            <div class="card card-refined border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark">Layanan Terlaris</h5>
                @forelse($topServices as $service)
                <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light rounded-4 top-service-item">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box bg-white text-purple-600 shadow-sm" style="width: 40px; height: 40px; font-size: 1rem; border-radius: 12px;">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <span class="fw-bold small text-dark">{{ $service->nama_m }}</span>
                    </div>
                    <span class="badge bg-purple-600 rounded-pill px-3">{{ $service->total }} Pesanan</span>
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-pie-chart fs-1 mb-3 d-block opacity-25"></i>
                    <p>Belum ada data penjualan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-transparent border-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-dark">Aktivitas Transaksi Terbaru</h5>
                    <a href="{{ route('admin.riwayat.index') }}" class="btn btn-sm btn-light rounded-pill px-4 fw-bold">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>ID Transaksi</th>
                                <th>Layanan</th>
                                <th>Total</th>
                                <th>Kasir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $index => $trx)
                            <tr class="shadow-sm mb-2">
                                <td class="text-muted">{{ $index + 1 }}</td>
                                <td class="fw-medium">{{ $trx->tanggal_t->format('H:i') }}</td>
                                <td class="fw-bold">#TRX-{{ $trx->id_t }}</td>
                                <td>
                                    @foreach($trx->detailTransaksis as $detail)
                                        <span>{{ $detail->menu->nama_m }}, </span>
                                    @endforeach
                                </td>
                                <td class="text-purple-600 fw-bold">Rp {{ number_format($trx->totalBayar_t, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-purple-ultra-light text-purple-600 d-flex align-items-center justify-content-center small fw-bold" style="width: 25px; height: 25px; font-size: 0.65rem;">
                                            {{ substr($trx->pengguna->nama_p, 0, 1) }}
                                        </div>
                                        <span class="small fw-bold text-dark">{{ $trx->pengguna->nama_p }}</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted bg-white rounded-4 shadow-sm">Belum ada transaksi hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');

        // Create Gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(88, 28, 135, 0.4)');
        gradient.addColorStop(1, 'rgba(88, 28, 135, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($salesLabels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($salesData),
                    borderColor: '#7e22ce',
                    borderWidth: 4,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#7e22ce',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection
