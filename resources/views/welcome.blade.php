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
                    <button type="button" class="btn btn-purple px-5 py-3 rounded-pill fw-bold shadow-lg d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalBooking">
                        <i class="bi bi-calendar2-check-fill fs-5"></i>
                        <span>Reservasi Sekarang</span>
                    </button>
                    <button type="button" class="btn btn-outline-light px-4 py-3 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalCekBooking">
                        <i class="bi bi-search me-1"></i> Cek Status Reservasi
                    </button>
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

<!-- MODAL RESERVASI ONLINE (MULTI-SERVICES) -->
<div class="modal fade" id="modalBooking" tabindex="-1" aria-labelledby="modalBookingLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-header text-white p-4" style="background: linear-gradient(135deg, #4c1d95, #7e22ce);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white/20 p-3 rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-calendar2-heart-fill fs-4"></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold text-white mb-0" id="modalBookingLabel">Form Reservasi Salon</h4>
                        <p class="text-white/80 small mb-0">Pilih 1 atau lebih layanan favorit Anda dalam 1 kali reservasi</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 p-md-5 bg-light">
                <form id="formBooking">
                    @csrf
                    <div class="row g-4">
                        <!-- Data Diri Pelanggan -->
                        <div class="col-lg-5">
                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                                <h5 class="fw-bold text-purple-700 mb-4"><i class="bi bi-person-lines-fill me-2"></i>Data Pelanggan & Jadwal</h5>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark"><i class="bi bi-person me-1 text-purple-600"></i> Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pelanggan" class="form-control form-control-lg rounded-3 border bg-light" placeholder="Contoh: Anita Wijaya" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark"><i class="bi bi-whatsapp me-1 text-success"></i> No. WhatsApp / HP <span class="text-danger">*</span></label>
                                    <input type="tel" name="notelp_pelanggan" class="form-control form-control-lg rounded-3 border bg-light" placeholder="Contoh: 081234567890" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark"><i class="bi bi-envelope me-1 text-purple-600"></i> Email (Opsional)</label>
                                    <input type="email" name="email_pelanggan" class="form-control rounded-3 border bg-light" placeholder="anita@example.com">
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark"><i class="bi bi-calendar-event me-1 text-purple-600"></i> Tanggal <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_reservasi" class="form-control rounded-3 border bg-light" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark"><i class="bi bi-clock me-1 text-purple-600"></i> Jam <span class="text-danger">*</span></label>
                                        <input type="time" name="jam_reservasi" class="form-control rounded-3 border bg-light" value="10:00" min="09:00" max="19:00" required>
                                    </div>
                                </div>
                                <div class="row g-4 mb-4">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-dark"><i class="bi bi-chat-left-text me-1 text-purple-600"></i> Catatan Khusus</label>
                                        <textarea name="catatan" class="form-control rounded-3 border bg-light" rows="3" placeholder="Contoh: Minta keramas air hangat..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Multi-Selection Layanan -->
                        <div class="col-lg-7">
                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold text-purple-700 mb-0"><i class="bi bi-scissors me-2"></i>Pilih Layanan Salon</h5>
                                    <span class="badge bg-purple-100 text-purple-700 fw-bold px-3 py-2 rounded-pill" id="selectedCountBadge">0 Layanan Dipilih</span>
                                </div>
                                <p class="text-muted small mb-3">Tentukan jumlah (Qty) layanan yang Anda inginkan:</p>

                                <div class="row g-2 mb-3">
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                            <input type="text" id="searchServiceBooking" class="form-control bg-light border-0" placeholder="Cari layanan...">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <select id="filterCategoryBooking" class="form-select bg-light border-0">
                                            <option value="all">Semua Kategori</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id_k }}">{{ $cat->nama_k }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="overflow-auto pe-2 flex-grow-1" style="max-height: 340px;" id="servicesListContainer">
                                    @foreach($allMenus as $m)
                                    <div class="card border border-light shadow-sm rounded-3 p-3 mb-2 service-checkbox-item" data-name="{{ strtolower($m->nama_m) }}" data-category="{{ $m->id_kategori }}">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="form-check d-flex align-items-center gap-3 mb-0">
                                                <input class="form-check-input service-check" type="checkbox" data-id="{{ $m->id_m }}" data-nama="{{ $m->nama_m }}" data-harga="{{ $m->harga_m }}" id="chk_service_{{ $m->id_m }}" onchange="toggleServiceSelection({{ $m->id_m }})">
                                                <label class="form-check-label cursor-pointer" for="chk_service_{{ $m->id_m }}">
                                                    <div class="fw-bold text-dark mb-0">{{ $m->nama_m }}</div>
                                                    <div class="small text-purple-600 fw-bold">Rp {{ number_format($m->harga_m, 0, ',', '.') }}</div>
                                                </label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2" style="max-width: 120px;">
                                                <span class="small text-muted">Qty:</span>
                                                <input type="number" class="form-control form-control-sm text-center rounded-2 border service-qty" data-id="{{ $m->id_m }}" value="0" min="0" max="10" style="width: 55px;" onchange="syncCheckboxWithQty({{ $m->id_m }})" oninput="syncCheckboxWithQty({{ $m->id_m }})">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Ringkasan Total Biaya -->
                                <div class="bg-purple-100 rounded-4 p-3 mt-3 d-flex align-items-center justify-content-between border border-purple-200">
                                    <div>
                                        <div class="small text-purple-700 fw-bold text-uppercase" style="letter-spacing: 0.5px;"><i class="bi bi-calculator me-1"></i> Estimasi Total</div>
                                        <div class="fs-3 fw-bold text-purple-900" id="liveBookingTotal">Rp 0</div>
                                    </div>
                                    <button type="submit" id="btnSubmitBooking" class="btn btn-purple px-4 py-3 rounded-pill fw-bold text-white shadow-md">
                                        <i class="bi bi-send-fill me-1"></i> Kirim Reservasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CEK STATUS RESERVASI -->
