@extends('layouts.dashboard.admin')

@section('styles')
<style>
    .gallery-card {
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }
    .gallery-img-container {
        height: 250px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }
    .gallery-img-container img {
        transition: transform 0.5s ease;
    }
    .gallery-img-container:hover img {
        transform: scale(1.1);
    }
    .gallery-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(88, 28, 135, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .gallery-img-container:hover .gallery-overlay {
        opacity: 1;
    }
    .preview-modal-img {
        max-height: 80vh;
        object-fit: contain;
        border-radius: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold topbar-title">Informasi & Galeri</h3>
        <button class="btn btn-purple-refined" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
            <i class="bi bi-plus-lg me-2"></i> Tambah Galeri
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($gallery as $item)
        <div class="col-md-6 col-xl-4">
            <div class="card card-refined gallery-card h-100">
                <div class="gallery-img-container" onclick="previewImage('{{ asset('assets/uploads/'.$item->foto_inf) }}', '{{ $item->judul_inf }}')">
                    <img src="{{ asset('assets/uploads/'.$item->foto_inf) }}" class="w-100 h-100" style="object-fit: cover;">
                    <div class="gallery-overlay">
                        <i class="bi bi-zoom-in text-white fs-1"></i>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2">{{ $item->judul_inf }}</h5>
                    <p class="text-muted small mb-4">{{ Str::limit($item->keterangan_inf, 100) }}</p>
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-sm btn-light text-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editGalleryModal{{ $item->id_inf }}">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>
                        <form action="{{ route('admin.salon.gallery.destroy', $item->id_inf) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light text-danger rounded-pill px-3" onclick="return confirm('Hapus item galeri ini?')">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editGalleryModal{{ $item->id_inf }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-content-refined shadow-lg">
                    <form action="{{ route('admin.salon.gallery.update', $item->id_inf) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header border-0 p-4 pb-0">
                            <h5 class="fw-bold text-purple-600">Edit Galeri</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-3 text-center">
                                <img src="{{ asset('assets/uploads/'.$item->foto_inf) }}" class="rounded-4 mb-3 shadow-sm" style="max-height: 150px; max-width: 100%; object-fit: cover;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small uppercase">Judul</label>
                                <input type="text" name="judul_inf" class="form-control rounded-4 border-2 p-3" value="{{ $item->judul_inf }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small uppercase">Foto Baru (Opsional)</label>
                                <input type="file" name="foto_inf" class="form-control rounded-4 border-2 p-2">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small uppercase">Keterangan</label>
                                <textarea name="keterangan_inf" class="form-control rounded-4 border-2 p-3" rows="3" required>{{ $item->keterangan_inf }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-purple-refined px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="text-muted">Belum ada item galeri.</div>
        </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $gallery->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-refined shadow-lg">
            <form action="{{ route('admin.salon.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold text-purple-600">Tambah Galeri Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Judul</label>
                        <input type="text" name="judul_inf" class="form-control rounded-4 border-2 p-3" placeholder="Contoh: Tren Rambut 2024" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Foto</label>
                        <input type="file" name="foto_inf" class="form-control rounded-4 border-2 p-2" required>
                        <small class="text-muted">Format: JPG, PNG, JPEG. Maks 2MB.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Keterangan</label>
                        <textarea name="keterangan_inf" class="form-control rounded-4 border-2 p-3" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-purple-refined px-4">Upload Galeri</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <img id="previewModalImage" src="" class="img-fluid preview-modal-img shadow-lg">
                <h4 id="previewModalTitle" class="text-white fw-bold mt-3"></h4>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(src, title) {
        document.getElementById('previewModalImage').src = src;
        document.getElementById('previewModalTitle').innerText = title;
        new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
    }
</script>
@endsection
