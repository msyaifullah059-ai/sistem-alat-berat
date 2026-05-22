<footer class="bg-dark text-light pt-5 pb-3">
    <div class="container">

        <div class="row g-4">

            <!-- About -->
            <div class="col-lg-5">
                <h5 class="fw-bold mb-3 text-light">Tentang Kami</h5>
                @foreach ($abouts as $about)
                    <p class="text-light small">
                        {{ $about->deskripsi }}
                    </p>
                @endforeach

                <!-- CTA kecil -->
                <a href="#contact" class="btn btn-primary btn-sm rounded-pill mt-2">
                    Hubungi Kami
                </a>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-3">
                <h5 class="fw-bold mb-3 text-light">Tautan Cepat</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="#home" class="text-decoration-none text-light">
                            Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#about" class="text-decoration-none text-light">
                            Tentang
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#service" class="text-decoration-none text-light">
                            Layanan
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#tools" class="text-decoration-none text-light">
                            Alat
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact / Info -->
            <div class="col-lg-4">
                <h5 class="fw-bold mb-3 text-light">Hubungi Kami</h5>

                <ul class="list-unstyled small text-light">
                    <li class="mb-2">📍 Indonesia</li>
                    <li class="mb-2">📞 +62 812-xxxx-xxxx</li>
                    <li class="mb-2">📧 cvlisan@gmail.com</li>
                </ul>

                <!-- Social -->
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-light fs-5">🌐</a>
                    <a href="#" class="text-light fs-5">📘</a>
                    <a href="#" class="text-light fs-5">📷</a>
                </div>
            </div>

        </div>

        <!-- Divider -->
        <hr class="border-secondary my-4">

        <!-- Bottom -->
        <div class="text-center small">
            <p class="mb-0 text-secondary text-light">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                Sistem Manajemen Alat Berat. All rights reserved.
            </p>
        </div>

    </div>
</footer>
