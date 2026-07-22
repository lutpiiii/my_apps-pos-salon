@extends('layouts.dashboard.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold topbar-title">Laporan Pengeluaran</h3>
        <button class="btn btn-purple-refined" data-bs-toggle="modal" data-bs-target="#addPengeluaranModal">
            <i class="bi bi-plus-lg me-2"></i> Catat Pengeluaran
        </button>
    </div>

    <!-- Filter Card -->
    <div class="card card-refined border-0 shadow-sm p-4 mb-4">
        <form action="{{ route('admin.laporan.keluar') }}" method="GET" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Tipe Laporan</label>
                    <select name="filter_type" id="filterType" class="form-select rounded-pill border-2 fw-bold text-danger">
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
                        <button class="btn btn-outline-danger rounded-pill w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu border-0 shadow-lg rounded-4">
                            <li><a class="dropdown-item py-2" href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"><i class="bi bi-file-earmark-excel me-2 text-success"></i> Excel</a></li>
                            <li><a class="dropdown-item py-2" href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i> PDF</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('admin.laporan.keluar') }}" class="btn btn-light rounded-pill w-100">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Summary Card -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="stat-card-gradient p-4 animate__animated animate__pulse" style="background: linear-gradient(135deg, #ef4444, #f87171);">
                <div class="d-flex align-items-center gap-4">
                    <div class="icon-box-refined shadow-lg" style="background: rgba(255,255,255,0.25)">
                        <i class="bi bi-cart-dash-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-white opacity-75 small mb-1 text-uppercase fw-bold" style="letter-spacing: 2px;">Total Pengeluaran Terfilter</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h2>
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
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Keterangan</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $index => $item)
                        <tr class="shadow-sm mb-2">
                            <td class="fw-medium text-muted">{{ $transaksi->firstItem() + $index }}</td>
                            <td class="fw-bold">{{ $item->tanggal_k->format('d/m/Y') }}</td>
                            <td class="fw-bold text-dark">{{ $item->judul_k }}</td>
                            <td><span class="small text-muted">{{ $item->keterangan_k }}</span></td>
                            <td class="text-end text-danger fw-bold">Rp {{ number_format($item->harga_k, 0, ',', '.') }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.laporan.keluar.destroy', $item->id_tk) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger rounded-pill px-3" onclick="return confirm('Hapus catatan pengeluaran ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
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

<!-- Add Modal -->
<div class="modal fade" id="addPengeluaranModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-refined shadow-lg">
            <form action="{{ route('admin.laporan.keluar.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold text-purple-600">Catat Pengeluaran Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Tanggal</label>
                        <input type="date" name="tanggal_k" class="form-control rounded-4 border-2 p-3" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Judul Pengeluaran</label>
                        <input type="text" name="judul_k" class="form-control rounded-4 border-2 p-3" placeholder="Contoh: Belanja Bulanan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Keterangan</label>
                        <textarea name="keterangan_k" class="form-control rounded-4 border-2 p-3" rows="3" placeholder="Contoh: Shampo, Hair Tonic, Sabun" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Jumlah (Rp)</label>
                        <input type="number" name="harga_k" class="form-control rounded-4 border-2 p-3" placeholder="Contoh: 250000" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-purple-refined px-4">Simpan</button>
                </div>
            </form>
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
