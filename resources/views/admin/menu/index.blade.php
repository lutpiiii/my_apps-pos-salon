@extends('layouts.dashboard.admin')

@section('styles')
<style>
    .menu-item-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 30px;
        background: white;
        border: 1px solid rgba(88, 28, 135, 0.05);
        overflow: hidden;
    }
    .menu-item-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(88, 28, 135, 0.1);
        border-color: var(--purple-soft);
    }
    .price-tag {
        background: var(--purple-ultra-light);
        color: var(--purple-main);
        padding: 8px 20px;
        border-radius: 100px;
        font-weight: 800;
        font-size: 1.1rem;
    }
    .menu-item-card:hover .price-tag {
        background: var(--purple-main);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row align-items-center mb-5">
        <div class="col-md-3">
            <h3 class="fw-bold topbar-title mb-0">Manajemen Menu</h3>
            <p class="text-muted small mb-0">Kelola daftar layanan salon Anda.</p>
        </div>
        <div class="col-md-6">
            <form action="{{ route('admin.menu.index') }}" method="GET" id="searchForm">
                <div class="row g-2">
                    <div class="col-md-7">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-3"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 rounded-end-pill py-2" placeholder="Cari layanan..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <select name="id_kategori" class="form-select rounded-pill py-2" onchange="document.getElementById('searchForm').submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id_k }}" {{ request('id_kategori') == $cat->id_k ? 'selected' : '' }}>{{ $cat->nama_k }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3 text-md-end mt-3 mt-md-0">
            <button class="btn btn-purple-refined w-100" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                <i class="bi bi-plus-lg me-2"></i> Tambah Menu
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-5" role="alert" style="background: #ecfdf5; color: #065f46;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($menus as $item)
        <div class="col-md-6 col-lg-4 col-xl-3 animate__animated animate__fadeInUp">
            <div class="card menu-item-card h-100 shadow-sm p-4">
                <div class="d-flex justify-content-between mb-3">
                    <span class="badge rounded-pill px-3 py-2 fw-bold" style="font-size: 0.75rem; background-color: var(--purple-ultra-light); color: var(--purple-main); border: 1px solid rgba(88, 28, 135, 0.1);">
                        {{ $item->kategori->nama_k }}
                    </span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4">
                            <li><a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#editMenuModal{{ $item->id_m }}"><i class="bi bi-pencil-square me-2 text-primary"></i> Edit</a></li>
                            <li><hr class="dropdown-divider opacity-50"></li>
                            <li>
                                <form action="{{ route('admin.menu.destroy', $item->id_m) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="dropdown-item py-2 text-danger btn-delete">
                                        <i class="bi bi-trash me-2"></i> Hapus
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <h5 class="fw-bold mb-4 text-dark">{{ $item->nama_m }}</h5>
                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                    <div class="price-tag">
                        Rp {{ number_format($item->harga_m, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editMenuModal{{ $item->id_m }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-content-refined shadow-lg">
                    <form action="{{ route('admin.menu.update', $item->id_m) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header border-0 p-4 pb-0">
                            <h5 class="fw-bold text-purple-600">Edit Menu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small uppercase">Kategori</label>
                                <select name="id_kategori" class="form-select rounded-4 border-2 p-3" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id_k }}" {{ $cat->id_k == $item->id_kategori ? 'selected' : '' }}>{{ $cat->nama_k }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small uppercase">Nama Menu</label>
                                <input type="text" name="nama_m" class="form-control rounded-4 border-2 p-3" value="{{ $item->nama_m }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small uppercase">Harga (Rp)</label>
                                <input type="number" name="harga_m" class="form-control rounded-4 border-2 p-3" value="{{ (int)$item->harga_m }}" required>
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
        @empty
        <div class="col-12 text-center py-5">
            <div class="bg-white p-5 rounded-5 shadow-sm d-inline-block">
                <i class="bi bi-card-list fs-1 text-purple-200 mb-3 d-block"></i>
                <h5 class="text-muted">Belum ada menu ditemukan.</h5>
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $menus->appends(['search' => request('search'), 'id_kategori' => request('id_kategori')])->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-refined shadow-lg">
            <form action="{{ route('admin.menu.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold text-purple-600">Tambah Menu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Kategori</label>
                        <select name="id_kategori" class="form-select rounded-4 border-2 p-3" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id_k }}">{{ $cat->nama_k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Nama Menu</label>
                        <input type="text" name="nama_m" class="form-control rounded-4 border-2 p-3" placeholder="Contoh: Smoothing" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Harga (Rp)</label>
                        <input type="number" name="harga_m" class="form-control rounded-4 border-2 p-3" placeholder="Contoh: 150000" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-purple-refined px-4">Tambah Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
