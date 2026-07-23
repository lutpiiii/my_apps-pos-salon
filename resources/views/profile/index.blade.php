@extends(Auth::user()->role_p === 'admin' ? 'layouts.dashboard.admin' : 'layouts.dashboard.kasir')

@section('content')
<div class="container-fluid">
    <div class="mb-5 animate__animated animate__fadeIn">
        <h3 class="fw-bold topbar-title">Profil Saya</h3>
        <p class="text-muted">Kelola informasi akun dan foto profil Anda agar tetap diperbarui.</p>
    </div>

    <div class="row g-4">
        <!-- Current Profile Card -->
        <div class="col-lg-4 animate__animated animate__fadeInLeft">
            <div class="card card-refined border-0 shadow-sm p-4 text-center h-100">
                <div class="mb-4 position-relative d-inline-block mx-auto">
                    <div class="rounded-circle overflow-hidden shadow-sm border border-4 border-white" style="width: 160px; height: 150px; background: var(--purple-ultra-light);">
                        @if($user->foto_p)
                            <img src="{{ asset('assets/uploads/'.$user->foto_p) }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-person text-purple-600" style="font-size: 5rem;"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <h4 class="fw-bold mb-1 text-dark">{{ $user->nama_p }}</h4>
                <div class="d-flex justify-content-center mb-4">
                    @if($user->role_p === 'admin')
                        <span class="badge bg-danger bg-opacity-10 text-danger px-4 py-2 rounded-pill fw-bold small text-uppercase" style="letter-spacing: 1px;">
                            <i class="bi bi-shield-lock-fill me-1"></i> Administrator
                        </span>
                    @else
                        <span class="badge bg-success bg-opacity-10 text-success px-4 py-2 rounded-pill fw-bold small text-uppercase" style="letter-spacing: 1px;">
                            <i class="bi bi-person-badge-fill me-1"></i> Kasir
                        </span>
                    @endif
                </div>

                <hr class="my-4 opacity-50">

                <div class="bg-light p-3 rounded-4 text-start">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box bg-white text-purple-600 shadow-sm" style="width: 35px; height: 35px; font-size: 1rem;">
                            <i class="bi bi-at"></i>
                        </div>
                        <div>
                            <div class="extra-small text-muted text-uppercase fw-bold" style="font-size: 0.6rem; letter-spacing: 1px;">Username</div>
                            <div class="fw-bold text-dark small">{{ $user->username_p }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="col-lg-8 animate__animated animate__fadeInRight">
            <div class="card card-refined border-0 shadow-sm p-4 h-100">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
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
                            <label class="form-label fw-bold text-muted small uppercase">Password Baru</label>
                            <div class="input-group">
                                <input type="password" name="password_p" class="form-control rounded-start-4 border-2 p-3 border-end-0 password-input" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                                <span class="input-group-text bg-white border-2 border-start-0 rounded-end-4 px-3 cursor-pointer toggle-password">
                                    <i class="bi bi-eye-slash text-muted"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small uppercase">Foto Profil Baru</label>
                            <div class="upload-container border-2 border-dashed rounded-5 p-5 text-center bg-light position-relative" style="border-style: dashed !important; border-color: #e2e8f0 !important; transition: all 0.3s ease;">
                                <input type="file" name="foto_p" class="form-control opacity-0 position-absolute top-0 start-0 w-100 h-100 cursor-pointer" onchange="previewProfileUpload(this)">

                                <div id="profilePreview" class="d-none mb-3">
                                    <img src="" class="rounded-circle shadow-lg border border-4 border-white" style="width: 120px; height: 120px; object-fit: cover;">
                                    <p class="text-purple-600 fw-bold mt-2 small">Pratinjau Foto Baru</p>
                                </div>

                                <div id="uploadPlaceholder">
                                    <i class="bi bi-cloud-arrow-up text-purple-600" style="font-size: 3.5rem;"></i>
                                    <h6 class="fw-bold text-dark mt-2">Pilih atau Seret Foto</h6>
                                    <p class="text-muted small mb-0">Rekomendasi ukuran: 500x500px (Maks 2MB)</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-end mt-4">
                            <button type="submit" class="btn btn-purple-refined px-5 py-3 rounded-4 shadow-sm" id="btnSaveProfile">
                                <span class="spinner-border spinner-border-sm d-none me-2"></span>
                                <i class="bi bi-check2-circle me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Password Toggle Logic
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.password-input');
            const icon = this.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                input.type = "password";
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        });
    });

    function previewProfileUpload(input) {
        const preview = document.getElementById('profilePreview');
        const placeholder = document.getElementById('uploadPlaceholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.querySelector('img').src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Handle Form Submit Loading
    document.getElementById('profileForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSaveProfile');
        btn.disabled = true;
        btn.querySelector('.spinner-border').classList.remove('d-none');
    });
</script>
@endsection
