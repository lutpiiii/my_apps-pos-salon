@extends('layouts.dashboard.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold topbar-title">Profil Salon</h3>
        <p class="text-muted">Kelola informasi publik salon Anda yang akan tampil di landing page.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card card-refined border-0 shadow-sm p-4">
                <form action="{{ route('admin.salon.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small uppercase">Nama Salon</label>
                            <input type="text" name="nama_prf" class="form-control rounded-4 border-2 p-3" value="{{ $profile->nama_prf ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small uppercase">Email Salon</label>
                            <input type="email" name="email_prf" class="form-control rounded-4 border-2 p-3" value="{{ $profile->email_prf ?? '' }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small uppercase">Nomor Telepon</label>
                            <input type="text" name="notelp_prf" class="form-control rounded-4 border-2 p-3" value="{{ $profile->notelp_prf ?? '' }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small uppercase">Keterangan / Slogan</label>
                            <textarea name="keterangan_prf" class="form-control rounded-4 border-2 p-3" rows="4" required>{{ $profile->keterangan_prf ?? '' }}</textarea>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-purple-refined px-5">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-refined border-0 shadow-sm p-4 text-center">
                <div class="mb-4">
                    <div class="icon-box bg-purple-ultra-light text-purple-600 mx-auto" style="width: 100px; height: 100px; font-size: 3rem;">
                        <i class="bi bi-shop"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">{{ $profile->nama_prf ?? 'Nama Salon' }}</h5>
                <p class="text-muted small mb-0">{{ $profile->email_prf ?? 'salon@example.com' }}</p>
                <hr class="my-4 opacity-50">
                <div class="text-start">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="bi bi-telephone text-purple-600"></i>
                        <span class="small">{{ $profile->notelp_prf ?? '-' }}</span>
                    </div>
                    <div class="d-flex gap-3">
                        <i class="bi bi-quote text-purple-600"></i>
                        <span class="small italic text-muted">"{{ $profile->keterangan_prf ?? 'Slogan salon' }}"</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
