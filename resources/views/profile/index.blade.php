@extends(Auth::user()->role_p === 'admin' ? 'layouts.dashboard.admin' : 'layouts.dashboard.kasir')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold topbar-title">Profil Saya</h3>
        <p class="text-muted">Kelola informasi akun dan foto profil Anda.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="card card-refined border-0 shadow-sm p-4 text-center">
                <div class="mb-4 position-relative d-inline-block mx-auto">
                    <div class="rounded-circle overflow-hidden shadow-sm border border-4 border-white" style="width: 150px; height: 150px;">
                        @if($user->foto_p)
                            <img src="{{ asset('assets/uploads/'.$user->foto_p) }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="w-100 h-100 bg-purple-ultra-light d-flex align-items-center justify-content-center">
                                <i class="bi bi-person text-purple-600" style="font-size: 5rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-purple-600 text-white rounded-circle d-flex align-items-center justify-content-center border border-2 border-white" style="width: 35px; height: 35px;">
                        <i class="bi bi-camera-fill small"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-1">{{ $user->nama_p }}</h5>
                <span class="badge {{ $user->role_p === 'admin' ? 'bg-danger' : 'bg-success' }} bg-opacity-10 {{ $user->role_p === 'admin' ? 'text-danger' : 'text-success' }} px-3 py-2 rounded-pill fw-bold small text-uppercase">
                    {{ $user->role_p }}
                </span>
                <hr class="my-4 opacity-50">
                <div class="text-start">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="bi bi-person-circle text-purple-600"></i>
                        <span class="small text-muted">{{ $user->username_p }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-refined border-0 shadow-sm p-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small uppercase">Nama Lengkap</label>
                            <input type="text" name="nama_p" class="form-control rounded-4 border-2 p-3" value="{{ $user->nama_p }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small uppercase">Username</label>
                            <input type="text" name="username_p" class="form-control rounded-4 border-2 p-3" value="{{ $user->username_p }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small uppercase">Password Baru (Biarkan kosong jika tidak diubah)</label>
                            <input type="password" name="password_p" class="form-control rounded-4 border-2 p-3" placeholder="••••••••">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small uppercase">Foto Profil Baru</label>
                            <input type="file" name="foto_p" class="form-control rounded-4 border-2 p-2">
                            <small class="text-muted">Format: JPG, PNG. Maks 2MB.</small>
                        </div>
                        <div class="col-md-12 text-end mt-5">
                            <button type="submit" class="btn btn-purple-refined px-5">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
