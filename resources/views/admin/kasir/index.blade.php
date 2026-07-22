@extends(Auth::user()->role_p === 'admin' ? 'layouts.dashboard.admin' : 'layouts.dashboard.kasir')

@section('styles')
<style>
    .menu-card {
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
        background: white;
        border-radius: 25px;
        position: relative;
        overflow: hidden;
    }
    .menu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(88, 28, 135, 0.1);
        border-color: var(--purple-soft);
    }
    .menu-card .add-icon {
        position: absolute;
        right: 15px;
        top: 15px;
        color: var(--purple-medium);
        opacity: 0.5;
        transition: all 0.3s ease;
    }
    .menu-card:hover .add-icon {
        opacity: 1;
        transform: scale(1.2);
    }
    .cart-container {
        position: sticky;
        top: 100px;
        height: calc(100vh - 140px);
        display: flex;
        flex-direction: column;
    }
    .cart-items-wrapper {
        flex: 1;
        overflow-y: auto;
        padding-right: 5px;
        margin-bottom: 20px;
    }
    .cart-items-wrapper::-webkit-scrollbar {
        width: 4px;
    }
    .cart-items-wrapper::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .category-pill {
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        border: 1px solid rgba(88, 28, 135, 0.1);
        padding: 10px 25px;
        border-radius: 100px;
        font-weight: 700;
        font-size: 0.85rem;
        white-space: nowrap;
        color: #64748b;
    }
    .category-pill.active {
        background: var(--purple-main);
        color: white !important;
        border-color: var(--purple-main);
        box-shadow: 0 8px 15px rgba(88, 28, 135, 0.2);
    }
    .cart-item {
        background: #fdfaff;
        border-radius: 20px;
        padding: 15px;
        margin-bottom: 12px;
        border-left: 6px solid var(--purple-medium);
        transition: all 0.2s ease;
        border-top: 1px solid rgba(88, 28, 135, 0.05);
        border-right: 1px solid rgba(88, 28, 135, 0.05);
        border-bottom: 1px solid rgba(88, 28, 135, 0.05);
    }
    .cart-item:hover {
        background: white;
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(88, 28, 135, 0.05);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Menu Selection -->
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold topbar-title mb-0">Kasir POS</h3>
                <div class="input-group" style="max-width: 350px;">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-4"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="searchMenu" class="form-control border-start-0 rounded-end-pill py-2" placeholder="Cari layanan...">
                </div>
            </div>

            <!-- Categories -->
            <div class="d-flex gap-2 overflow-auto pb-3 mb-4" id="categoryFilters">
                <span class="category-pill active" data-category="all">Semua</span>
                @foreach($categories as $cat)
                    <span class="category-pill" data-category="{{ $cat->id_k }}">{{ $cat->nama_k }}</span>
                @endforeach
            </div>

            <!-- Menu Grid -->
            <div class="row g-3" id="menuGrid">
                @foreach($menus as $menu)
                <div class="col-md-4 menu-item" data-category="{{ $menu->id_kategori }}" data-name="{{ strtolower($menu->nama_m) }}">
                    <div class="card h-100 border-0 shadow-sm menu-card p-4" onclick="addToCart({{ json_encode($menu) }})">
                        <i class="bi bi-plus-circle-fill add-icon fs-4"></i>
                        <div class="mb-3">
                            <span class="badge bg-purple-ultra-light text-purple-600 px-3 py-2 rounded-pill small" style="background: var(--purple-ultra-light); color: var(--purple-main);">
                                {{ $menu->kategori->nama_k }}
                            </span>
                        </div>
                        <h5 class="fw-bold mb-1 text-dark">{{ $menu->nama_m }}</h5>
                        <p class="text-purple-600 fw-bold fs-5 mb-0">Rp {{ number_format($menu->harga_m, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Cart / Order Summary -->
        <div class="col-lg-4">
            <div class="card card-refined border-0 shadow-lg cart-container">
                <div class="card-body p-4 d-flex flex-column h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0 text-purple-600">Order Summary</h5>
                        <button class="btn btn-sm btn-light text-danger rounded-pill px-3 fw-bold" onclick="clearCart()">Reset</button>
                    </div>

                    <!-- Cart Items Wrapper -->
                    <div class="cart-items-wrapper">
                        <div id="cartItemsList">
                            <!-- Items will be injected here -->
                        </div>

                        <div class="text-center py-5 text-muted" id="emptyCartMsg">
                            <i class="bi bi-cart3 fs-1 mb-2 d-block opacity-25"></i>
                            <p>Keranjang masih kosong</p>
                        </div>
                    </div>

                    <!-- Calculation Area -->
                    <div class="border-top pt-4 mt-auto">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-bold">Subtotal</span>
                            <span class="text-dark fw-bold" id="subtotal">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="fw-bold text-dark">Total</h5>
                            <h5 class="fw-bold text-purple-600" id="totalOrder">Rp 0</h5>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Bayar (Rp)</label>
                            <input type="number" id="inputBayar" class="form-control form-control-lg rounded-4 border-2 fw-bold text-purple-600" placeholder="0" oninput="calculateChange()">
                        </div>

                        <div class="d-flex justify-content-between mb-4 align-items-center bg-light p-3 rounded-4">
                            <span class="text-muted small fw-bold">Kembalian</span>
                            <span class="fw-bold" id="kembalian">Rp 0</span>
                        </div>

                        <button class="btn btn-purple-refined btn-lg w-100 py-3 shadow-sm rounded-4" id="btnCheckout" onclick="processCheckout()" disabled>
                            Selesaikan Transaksi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content modal-content-refined shadow-lg">
            <div class="modal-body p-5 text-center">
                <div class="icon-box bg-success bg-opacity-10 text-success mx-auto mb-4" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                    <i class="bi bi-check-lg"></i>
                </div>
                <h4 class="fw-bold mb-2">Berhasil!</h4>
                <p class="text-muted mb-4">Transaksi telah selesai diproses.</p>
                <div class="d-grid">
                    <button class="btn btn-purple-refined rounded-pill" data-bs-dismiss="modal">Transaksi Baru</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let cart = [];
    let totalValue = 0; // Renamed to avoid confusion with potential DOM elements

    // Add to cart function
    function addToCart(menu) {
        cart.push({...menu}); // Clone object
        updateCartUI();
    }

    // Remove from cart
    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCartUI();
    }

    // Clear cart
    function clearCart() {
        cart = [];
        document.getElementById('inputBayar').value = '';
        updateCartUI();
    }

    // Update UI
    function updateCartUI() {
        const cartList = document.getElementById('cartItemsList');
        const emptyMsg = document.getElementById('emptyCartMsg');
        const subtotalEl = document.getElementById('subtotal');
        const totalEl = document.getElementById('totalOrder');
        const btnCheckout = document.getElementById('btnCheckout');

        totalValue = 0;

        if (cart.length === 0) {
            cartList.innerHTML = '';
            emptyMsg.classList.remove('d-none');
            subtotalEl.innerText = 'Rp 0';
            totalEl.innerText = 'Rp 0';
            btnCheckout.disabled = true;
            calculateChange();
            return;
        }

        emptyMsg.classList.add('d-none');
        cartList.innerHTML = '';

        cart.forEach((item, index) => {
            const price = Number(item.harga_m) || 0;
            totalValue += price;

            const itemEl = document.createElement('div');
            itemEl.className = 'cart-item d-flex justify-content-between align-items-center animate__animated animate__fadeInUp animate__faster';
            itemEl.innerHTML = `
                <div>
                    <h6 class="mb-1 fw-bold text-dark">${item.nama_m}</h6>
                    <span class="text-purple-600 fw-bold">Rp ${new Intl.NumberFormat('id-ID').format(price)}</span>
                </div>
                <button class="btn btn-sm btn-white shadow-sm text-danger rounded-circle p-2" onclick="removeFromCart(${index})" style="width: 35px; height: 35px;">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            cartList.appendChild(itemEl);
        });

        const formattedTotal = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalValue);
        subtotalEl.innerText = formattedTotal;
        totalEl.innerText = formattedTotal;

        calculateChange();
    }

    // Calculate Change
    function calculateChange() {
        const bayarInput = document.getElementById('inputBayar');
        const bayar = parseFloat(bayarInput.value) || 0;
        const kembalianEl = document.getElementById('kembalian');
        const btnCheckout = document.getElementById('btnCheckout');

        const kembalian = bayar - totalValue;

        if (totalValue > 0) {
            if (bayar >= totalValue) {
                kembalianEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(kembalian);
                kembalianEl.className = 'fw-bold text-success';
                btnCheckout.disabled = false;
            } else {
                kembalianEl.innerText = '-' + new Intl.NumberFormat('id-ID').format(Math.abs(kembalian));
                kembalianEl.className = 'fw-bold text-danger';
                btnCheckout.disabled = true;
            }
        } else {
            kembalianEl.innerText = 'Rp 0';
            kembalianEl.className = 'fw-bold text-muted';
            btnCheckout.disabled = true;
        }
    }

    // Search Filter
    document.getElementById('searchMenu').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.menu-item').forEach(item => {
            const name = item.dataset.name;
            item.style.display = name.includes(term) ? 'block' : 'none';
        });
    });

    // Category Filter
    document.querySelectorAll('.category-pill').forEach(pill => {
        pill.addEventListener('click', function() {
            document.querySelectorAll('.category-pill').forEach(p => p.classList.remove('active'));
            this.classList.add('active');

            const catId = this.dataset.category;
            document.querySelectorAll('.menu-item').forEach(item => {
                if (catId === 'all' || item.dataset.category === catId) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Checkout Process
    function processCheckout() {
        const bayar = parseFloat(document.getElementById('inputBayar').value) || 0;
        if (bayar < totalValue) {
            alert('Pembayaran kurang!');
            return;
        }

        const btn = document.getElementById('btnCheckout');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

        const data = {
            items: cart.map(item => ({ id_m: item.id_m })),
            total_bayar: totalValue,
            bayar: bayar,
            _token: '{{ csrf_token() }}'
        };

        fetch('{{ route("admin.kasir.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                clearCart();
                Swal.fire({
                    icon: 'success',
                    title: 'Transaksi Berhasil!',
                    text: 'Pesanan telah diproses dan disimpan.',
                    showCancelButton: true,
                    confirmButtonText: '<i class="bi bi-printer me-2"></i> Cetak Struk',
                    cancelButtonText: 'Transaksi Baru',
                    confirmButtonColor: '#7e22ce',
                    cancelButtonColor: '#94a3b8',
                    borderRadius: '25px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(`/admin/transaksi/${res.id_t}/cetak`, '_blank');
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Transaksi Gagal',
                    text: res.message,
                    confirmButtonColor: '#7e22ce'
                });
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan sistem.');
        })
        .finally(() => {
            btn.innerHTML = 'Selesaikan Transaksi';
            btn.disabled = cart.length === 0;
        });
    }
</script>
@endsection
