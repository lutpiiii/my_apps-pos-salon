<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Dashboard - NH Beauty Salon</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/US.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard-refined.css') }}?v={{ time() }}">

    @yield('styles')
</head>
<body>

<aside id="sidebar">
    <button id="close-sidebar" class="d-lg-none">
        <i class="bi bi-x-lg"></i>
    </button>
    <div class="sidebar-header text-center py-4">
        <a href="{{ route('kasir.dashboard') }}" class="text-decoration-none">
            <img src="{{ asset('assets/PS.png') }}" alt="Logo" style="height: 50px;" class="mb-2">
            <div class="d-flex flex-column" style="line-height: 1.1;">
                <span class="fw-bold text-dark" style="font-size: 1.1rem; letter-spacing: 1px;">NH BEAUTY</span>
                <span class="fw-medium text-uppercase" style="font-size: 0.55rem; letter-spacing: 3px; color: #7e22ce;">Kasir Panel</span>
            </div>
        </a>
    </div>

    <div class="sidebar-content">
        <a href="{{ route('kasir.dashboard') }}" class="nav-link-kasir {{ Request::is('kasir/dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <div class="px-4 py-2 mt-3 mb-1 small text-uppercase text-muted fw-bold" style="letter-spacing: 1px; font-size: 0.7rem;">Transaksi</div>

        <a href="{{ route('admin.kasir.index') }}" class="nav-link-kasir {{ Request::is('admin/kasir*') ? 'active' : '' }}">
            <i class="bi bi-cart-plus-fill"></i>
            <span>Transaksi Baru</span>
        </a>

        <a href="{{ route('admin.riwayat.index') }}" class="nav-link-kasir {{ Request::is('admin/riwayat*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i>
            <span>Riwayat Transaksi</span>
        </a>

        <div class="px-4 py-2 mt-3 mb-1 small text-uppercase text-muted fw-bold" style="letter-spacing: 1px; font-size: 0.7rem;">Laporan</div>

        <a href="{{ route('admin.laporan.masuk') }}" class="nav-link-kasir {{ Request::is('admin/laporan/masuk*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Laporan Harian</span>
        </a>
    </div>

    <div class="p-3 mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100 rounded-4 py-2 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<header id="topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn d-lg-none p-0 text-purple-600 fs-3" id="sidebar-toggle">
            <i class="bi bi-list"></i>
        </button>
        <h5 class="mb-0 fw-bold topbar-title">Kasir Dashboard</h5>
    </div>

    <div class="text-center d-none d-lg-block">
        <div class="h4 fw-bold mb-0 text-purple-600" id="clock" style="letter-spacing: 2px;">--:--:--</div>
        <div class="small fw-bold text-muted text-uppercase opacity-75" style="letter-spacing: 1px;">{{ date('l, d F Y') }}</div>
    </div>

    <div class="dropdown">
        <div class="d-flex align-items-center gap-3 cursor-pointer" data-bs-toggle="dropdown">
            <div class="text-end d-none d-sm-block">
                <div class="fw-bold small">{{ Auth::user()->nama_p }}</div>
                <div class="opacity-75 text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">{{ Auth::user()->role_p }}</div>
            </div>
            <div class="rounded-circle overflow-hidden bg-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; border: 2px solid rgba(255,255,255,0.2);">
                @if(Auth::user()->foto_p)
                    <img src="{{ asset('assets/uploads/'.Auth::user()->foto_p) }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <i class="bi bi-person-fill text-purple-600 fs-4"></i>
                @endif
            </div>
        </div>
        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-3">
            <li><a class="dropdown-item py-2" href="{{ route('profile.index') }}"><i class="bi bi-person me-2"></i> Profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i> Keluar</button>
                </form>
            </li>
        </ul>
    </div>
</header>

<main id="main-content">
    @yield('content')
</main>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Global SweetAlert Handler
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: true,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#7e22ce',
            showCloseButton: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
            showConfirmButton: true,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#7e22ce',
            showCloseButton: true
        });
    @endif
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { hour12: false });
        document.getElementById('clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const closeBtn = document.getElementById('close-sidebar');

    function toggleSidebar() {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    toggleBtn?.addEventListener('click', toggleSidebar);
    closeBtn?.addEventListener('click', toggleSidebar);
    overlay?.addEventListener('click', toggleSidebar);

    // Global Delete Confirmation
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7e22ce',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@yield('scripts')
</body>
</html>
