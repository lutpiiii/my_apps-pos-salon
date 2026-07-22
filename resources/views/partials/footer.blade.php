<footer class="footer-modern">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-right" id="location">
                <div class="mb-4">
                    <span class="hero-badge">Visit Us</span>
                    <h2 class="display-5 fw-bold serif text-light mb-4">{{ $profile->nama_prf ?? 'NH Beauty Salon' }}</h2>
                    <span class="cursive gradient-text display-3">Art of Beauty</span>
                    <p class="fs-5 mt-4 text-light opacity-75">Menghadirkan seni kecantikan dan perawatan eksklusif untuk gaya hidup modern Anda. Kami percaya bahwa setiap individu layak mendapatkan sentuhan terbaik untuk memancarkan kecantikan aslinya.</p>
                </div>
                <div class="social-links d-flex gap-2" data-aos="fade-up" data-aos-delay="100">
                    <a href="#" class="rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" class="rounded-circle d-flex align-items-center justify-content-center"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
            <div class="col-lg-7" data-aos="zoom-in">
                <div class="map-container shadow-lg rounded-5 overflow-hidden border border-white/10" style="height: 400px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d258110.26065274488!2d112.26045730548606!3d-7.49692591733293!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb308f756603%3A0xf58a857a671bb66b!2snH%20Beauty%20Salon!5e1!3m2!1sid!2sid!4v1781504824094!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom mt-5">
        <div class="container text-center">
            <p class="mb-0 small opacity-75">
                &copy; {{ date('Y') }} <span class="text-white fw-bold">{{ $profile->nama_prf ?? 'NH Beauty Salon' }}</span>. All Rights Reserved.
                <span class="d-block d-md-inline mt-2 mt-md-0 ms-md-2 opacity-50">Crafted with ❤️ for Elegance.</span>
            </p>
        </div>
    </div>
</footer>
