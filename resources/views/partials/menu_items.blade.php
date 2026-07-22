@foreach($menus as $index => $menu)
<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
    <div class="card p-4 card-luxury shadow-sm h-100 text-start">
        <div class="text-purple-600 mb-3"><i class="bi bi-scissors fs-2" style="color: #7c3aed;"></i></div>
        <h5 class="fw-bold serif mb-2">{{ $menu->nama_m }}</h5>
        <p class="text-muted small mb-4">Tingkatkan gaya hidup Anda dengan perawatan eksklusif kami.</p>
        <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top">
            <span class="fw-bold fs-5" style="color: #7c3aed;">Rp {{ number_format($menu->harga_m, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
@endforeach
