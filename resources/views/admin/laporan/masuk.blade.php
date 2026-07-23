@extends(Auth::user()->role_p === 'admin' ? 'layouts.dashboard.admin' : 'layouts.dashboard.kasir')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold topbar-title">Laporan Pendapatan</h3>
    </div>

    <!-- Filter Card -->
    <div class="card card-refined border-0 shadow-sm p-4 mb-4">
        <form action="{{ route('admin.laporan.masuk') }}" method="GET" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Tipe Laporan</label>
                    <select name="filter_type" id="filterType" class="form-select rounded-pill border-2 fw-bold text-purple-600">
                        <option value="harian" {{ $filterType === 'harian' ? 'selected' : '' }}>Harian</option>
                        <option value="range" {{ $filterType === 'range' ? 'selected' : '' }}>Range Tanggal</option>
                        <option value="tahunan" {{ $filterType === 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                    </select>
                </div>

                <!-- Daily Filter -->
                <div class="col-md-5 filter-input" id="harianInput" style="display: {{ $filterType === 'harian' ? 'block' : 'none' }}">
                    <label class="form-label fw-bold small text-muted text-uppercase">Pilih Tanggal</label>
                    <input type="date" name="tanggal" class="form-control rounded-pill border-2" value="{{ request('tanggal', date('Y-m-d')) }}">
                </div>

                <!-- Range Filter -->
                <div class="col-md-6 filter-input" id="rangeInput" style="display: {{ $filterType === 'range' ? 'block' : 'none' }}">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Dari</label>
                            <input type="date" name="start_date" class="form-control rounded-pill border-2" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Sampai</label>
                            <input type="date" name="end_date" class="form-control rounded-pill border-2" value="{{ request('end_date') }}">
                        </div>
                    </div>
                </div>

                <!-- Yearly Filter -->
                <div class="col-md-5 filter-input" id="tahunanInput" style="display: {{ $filterType === 'tahunan' ? 'block' : 'none' }}">
                    <label class="form-label fw-bold small text-muted text-uppercase">Pilih Tahun</label>
                    <select name="tahun" class="form-select rounded-pill border-2">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-purple-refined">
                            <i class="bi bi-search me-2"></i> Cari
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-purple rounded-pill w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu border-0 shadow-lg rounded-4">
                            <li><a class="dropdown-item py-2" href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"><i class="bi bi-file-earmark-excel me-2 text-success"></i> Excel</a></li>
                            <li><a class="dropdown-item py-2" href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i> PDF</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('admin.laporan.masuk') }}" class="btn btn-light rounded-pill w-100">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Summary Card -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="stat-card-gradient p-4 animate__animated animate__pulse" style="background: linear-gradient(135deg, var(--purple-main), var(--purple-medium));">
                <div class="d-flex align-items-center gap-4">
                    <div class="icon-box-refined shadow-lg">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div>
                        <h6 class="text-white opacity-75 small mb-1 text-uppercase fw-bold" style="letter-spacing: 2px;">Total Pendapatan Terfilter</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card bg-transparent border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal & Waktu</th>
                            <th>ID Transaksi</th>
                            <th>Layanan</th>
                            <th>Kasir</th>
                            <th class="text-end">Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $index => $item)
                        <tr class="shadow-sm mb-2">
                            <td class="fw-medium text-muted">{{ $transaksi->firstItem() + $index }}</td>
                            <td class="fw-bold">{{ $item->tanggal_t->format('d/m/Y H:i') }}</td>
                            <td><span class="text-muted">#</span>TRX-{{ $item->id_t }}</td>
                            <td>
                                @foreach($item->detailTransaksis as $detail)
                                    <span class="badge badge-purple-soft mb-1">{{ $detail->menu->nama_m }}</span>
                                @endforeach
                            </td>
                            <td><span class="fw-bold text-dark">{{ $item->pengguna->nama_p }}</span></td>
                            <td class="text-end text-purple-600 fw-bold">Rp {{ number_format($item->totalBayar_t, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted bg-white rounded-4 shadow-sm">
                                <i class="bi bi-clipboard-x fs-1 mb-3 d-block opacity-25"></i>
                                Tidak ada data untuk kriteria ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $transaksi->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('filterType').addEventListener('change', function() {
        const type = this.value;
        document.querySelectorAll('.filter-input').forEach(el => el.style.display = 'none');

        if (type === 'harian') {
            document.getElementById('harianInput').style.display = 'block';
        } else if (type === 'range') {
            document.getElementById('rangeInput').style.display = 'block';
        } else if (type === 'tahunan') {
            document.getElementById('tahunanInput').style.display = 'block';
        }
    });
</script>
@endsection
