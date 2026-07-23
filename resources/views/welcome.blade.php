@extends('layouts.app')

@section('content')
<!-- 1. HERO SECTION -->
<section id="home" class="hero-section text-white">
    <div class="container hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="hero-badge animate__animated animate__fadeInDown">Information and Contact</span>
                <h1 class="display-2 fw-bold serif mb-4 leading-tight animate__animated animate__fadeInLeft">
                    Redefine Your <br><span class="cursive gradient-text display-1">True Style</span>
                </h1>

                <div class="row g-4 mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                    <div class="col-md-7">
                        <div class="d-flex gap-3 mb-4">
                            <div class="service-icon mb-0" style="width: 48px; height: 48px; min-width: 48px;">
                                <i class="bi bi-geo-alt-fill fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Alamat</h6>
                                <p class="text-white opacity-75 small mb-0">Jl. Raya Indah No. 123, Surabaya</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-4">
                            <div class="service-icon mb-0" style="width: 48px; height: 48px; min-width: 48px;">
                                <i class="bi bi-telephone-fill fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Telepon</h6>
                                <p class="text-white opacity-75 small mb-0">{{ $profile->notelp_prf ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex gap-3 mb-4">
                            <div class="service-icon mb-0" style="width: 48px; height: 48px; min-width: 48px;">
                                <i class="bi bi-clock fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Senin - Jumat</h6>
                                <p class="text-white opacity-75 small mb-0">09:00 - 20:00</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-4">
                            <div class="service-icon mb-0" style="width: 48px; height: 48px; min-width: 48px;">
                                <i class="bi bi-calendar-x fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Minggu</h6>
                                <p class="text-white fw-bold small mb-0 text-danger">LIBUR</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#services" class="btn btn-purple">Layanan Kami</a>
                    <a href="#about" class="btn btn-outline-light px-5 py-3 rounded-pill fw-bold">Tentang Kami</a>
                </div>
            </div>
            <div class="col-lg-6 text-center" data-aos="zoom-in" data-aos-delay="200">
                <div class="float-anim">
                    <img src="{{ asset('assets/LOGOBARU.png') }}" class="img-fluid" style="max-height: 520px; filter: drop-shadow(0 20px 50px rgba(0,0,0,0.5));">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. ABOUT SECTION -->
<section id="about" class="py-5 bg-white">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-7" data-aos="fade-up">
                <span class="text-purple-600 fw-bold text-uppercase small ls-2 d-block mb-2">Our Story</span>
                <h2 class="display-4 fw-bold mb-4 serif text-dark">
                    {{ $profile->nama_prf ?? 'NH Beauty Salon' }} <br>
                    <span style="color: #581c87;">Surabaya</span>
                </h2>
                <div style="width: 80px; height: 5px; background: linear-gradient(to right, #581c87, #9333ea);" class="mb-4 rounded-pill"></div>
                <p class="text-muted fs-5 leading-relaxed italic" style="text-align: justify; line-height: 1.8;">
                    "{{ $profile->keterangan_prf ?? 'Menghadirkan layanan kecantikan terbaik dengan sentuhan profesional untuk menunjang gaya hidup Anda.' }}"
                </p>
            </div>
            <div class="col-lg-5" data-aos="fade-left">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="p-4 card-luxury bg-light h-100 shadow-sm d-flex align-items-center gap-4">
                            <div class="service-icon mb-0">
                                <img src="{{ asset('assets/icon/salon.png') }}" style="width: 32px; height: 32px; object-fit: contain;">
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">Premium Quality</h5>
                                <p class="text-muted small mb-0">Produk pilihan untuk hasil mempesona.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-4 card-luxury text-light h-100 shadow-sm d-flex align-items-center gap-4" style="background: var(--purple-dark);">
                            <div class="service-icon mb-0 bg-white/10 text-white">
                                <img src="{{ asset('assets/icon/woman-hair.png') }}" style="width: 32px; height: 32px; object-fit: contain; filter: invert(1);">
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Expert Stylist</h5>
                                <p class="text-white/70 small mb-0">Tenaga profesional berpengalaman.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. SERVICES SECTION -->
<section id="services" class="py-5" style="background-color: #0f172a;">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="text-purple-400 fw-bold text-uppercase small ls-2 d-block mb-2">Exclusive Menu</span>
            <h2 class="display-5 fw-bold serif text-white">Layanan Unggulan Kami</h2>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5" data-aos="fade-up" data-aos-delay="100">
            <button type="button" class="btn btn-filter active" onclick="filterMenusByCategory(null, this)">Semua</button>
            @foreach ($categories as $category)
                <button type="button" class="btn btn-filter" onclick="filterMenusByCategory({{ $category->id_k }}, this)">
                    {{ $category->nama_k }}
                </button>
            @endforeach
        </div>

        <div id="menusContainer" class="row g-4">
            @include('partials.menu_items', ['menus' => $menus])
        </div>
        <div id="menusPagination" class="mt-5 d-flex justify-content-center">
            {{ $menus->links('pagination::bootstrap-4') }}
        </div>
    </div>
</section>

<!-- 4. GALLERY SECTION -->
<section id="info" class="py-5" style="background-color: #fdfaff;">
    <div class="container py-5 text-center">
        <div class="mb-5" data-aos="fade-up">
            <span class="text-purple-600 fw-bold text-uppercase small ls-2 d-block mb-2">Our Portfolio</span>
            <h2 class="display-5 fw-bold serif text-dark mb-2">Gallery & Updates</h2>
            <p class="text-muted fs-5">Inspirasi gaya terbaru dari para ahli kami</p>
        </div>

        @if($informasi->count() > 0)
            @php $chunks = $informasi->chunk(5); @endphp
            <div class="gallery-container" data-aos="fade-up" data-aos-delay="100">
                <div id="galleryCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">
                        @foreach($chunks as $index => $chunk)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-lg-5 justify-content-center px-1">
                                @foreach($chunk as $info)
                                <div class="col">
                                    <div class="gallery-slide" onclick="openGalleryPreview('{{ asset('assets/uploads/'.$info->foto_inf) }}', '{{ addslashes($info->judul_inf) }}', '{{ addslashes($info->keterangan_inf) }}')">
                                        <img src="{{ asset('assets/uploads/'.$info->foto_inf) }}"
                                             alt="{{ $info->judul_inf }}"
                                             onerror="this.src='https://images.unsplash.com/photo-1522337660859-02fbefca4702?auto=format&fit=crop&w=400&q=80'">
                                        <div class="gallery-info text-start">
                                            <h5 class="fw-bold mb-1">{{ $info->judul_inf }}</h5>
                                            <p class="small opacity-75 mb-0">{{ Str::limit($info->keterangan_inf, 40) }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="gallery-nav mt-5">
                    <button class="gallery-btn" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <div class="gallery-counter">
                        <span id="currentSlide">1</span> / <span>{{ $chunks->count() }}</span>
                    </div>
                    <button class="gallery-btn" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <p class="text-muted fs-5">Belum ada koleksi gallery.</p>
            </div>
        @endif
    </div>
</section>

<!-- Gallery Preview Modal -->
<div id="galleryModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden" style="border-radius: 30px;">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-lg-8">
                        <img id="previewImage" src="" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 400px;">
                    </div>
                    <div class="col-lg-4 p-5 d-flex flex-column bg-white">
                        <button type="button" class="btn-close ms-auto mb-4" data-bs-dismiss="modal"></button>
                        <h3 class="serif fw-bold mb-4" id="galleryTitle"></h3>
                        <p class="text-muted" id="previewDesc"></p>
                        <div class="mt-auto">
                            <hr>
                            <p class="small text-uppercase tracking-widest fw-bold text-purple-600 mb-0">NH Beauty Salon Portfolio</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
