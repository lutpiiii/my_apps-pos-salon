@extends('layouts.dashboard.kasir')

@section('content')
<div class="container-fluid">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card card-refined border-0 bg-white p-4 shadow-sm">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold topbar-title mb-2">Semangat Bekerja, {{ Auth::user()->nama_p }}! ✨</h2>
                        <p class="text-muted mb-0">Berikan layanan terbaik untuk pelanggan NH Beauty Salon hari ini.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('admin.kasir.index') }}" class="btn btn-purple-refined shadow-sm">
                            <i class="bi bi-plus-lg me-2"></i> Transaksi Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card-gradient shadow-sm" style="background: linear-gradient(135deg, #6366f1, #818cf8);">
                <div class="icon-box-refined mb-3">
                    <i class="bi bi-receipt"></i>
                </div>
                <h6 class="opacity-75 small mb-1 fw-bold text-uppercase">Total Transaksi (Hari Ini)</h6>
                <h2 class="fw-bold mb-0">{{ $totalTransaksi }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card-gradient shadow-sm" style="background: linear-gradient(135deg, #10b981, #34d399);">
                <div class="icon-box-refined mb-3">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <h6 class="opacity-75 small mb-1 fw-bold text-uppercase">Omzet (Hari Ini)</h6>
                <h2 class="fw-bold mb-0">Rp {{ number_format($omzet, 0, ',', '.') }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card-gradient shadow-sm" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                <div class="icon-box-refined mb-3">
                    <i class="bi bi-person-check"></i>
                </div>
                <h6 class="opacity-75 small mb-1 fw-bold text-uppercase">Pelanggan Dilayani</h6>
                <h2 class="fw-bold mb-0">{{ $pelanggan }}</h2>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-transparent border-0">
                <h5 class="fw-bold mb-4">Transaksi Terakhir Anda</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>ID TRX</th>
                                <th>Layanan</th>
                                <th>Total</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $trx)
                            <tr class="shadow-sm mb-2">
                                <td class="fw-bold">{{ $trx->tanggal_t->format('H:i') }}</td>
                                <td>#TRX-{{ $trx->id_t }}</td>
                                <td>
                                    @foreach($trx->detailTransaksis as $detail)
                                        <span class="badge bg-purple-ultra-light text-purple-600 rounded-pill" style="font-size: 0.7rem;">{{ $detail->menu->nama_m }}</span>
                                    @endforeach
                                </td>
                                <td class="text-purple-600 fw-bold">Rp {{ number_format($trx->totalBayar_t, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light text-primary rounded-pill px-3" onclick="showDetail({{ $trx->id_t }})">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted bg-white rounded-4 shadow-sm">Belum ada transaksi terekam hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reuse the Detail Modal from Admin if possible, or we need to add it here too -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-refined shadow-lg">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold text-purple-600">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="detailContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-purple-600" role="status"></div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showDetail(id) {
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        const content = document.getElementById('detailContent');
        content.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-purple-600" role="status"></div></div>';
        modal.show();

        fetch(`/admin/transaksi/${id}`)
            .then(response => response.json())
            .then(data => {
                let itemsHtml = '';
                data.detail_transaksis.forEach(detail => {
                    itemsHtml += `
                        <div class="d-flex justify-content-between mb-2">
                            <span>${detail.menu.nama_m}</span>
                            <span class="fw-bold">Rp ${new Intl.NumberFormat('id-ID').format(detail.harga_saat_ini)}</span>
                        </div>
                    `;
                });

                content.innerHTML = `
                    <div class="mb-4">
                        <div class="small text-muted text-uppercase mb-1">ID Transaksi</div>
                        <div class="fw-bold">#TRX-${data.id_t}</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="small text-muted text-uppercase mb-1">Tanggal</div>
                            <div class="fw-bold">${new Date(data.tanggal_t).toLocaleString('id-ID')}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted text-uppercase mb-1">Kasir</div>
                            <div class="fw-bold">${data.pengguna.nama_p}</div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="small text-muted text-uppercase mb-2">Layanan Dipesan</div>
                        <div class="p-3 bg-light rounded-4">
                            ${itemsHtml}
                            <hr class="opacity-50">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold text-purple-600">Rp ${new Intl.NumberFormat('id-ID').format(data.totalBayar_t)}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-muted">Dibayar</div>
                        <div class="col-6 text-end fw-bold">Rp ${new Intl.NumberFormat('id-ID').format(data.bayar_t)}</div>
                        <div class="col-6 text-muted">Kembali</div>
                        <div class="col-6 text-end fw-bold text-success">Rp ${new Intl.NumberFormat('id-ID').format(data.kembali_t)}</div>
                    </div>
                `;
            })
            .catch(error => {
                content.innerHTML = '<div class="alert alert-danger">Gagal mengambil data detail.</div>';
            });
    }
</script>
@endsection
