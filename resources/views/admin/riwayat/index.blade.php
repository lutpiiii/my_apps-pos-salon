@extends(strtolower(Auth::user()->role_p) === 'admin' ? 'layouts.dashboard.admin' : 'layouts.dashboard.kasir')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold topbar-title">Riwayat Transaksi</h3>
    </div>

    <!-- Filter Card -->
    <div class="card card-refined border-0 shadow-sm p-4 mb-4">
        <form action="{{ route('admin.riwayat.index') }}" method="GET" class="row g-3 align-items-end">
            @if(auth()->user()->role_p === 'admin')
            <div class="col-md-3">
                <label class="form-label fw-bold small text-muted text-uppercase">Kasir</label>
                <select name="id_pengguna" class="form-select rounded-pill border-2">
                    <option value="">Semua Kasir</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id_p }}" {{ request('id_pengguna') == $user->id_p ? 'selected' : '' }}>{{ $user->nama_p }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-4">
                <label class="form-label fw-bold small text-muted text-uppercase">Pilih Tanggal</label>
                <input type="date" name="tanggal" class="form-control rounded-pill border-2" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-purple-refined w-100">
                        <i class="bi bi-search me-2"></i> Filter
                    </button>
                    <div class="dropdown w-100">
                        <button class="btn btn-outline-purple rounded-pill w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu border-0 shadow-lg rounded-4">
                            <li><a class="dropdown-item py-2" href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"><i class="bi bi-file-earmark-excel me-2 text-success"></i> Excel</a></li>
                            <li><a class="dropdown-item py-2" href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i> PDF</a></li>
                        </ul>
                    </div>
                    <a href="{{ route('admin.riwayat.index') }}" class="btn btn-light rounded-pill px-4">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card bg-transparent border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kode Transaksi</th>
                            <th>Kasir</th>
                            <th>Total Bayar</th>
                            <th>Layanan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $index => $item)
                        <tr class="shadow-sm mb-2">
                            <td class="fw-medium text-muted">{{ $transaksi->firstItem() + $index }}</td>
                            <td class="fw-bold">{{ $item->tanggal_t->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge {{ $item->id_reservasi ? 'badge-info' : 'badge-purple-soft' }} px-3 py-2 rounded-pill fw-bold small">
                                    {{ $item->kode_t }}
                                </span>
                            </td>
                            <td>{{ $item->pengguna->nama_p }}</td>
                            <td class="text-purple-600 fw-bold">Rp {{ number_format($item->totalBayar_t, 0, ',', '.') }}</td>
                            <td>
                                @foreach($item->detailTransaksis as $detail)
                                    <span class="badge badge-purple-soft mb-1">{{ $detail->menu->nama_m }}</span>
                                @endforeach
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-light text-primary rounded-pill px-3" onclick="showDetail('{{ $item->encrypted_id }}')">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted bg-white rounded-4">Belum ada riwayat transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $transaksi->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-refined shadow-lg">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold text-purple-600">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="detailContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-purple-600" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
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
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                let itemsHtml = '';
                data.detail_transaksis.forEach(detail => {
                    itemsHtml += `
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-medium">${detail.menu.nama_m}</span>
                            <span class="fw-bold text-dark">Rp ${new Intl.NumberFormat('id-ID').format(detail.harga_saat_ini)}</span>
                        </div>
                    `;
                });

                content.innerHTML = `
                    <div class="mb-4">
                        <div class="small text-muted text-uppercase fw-bold mb-1" style="letter-spacing: 1px;">ID Transaksi</div>
                        <div class="h5 fw-bold text-purple-600">${data.id_reservasi ? data.reservasi.kode_reservasi : 'TRX-' + new Date(data.tanggal_t).toISOString().slice(0,10).replace(/-/g,'') + '-' + data.id_t.toString().padStart(4, '0')}</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="small text-muted text-uppercase fw-bold mb-1" style="letter-spacing: 1px;">Tanggal</div>
                            <div class="fw-bold text-dark">${new Date(data.tanggal_t).toLocaleString('id-ID')}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted text-uppercase fw-bold mb-1" style="letter-spacing: 1px;">Kasir</div>
                            <div class="fw-bold text-dark">${data.pengguna.nama_p}</div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="small text-muted text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">Layanan Dipesan</div>
                        <div class="p-4 bg-light rounded-4 border">
                            ${itemsHtml}
                            <hr class="opacity-50">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark">Total Bayar</span>
                                <span class="h5 fw-bold text-purple-600 mb-0">Rp ${new Intl.NumberFormat('id-ID').format(data.totalBayar_t)}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 rounded-4 bg-purple-ultra-light border border-purple-100">
                        <div class="row g-2">
                            <div class="col-6 text-muted small fw-bold text-uppercase">Uang Dibayar</div>
                            <div class="col-6 text-end fw-bold text-dark">Rp ${new Intl.NumberFormat('id-ID').format(data.bayar_t)}</div>
                            <div class="col-6 text-muted small fw-bold text-uppercase">Uang Kembali</div>
                            <div class="col-6 text-end fw-bold text-success">Rp ${new Intl.NumberFormat('id-ID').format(data.kembali_t)}</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="/admin/transaksi/${id}/cetak" target="_blank" class="btn btn-purple-refined w-100 rounded-pill py-3">
                            <i class="bi bi-printer me-2"></i> Cetak Ulang Struk
                        </a>
                    </div>
                `;
            })
            .catch(error => {
                content.innerHTML = '<div class="alert alert-danger">Gagal mengambil data detail.</div>';
            });
    }
</script>
@endsection
