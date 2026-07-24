<header class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('landing') }}">
                <img src="{{ asset('assets/PS.png') }}" alt="SalonQ Logo">
                <div class="ms-3 d-flex flex-column text-white" style="line-height: 1.1;">
                    <span class="fw-bold" style="font-size: 1.3rem; letter-spacing: 1px;">NH BEAUTY</span>
                    <div class="d-flex align-items-center justify-content-center" style="font-size: 0.65rem; letter-spacing: 4px; opacity: 0.9;">
                        <span class="flex-grow-1 border-top border-white opacity-50 me-2" style="height: 1px;"></span>
                        <span class="fw-medium text-uppercase">Salon</span>
                        <span class="flex-grow-1 border-top border-white opacity-50 ms-2" style="height: 1px;"></span>
                    </div>
                </div>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item"><a class="nav-link text-white px-3" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white px-3" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link text-white px-3" href="#services">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link text-white px-3" href="#info">Gallery</a></li>
                    <li class="nav-item ms-lg-2">
                        <button type="button" class="btn btn-warning px-4 rounded-pill fw-bold text-dark shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalBooking">
                            <i class="bi bi-calendar-check-fill text-purple-700"></i>
                            <span>Reservasi Online</span>
                        </button>
                    </li>
                    <li class="nav-item ms-lg-2 mt-3 mt-lg-0">
                        @auth
                            <div class="dropdown">
                                <button class="btn btn-purple px-4 rounded-pill fw-bold text-white shadow-sm dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                    <div class="rounded-circle overflow-hidden bg-white/20 d-flex align-items-center justify-content-center" style="width: 25px; height: 25px;">
                                        @if(Auth::user()->foto_p)
                                            <img src="{{ asset('assets/uploads/'.Auth::user()->foto_p) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-person-fill text-white fs-6"></i>
                                        @endif
                                    </div>
                                    <span>Panel {{ ucfirst(Auth::user()->role_p) }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-2">
                                    <li><a class="dropdown-item py-2" href="{{ Auth::user()->role_p === 'admin' ? route('admin.dashboard') : route('kasir.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('profile.index') }}"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
                                    <li><hr class="dropdown-divider opacity-50"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a class="btn btn-purple px-4 rounded-pill fw-bold text-white shadow-sm" href="{{ route('login') }}">
                                <i class="bi bi-person-fill me-1"></i> Login
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
