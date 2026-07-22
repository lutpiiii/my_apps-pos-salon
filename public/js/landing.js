document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
        easing: 'ease-out-cubic'
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
                cancelButtonText: 'Batal',
                borderRadius: '25px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

    // 2. Navbar Scroll Effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
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
                cancelButtonText: 'Batal',
                borderRadius: '25px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

    // 3. Smooth Scroll for Nav Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
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
                cancelButtonText: 'Batal',
                borderRadius: '25px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

                // Close mobile menu if open
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse.classList.contains('show')) {
                    bootstrap.Collapse.getInstance(navbarCollapse).hide();
                }
            }
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
                cancelButtonText: 'Batal',
                borderRadius: '25px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
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
                cancelButtonText: 'Batal',
                borderRadius: '25px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

    // 4. Gallery Carousel Counter
    const galleryCarousel = document.getElementById('galleryCarousel');
    const currentSlideSpan = document.getElementById('currentSlide');
    if (galleryCarousel && currentSlideSpan) {
        galleryCarousel.addEventListener('slid.bs.carousel', function (event) {
            currentSlideSpan.textContent = event.to + 1;
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
                cancelButtonText: 'Batal',
                borderRadius: '25px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
    }
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
                cancelButtonText: 'Batal',
                borderRadius: '25px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

// 5. Gallery Preview Logic
function openGalleryPreview(imageSrc, title, description) {
    const modalImg = document.getElementById('previewImage');
    const modalTitle = document.getElementById('galleryTitle');
    const modalDesc = document.getElementById('previewDesc');

    if (modalImg && modalTitle && modalDesc) {
        modalImg.src = imageSrc;
        modalTitle.textContent = title;
        modalDesc.textContent = description;

        const modal = new bootstrap.Modal(document.getElementById('galleryModal'));
        modal.show();
    }
}

// 6. Category Filtering (AJAX)
function filterMenusByCategory(categoryId, element) {
    // Update UI active state
    const buttons = document.querySelectorAll('.btn-filter');
    buttons.forEach(btn => btn.classList.remove('active'));
    if (element) element.classList.add('active');

    const menusContainer = document.getElementById('menusContainer');

    // Show loading state
    menusContainer.style.opacity = '0.5';
    menusContainer.style.transition = 'opacity 0.3s ease';

    const url = new URL(window.location.href);
    if (categoryId) {
        url.searchParams.set('id_kategori', categoryId);
    } else {
        url.searchParams.delete('id_kategori');
    }

    fetch(url, {
        headers: { "X-Requested-With": "XMLHttpRequest" }
    })
    .then(response => response.text())
    .then(html => {
        menusContainer.innerHTML = html;
        menusContainer.style.opacity = '1';
        AOS.refresh();
    })
    .catch(error => {
        console.error('Error fetching menus:', error);
        menusContainer.style.opacity = '1';
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
                cancelButtonText: 'Batal',
                borderRadius: '25px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
}
