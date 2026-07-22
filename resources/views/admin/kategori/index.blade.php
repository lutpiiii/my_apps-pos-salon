@extends('layouts.dashboard.admin')

@section('styles')
<style>
    .kategori-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(88, 28, 135, 0.05);
        border-radius: 25px;
        background: white;
    }
    .kategori-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(88, 28, 135, 0.1);
        border-color: var(--purple-soft);
    }
    .kategori-icon {
        width: 50px;
        height: 50px;
        background: var(--purple-ultra-light);
        color: var(--purple-main);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .kategori-card:hover .kategori-icon {
        background: var(--purple-main);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row align-items-center mb-5">
        <div class="col-md-4">
            <h3 class="fw-bold topbar-title mb-0">Manajemen Kategori</h3>
            <p class="text-muted small mb-0">Kelola kelompok layanan salon Anda.</p>
        </div>
        <div class="col-md-5">
            <form action="{{ route('admin.kategori.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-3"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 rounded-end-pill py-2" placeholder="Cari kategori..." value="{{ request('search') }}">
                </div>
            </form>
        </div>
        <div class="col-md-3 text-md-end mt-3 mt-md-0">
            <button class="btn btn-purple-refined w-100" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
                <i class="bi bi-plus-lg me-2"></i> Tambah Kategori
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
        @forelse($kategori as $item)
        <div class="col-md-6 col-lg-4 col-xl-3 animate__animated animate__fadeIn">
            <div class="card kategori-card h-100 shadow-sm border-0 p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="kategori-icon shadow-sm">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4">
                            <li><a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#editKategoriModal{{ $item->id_k }}"><i class="bi bi-pencil-square me-2 text-primary"></i> Edit</a></li>
                            <li><hr class="dropdown-divider opacity-50"></li>
                            <li>
                                <form action="{{ route('admin.kategori.destroy', $item->id_k) }}" method="POST" class="delete-form">
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
                <h5 class="fw-bold mb-1 text-dark">{{ $item->nama_k }}</h5>
                <p class="text-muted small mb-0">{{ $item->menulayanans_count ?? $item->menulayanans->count() }} Layanan tersedia</p>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editKategoriModal{{ $item->id_k }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-content-refined shadow-lg">
                    <form action="{{ route('admin.kategori.update', $item->id_k) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header border-0 p-4 pb-0">
                            <h5 class="fw-bold text-purple-600">Edit Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small uppercase">Nama Kategori</label>
                                <input type="text" name="nama_k" class="form-control rounded-4 border-2 p-3" value="{{ $item->nama_k }}" required>
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
                <i class="bi bi-folder-x fs-1 text-purple-200 mb-3 d-block"></i>
                <h5 class="text-muted">Belum ada kategori ditemukan.</h5>
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $kategori->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addKategoriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-refined shadow-lg">
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold text-purple-600">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Nama Kategori</label>
                        <input type="text" name="nama_k" class="form-control rounded-4 border-2 p-3" placeholder="Contoh: Potong Rambut" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-purple-refined px-4">Tambah Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