<div class="modal fade" id="modalCekBooking" tabindex="-1" aria-labelledby="modalCekBookingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-header bg-dark text-white p-4">
                <h5 class="modal-title fw-bold text-white" id="modalCekBookingLabel"><i class="bi bi-search me-2 text-warning"></i> Cek Status Reservasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="input-group mb-3 shadow-sm rounded-3 overflow-hidden">
                    <input type="text" id="inputQueryCek" class="form-control form-control-lg border-0" placeholder="Kode Booking / No. WhatsApp">
                    <button class="btn btn-purple px-4" type="button" id="btnCekBooking"><i class="bi bi-search"></i> Cari</button>
                </div>
                <div id="hasilCekBooking" class="mt-4">
                    <p class="text-muted small text-center">Masukkan Kode Reservasi (misal: RSV-20260724-XXXX) atau Nomor Telepon Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>

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

@section('scripts')
<script>
    // Live Calculation & Search in Booking Modal
    function updateBookingTotal() {
        let total = 0;
        let count = 0;

        document.querySelectorAll('.service-check').forEach(chk => {
            if (chk.checked) {
                count++;
                const harga = parseFloat(chk.dataset.harga) || 0;
                const idMenu = chk.dataset.id;
                const qtyInput = document.querySelector(`.service-qty[data-id="${idMenu}"]`);
                const qty = qtyInput ? (parseInt(qtyInput.value) || 0) : 0;
                total += (harga * qty);
            }
        });

        document.getElementById('liveBookingTotal').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('selectedCountBadge').innerText = `${count} Layanan Dipilih`;
    }

    // Sync Checkbox when Qty changes
    function syncCheckboxWithQty(id) {
        const qtyInput = document.querySelector(`.service-qty[data-id="${id}"]`);
        const checkbox = document.getElementById(`chk_service_${id}`);
        const qty = parseInt(qtyInput.value) || 0;

        if (qty > 0) {
            checkbox.checked = true;
        } else {
            checkbox.checked = false;
        }
        updateBookingTotal();
    }

    // Toggle Selection (when checkbox clicked)
    function toggleServiceSelection(id) {
        const checkbox = document.getElementById(`chk_service_${id}`);
        const qtyInput = document.querySelector(`.service-qty[data-id="${id}"]`);

        if (checkbox.checked) {
            if (parseInt(qtyInput.value) === 0) {
                qtyInput.value = 1;
            }
        } else {
            qtyInput.value = 0;
        }
        updateBookingTotal();
    }

    // Filter Service by Name and Category in Booking Modal
    function filterBookingServices() {
        const term = document.getElementById('searchServiceBooking').value.toLowerCase();
        const categoryId = document.getElementById('filterCategoryBooking').value;

        document.querySelectorAll('.service-checkbox-item').forEach(item => {
            const name = item.dataset.name;
            const category = item.dataset.category;

            const nameMatch = name.includes(term);
            const categoryMatch = (categoryId === 'all' || category === categoryId);

            if (nameMatch && categoryMatch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    document.getElementById('searchServiceBooking').addEventListener('input', filterBookingServices);
    document.getElementById('filterCategoryBooking').addEventListener('change', filterBookingServices);

    // AJAX Submit Form Reservasi (Multi-services)
    document.getElementById('formBooking').addEventListener('submit', function(e) {
        e.preventDefault();

        // Collect selected items
        const selectedItems = [];
        document.querySelectorAll('.service-check').forEach(chk => {
            if (chk.checked) {
                const idMenu = chk.dataset.id;
                const qtyInput = document.querySelector(`.service-qty[data-id="${idMenu}"]`);
                const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;
                selectedItems.push({
                    id_m: idMenu,
                    jumlah: qty
                });
            }
        });

        if (selectedItems.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Layanan',
                text: 'Silakan centang minimal 1 layanan perawatan.',
                confirmButtonColor: '#7e22ce'
            });
            return;
        }

        const btnSubmit = document.getElementById('btnSubmitBooking');
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengirim...';

        const formData = new FormData(this);
        // Append items array
        selectedItems.forEach((item, index) => {
            formData.append(`items[${index}][id_m]`, item.id_m);
            formData.append(`items[${index}][jumlah]`, item.jumlah);
        });

        fetch("{{ route('reservasi.store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="bi bi-send-fill me-1"></i> Kirim Reservasi';

            if (data.success) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalBooking'));
                if (modal) modal.hide();

                // Reset form & checkboxes
                document.getElementById('formBooking').reset();
                document.querySelectorAll('.service-check').forEach(c => c.checked = false);
                updateBookingTotal();

                // Format items list for HTML Receipt
                let itemsHtml = '';
                let waItemsText = '';
                data.data.items.forEach(it => {
                    itemsHtml += `
                        <div class="d-flex justify-content-between mb-1">
                            <span>• ${it.nama} ${it.qty > 1 ? '(' + it.qty + 'x)' : ''}</span>
                            <strong class="text-dark">${it.subtotal_formatted}</strong>
                        </div>
                    `;
                    waItemsText += `%0A - ${it.nama} ${it.qty > 1 ? '(' + it.qty + 'x)' : ''}: ${it.subtotal_formatted}`;
                });

                // Show SweetAlert Success Receipt
                Swal.fire({
                    icon: 'success',
                    title: 'Reservasi Berhasil!',
                    html: `
                        <div class="text-start bg-light p-3 rounded-4 mb-3" style="font-size: 0.9rem;">
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <span class="text-muted">Kode Booking:</span>
                                <strong class="text-purple-600 fs-5">${data.data.kode_reservasi}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Nama:</span>
                                <span>${data.data.nama}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Jadwal:</span>
                                <span>${data.data.tanggal} @ ${data.data.jam} WIB</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted d-block mb-1 fw-bold">Rincian Layanan:</span>
                                ${itemsHtml}
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top fw-bold fs-6">
                                <span class="text-dark">Total Biaya:</span>
                                <span class="text-purple-600">${data.data.total_harga}</span>
                            </div>
                        </div>
                        <p class="small text-muted mb-0">Simpan Kode Reservasi Anda untuk pemeriksaan kedatangan.</p>
                    `,
                    confirmButtonText: '<i class="bi bi-whatsapp me-1"></i> Konfirmasi ke WhatsApp',
                    confirmButtonColor: '#25D366',
                    showCancelButton: true,
                    cancelButtonText: 'Tutup',
                    cancelButtonColor: '#7e22ce',
                    borderRadius: '20px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const waText = `Halo NH Beauty Salon, saya ingin konfirmasi reservasi dengan Kode Booking *${data.data.kode_reservasi}* atas nama *${data.data.nama}* untuk tanggal ${data.data.tanggal} jam ${data.data.jam} WIB.${waItemsText}%0A*Total: ${data.data.total_harga}*`;
                        window.open(`https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->notelp_prf ?? '628993959351') }}?text=${waText}`, '_blank');
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Membuat Reservasi',
                    text: data.message || 'Terjadi kesalahan, silakan periksa kembali isian Anda.',
                    confirmButtonColor: '#7e22ce'
                });
            }
        })
        .catch(err => {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="bi bi-send-fill me-1"></i> Kirim Reservasi';
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Server',
                text: 'Gagal terhubung ke server. Silakan coba lagi.',
                confirmButtonColor: '#7e22ce'
            });
        });
    });

    // AJAX Cek Status Booking
    document.getElementById('btnCekBooking').addEventListener('click', function() {
        const query = document.getElementById('inputQueryCek').value.trim();
        const container = document.getElementById('hasilCekBooking');

        if (!query) {
            container.innerHTML = '<div class="alert alert-warning rounded-3 small">Masukkan Kode Reservasi atau Nomor Telepon!</div>';
            return;
        }

        container.innerHTML = '<div class="text-center py-3"><div class="spinner-border text-purple-600"></div></div>';

        fetch(`{{ route('reservasi.cek') }}?query=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(res => {
            if (res.success && res.data.length > 0) {
                let html = '<div class="list-group gap-2">';
                res.data.forEach(item => {
                    let itemsBadge = item.layanan_list.map(l => `<span class="badge bg-light text-dark border me-1 mb-1">${l}</span>`).join('');
                    html += `
                        <div class="list-group-item border-0 bg-white shadow-sm rounded-3 p-3 text-start">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-purple-600">${item.kode}</span>
                                ${item.badge}
                            </div>
                            <div class="small text-muted mb-1"><strong>${item.nama}</strong></div>
                            <div class="my-2">${itemsBadge}</div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-2 small text-secondary">
                                <span><i class="bi bi-clock me-1"></i> ${item.tanggal} @ ${item.jam} WIB</span>
                                <strong class="text-purple-700 fs-6">${item.total_harga}</strong>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = `<div class="alert alert-danger rounded-3 small mb-0">${res.message || 'Data reservasi tidak ditemukan.'}</div>`;
            }
        })
        .catch(() => {
            container.innerHTML = '<div class="alert alert-danger rounded-3 small mb-0">Gagal mengambil data reservasi.</div>';
        });
    });
</script>
@endsection
