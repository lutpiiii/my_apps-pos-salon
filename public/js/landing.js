document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize AOS safely
    try {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100,
                easing: 'ease-out-cubic'
            });
        }
    } catch (e) {
        console.error('AOS init error:', e);
    }

    // 2. Navbar Scroll Effect
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // 3. Smooth Scroll for Nav Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#' || href.includes('page=')) return; // Don't intercept pagination links

            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });

                // Close mobile menu if open safely
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                    const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                    if (bsCollapse) bsCollapse.hide();
                }
            }
        });
    });

    // 4. Gallery Carousel Counter
    const galleryCarousel = document.getElementById('galleryCarousel');
    const currentSlideSpan = document.getElementById('currentSlide');
    if (galleryCarousel && currentSlideSpan) {
        galleryCarousel.addEventListener('slid.bs.carousel', function (event) {
            currentSlideSpan.textContent = event.to + 1;
        });
    }

    // 7. Handle Pagination Clicks (AJAX)
    document.addEventListener('click', function(e) {
        if (e.target.closest('#menusPagination .page-link')) {
            e.preventDefault();
            const url = e.target.closest('.page-link').href;
            fetchMenus(url);

            // Scroll back to top of services section
            const servicesSection = document.getElementById('services');
            if (servicesSection) {
                const headerOffset = 80;
                const elementPosition = servicesSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
            }
        }
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

        const modalEl = document.getElementById('galleryModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }
}

// 6. Category Filtering (AJAX)
function filterMenusByCategory(categoryId, element) {
    const buttons = document.querySelectorAll('.btn-filter');
    buttons.forEach(btn => btn.classList.remove('active'));
    if (element) element.classList.add('active');

    const url = new URL(window.location.href);
    if (categoryId) {
        url.searchParams.set('id_kategori', categoryId);
    } else {
        url.searchParams.delete('id_kategori');
    }
    url.searchParams.delete('page'); // Reset to page 1 on filter change

    fetchMenus(url.toString());
}

// 8. Centralized Fetch Logic for Menus
function fetchMenus(url) {
    const menusContainer = document.getElementById('menusContainer');
    const paginationContainer = document.getElementById('menusPagination');
    if (!menusContainer) return;

    menusContainer.style.opacity = '0.5';
    menusContainer.style.transition = 'opacity 0.3s ease';

    fetch(url, {
        headers: { "X-Requested-With": "XMLHttpRequest" }
    })
    .then(response => response.json())
    .then(data => {
        menusContainer.innerHTML = data.html;
        if (paginationContainer) paginationContainer.innerHTML = data.pagination;

        menusContainer.style.opacity = '1';
        if (typeof AOS !== 'undefined') AOS.refresh();
    })
    .catch(error => {
        console.error('Error fetching menus:', error);
        menusContainer.style.opacity = '1';
    });
}
