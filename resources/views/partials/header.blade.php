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
                    <li class="nav-item"><a class="nav-link text-white px-3" href="#location">Lokasi</a></li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        @auth
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-purple px-4 rounded-pill fw-bold text-white shadow-sm">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </button>
                            </form>
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
