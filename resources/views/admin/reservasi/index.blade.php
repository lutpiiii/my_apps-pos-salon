@extends(strtolower(Auth::user()->role_p) === 'admin' ? 'layouts.dashboard.admin' : 'layouts.dashboard.kasir')

@section('styles')
<style>
    .reservasi-card {
        background: white;
        border-radius: 25px;
        border: 1px solid rgba(88, 28, 135, 0.05);
        transition: all 0.3s ease;
    }
    .reservasi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(88, 28, 135, 0.1);
    }
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    .badge-service {
        background: var(--purple-ultra-light);
        color: var(--purple-main);
        font-weight: 700;
        font-size: 0.7rem;
        padding: 5px 12px;
        border-radius: 100px;
        border: 1px solid rgba(88, 28, 135, 0.1);
    }
    .action-btn-group {
        display: flex;
        gap: 5px;
        justify-content: flex-end;
    }
    .table-luxury thead th {
        background: none !important;
        color: #94a3b8;
        text-transform: uppercase;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 1px;
        padding: 15px 25px;
        border: none;
    }
    .table-luxury tbody td {
        padding: 20px 25px;
        vertical-align: middle;
        border-top: 1px solid #f8faff;
    }
    .modal-content-refined {
        border-radius: 30px;
        border: none;
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="fw-bold topbar-title mb-1">Manajemen Reservasi</h3>
            <p class="text-muted small mb-0">Pantau dan kelola jadwal booking pelanggan secara real-time.</p>
        </div>
        <div class="d-flex gap-3">
            <div class="stat-card-gradient p-3 px-4 shadow-sm" style="background: linear-gradient(135deg, #f59e0b, #fbbf24); min-width: 150px;">
                <div class="small opacity-75 fw-bold text-uppercase">Pending</div>
                <h4 class="fw-bold mb-0">{{ $totalPending }}</h4>
            </div>
            <div class="stat-card-gradient p-3 px-4 shadow-sm" style="background: linear-gradient(135deg, #581c87, #9333ea); min-width: 150px;">
                <div class="small opacity-75 fw-bold text-uppercase">Total</div>
                <h4 class="fw-bold mb-0">{{ $reservasiList->total() }}</h4>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="card card-refined border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <form action="{{ route('admin.reservasi.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Cari Pelanggan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="q" class="form-control bg-light border-0" placeholder="Kode / Nama / No HP..." value="{{ request('q') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                        <select name="status" class="form-select bg-light border-0" onchange="this.form.submit()">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control bg-light border-0" value="{{ request('tanggal') }}" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-purple-refined w-100"><i class="bi bi-filter"></i> Filter</button>
                        <a href="{{ route('admin.reservasi.index') }}" class="btn btn-light rounded-pill px-3" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card border-0 bg-transparent">
        <div class="table-responsive">
            <table class="table table-luxury align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Kode & Pelanggan</th>
                        <th>Jadwal Kunjungan</th>
                        <th>Layanan Perawatan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="pe-4 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservasiList as $index => $item)
                    <tr class="bg-white shadow-sm mb-3 rounded-4">
                        <td class="ps-4 text-muted small fw-bold">{{ $reservasiList->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-bold text-dark mb-0">{{ $item->kode_reservasi }}</div>
                            <div class="small text-muted">{{ $item->nama_pelanggan }}</div>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->notelp_pelanggan) }}" target="_blank" class="extra-small text-success text-decoration-none fw-bold">
                                <i class="bi bi-whatsapp"></i> {{ $item->notelp_pelanggan }}
                            </a>
                        </td>
                        <td>
                            <div class="fw-bold text-dark small">{{ date('d M Y', strtotime($item->tanggal_reservasi)) }}</div>
                            <div class="text-purple-600 small fw-bold"><i class="bi bi-clock me-1"></i>{{ date('H:i', strtotime($item->jam_reservasi)) }} WIB</div>
                        </td>
                        <td>
                            @php
                                $services = $item->details->count() > 0 ? $item->details : ($item->menu ? collect([$item->menu]) : collect());
                                $count = $item->details->count() > 0 ? $item->details->count() : ($item->menu ? 1 : 0);
                            @endphp

                            <div class="d-flex flex-wrap gap-1" style="max-width: 250px;">
                                @foreach($services->take(2) as $s)
                                    <span class="badge-service">{{ $s->menu ? $s->menu->nama_m : ($s->nama_m ?? '-') }}</span>
                                @endforeach
                                @if($count > 2)
                                    <span class="badge bg-light text-muted rounded-pill small px-2">+{{ $count - 2 }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-purple-700">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</div>
                        </td>
                        <td>
                            {!! $item->status_badge !!}
                        </td>
                        <td class="pe-4">
                            <div class="action-btn-group">
                                <button class="btn btn-sm btn-light text-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id_r }}">
                                    <i class="bi bi-eye"></i> Detail
                                </button>

                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-pill dropdown-toggle" data-bs-toggle="dropdown">Status</button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4">
                                        <li><form action="{{ route('admin.reservasi.updateStatus', $item->id_r) }}" method="POST">@csrf @method('PUT') <input type="hidden" name="status" value="Disetujui"> <button type="submit" class="dropdown-item py-2 text-info"><i class="bi bi-check-circle me-2"></i> Disetujui</button></form></li>
                                        <li><form action="{{ route('admin.reservasi.updateStatus', $item->id_r) }}" method="POST">@csrf @method('PUT') <input type="hidden" name="status" value="Selesai"> <button type="submit" class="dropdown-item py-2 text-success"><i class="bi bi-check2-all me-2"></i> Selesai</button></form></li>
                                        <li><form action="{{ route('admin.reservasi.updateStatus', $item->id_r) }}" method="POST">@csrf @method('PUT') <input type="hidden" name="status" value="Dibatalkan"> <button type="submit" class="dropdown-item py-2 text-warning"><i class="bi bi-x-circle me-2"></i> Dibatalkan</button></form></li>
                                    </ul>
                                </div>

                                @if($item->status != 'Selesai' && $item->status != 'Dibatalkan')
                                    <a href="{{ route('admin.reservasi.kasir', $item->id_r) }}" class="btn btn-sm btn-success rounded-pill px-3">
                                        <i class="bi bi-cart-plus"></i>
                                    </a>
                                @endif

                                <form action="{{ route('admin.reservasi.destroy', $item->id_r) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-light text-danger rounded-circle btn-delete" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="bg-white p-5 rounded-5 shadow-sm d-inline-block">
                                <i class="bi bi-calendar-x fs-1 text-purple-200 mb-3 d-block"></i>
                                <h5 class="text-muted">Tidak ada data reservasi.</h5>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $reservasiList->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modal Container (Move outside table for correct rendering) -->
@foreach($reservasiList as $item)
<div class="modal fade" id="modalDetail{{ $item->id_r }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-refined shadow-lg">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold text-purple-600">Rincian Booking {{ $item->kode_reservasi }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-4 h-100">
                            <div class="small text-muted text-uppercase fw-bold mb-2">Data Pelanggan</div>
                            <h5 class="fw-bold mb-1 text-dark">{{ $item->nama_pelanggan }}</h5>
                            <div class="text-success small fw-bold mb-2"><i class="bi bi-whatsapp me-1"></i>{{ $item->notelp_pelanggan }}</div>
                            @if($item->email_pelanggan)<div class="small text-muted"><i class="bi bi-envelope me-1"></i>{{ $item->email_pelanggan }}</div>@endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-4 h-100">
                            <div class="small text-muted text-uppercase fw-bold mb-2">Jadwal Kedatangan</div>
                            <h5 class="fw-bold mb-1 text-dark">{{ date('d F Y', strtotime($item->tanggal_reservasi)) }}</h5>
                            <div class="text-purple-600 fw-bold"><i class="bi bi-clock me-1"></i>{{ date('H:i', strtotime($item->jam_reservasi)) }} WIB</div>
                            <div class="mt-2">{!! $item->status_badge !!}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="small text-muted text-uppercase fw-bold mb-2">Rincian Layanan</div>
                    <div class="table-responsive rounded-4 border">
                        <table class="table table-borderless table-sm mb-0">
                            <thead class="bg-light">
                                <tr class="small text-muted fw-bold">
                                    <th class="ps-3">Layanan</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end pe-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($item->details->count() > 0)
                                    @foreach($item->details as $d)
                                    <tr>
                                        <td class="ps-3 fw-bold">{{ $d->menu->nama_m }}</td>
                                        <td class="text-center">{{ $d->jumlah }}x</td>
                                        <td class="text-end pe-3">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                @elseif($item->menu)
                                    <tr>
                                        <td class="ps-3 fw-bold">{{ $item->menu->nama_m }}</td>
                                        <td class="text-center">1x</td>
                                        <td class="text-end pe-3">Rp {{ number_format($item->menu->harga_m, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot class="border-top">
                                <tr class="fw-bold">
                                    <td colspan="2" class="ps-3 text-dark py-3">Total Estimasi</td>
                                    <td class="text-end pe-3 text-purple-700 py-3" style="font-size: 1.2rem;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                @if($item->catatan)
                <div class="mt-4 p-3 bg-light rounded-4 border-start border-4 border-purple-300">
                    <div class="small text-muted fw-bold text-uppercase mb-1">Catatan Khusus</div>
                    <p class="mb-0 italic small">"{{ $item->catatan }}"</p>
                </div>
                @endif
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                @if($item->status != 'Selesai' && $item->status != 'Dibatalkan')
                    <a href="{{ route('admin.reservasi.kasir', $item->id_r) }}" class="btn btn-purple-refined px-4">
                        <i class="bi bi-cart-plus me-2"></i> Proses ke Kasir
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
