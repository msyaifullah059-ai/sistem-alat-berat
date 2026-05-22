@extends('profile')

@section('title', 'Profile')

@section('home')

    <div class="position-relative" id="home">
        <div class="text-white d-flex align-items-center"
            style="
            min-height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('assets/profile/images/hero_1.jpg') center/cover no-repeat;
         ">

            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6">
                        <h1 class="fw-bold text-light display-4 mb-4">
                            Sistem Manajemen Alat Berat Modern & Efisien
                        </h1>

                        <p class="mb-4 text-light" style="max-width: 500px;">
                            Kelola operasional alat berat dengan lebih mudah, cepat, dan terstruktur dalam satu sistem
                            terintegrasi.
                        </p>

                        <div class="d-flex gap-3">
                            <a href="#contact" class="btn btn-primary rounded-pill px-4 py-2 shadow">
                                Hubungi Kami
                            </a>&nbsp;

                            <a href="#service" class="btn btn-outline-light rounded-pill px-4 py-2">
                                Lihat Layanan
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@section('about')

    <div class="py-5 bg-white" id="about">
        <div class="container">
            @foreach ($abouts as $about)
                <div class="row align-items-center g-5">

                    <div class="col-lg-6">
                        <img src="{{ url('storage/' . $about->gambar) }}" class="img-fluid rounded-4 shadow-sm w-100"
                            style="height: 350px; object-fit: cover;">
                    </div>

                    <div class="col-lg-5">
                        <span class="badge bg-primary-subtle text-primary mb-3">
                            Tentang Kami
                        </span>

                        <h2 class="fw-bold mb-3">
                            Solusi Terbaik untuk Manajemen Alat Berat
                        </h2>

                        <p class="text-muted">
                            {{ $about->deskripsi }}
                        </p>

                        <a href="#service" class="btn btn-primary rounded-pill px-4 mt-3">
                            Lihat Layanan
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    </div>

@endsection

@section('service')

    <div class="py-5 bg-white" id="service">
        <div class="container">

            <!-- Heading -->
            <div class="text-center mb-5">
                <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2 mb-3">
                    Layanan Profesional
                </span>

                <h2 class="fw-bold display-5 mb-3">
                    Layanan Unggulan Kami
                </h2>

                <p class="text-muted mx-auto" style="max-width: 650px;">
                    Solusi profesional untuk membantu operasional alat berat menjadi lebih efisien,
                    aman, dan terintegrasi dengan kebutuhan proyek modern.
                </p>
            </div>

            <!-- Service cards -->
            <div class="row g-4">
                @foreach ($services as $service)
                    <div class="col-md-6 col-lg-4">

                        <div class="card border-0 shadow h-100 rounded-4 overflow-hidden" style="transition: all .3s ease;"
                            onmouseover="this.style.transform='translateY(-10px)'"
                            onmouseout="this.style.transform='translateY(0)'">

                            <!-- image -->
                            <div class="position-relative">
                                <img src="{{ url('storage/' . $service->gambar) }}" class="w-100"
                                    style="height: 230px; object-fit: cover;">

                                <span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill">
                                    Premium
                                </span>
                            </div>

                            <!-- content -->
                            <div class="card-body p-4 d-flex flex-column">

                                <h5 class="fw-bold mb-3">
                                    {{ $service->judul }}
                                </h5>

                                <p class="text-muted small flex-grow-1">
                                    {{ $service->deskripsi }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="#contact" class="btn btn-primary rounded-pill px-4 btn-sm">
                                        Konsultasi
                                    </a>

                                    <span class="text-primary fs-5">
                                        →
                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </div>

@endsection

@section('tools')

    <div class="py-5 bg-white" id="tools">
        <div class="container">

            <!-- Heading -->
            <div class="text-center mb-5">
                <span class="badge bg-primary-subtle text-primary mb-3">
                    Alat & Harga
                </span>

                <h2 class="fw-bold display-6">
                    Alat Berat & Harga Sewa
                </h2>

                <p class="text-muted">
                    Pilih alat berat sesuai kebutuhan proyek Anda dengan harga terbaik
                </p>
            </div>

            <!-- Cards -->
            <div class="row g-4">

                @foreach ($tools as $tool)
                    <div class="col-md-6 col-lg-4">

                        <div class="card border-0 shadow-sm h-100">

                            <!-- Image -->
                            <img src="{{ url('storage/' . $tool->gambar) }}" class="card-img-top"
                                style="height: 220px; object-fit: cover;">

                            <!-- Content -->
                            <div class="card-body d-flex flex-column p-4">

                                <!-- Nama alat -->
                                <h5 class="fw-semibold mb-2">
                                    {{ $tool->nama_alat }}
                                </h5>

                                <!-- Deskripsi -->
                                <p class="text-muted small mb-3">
                                    {{ $tool->deskripsi ?? 'Alat berat berkualitas untuk kebutuhan proyek Anda.' }}
                                </p>
                                <!-- Harga -->

                                <h6 class="fw-bold text-primary mb-3">
                                    @forelse ($tool->pricing as $price)
                                        <li class="mb-1">
                                            <span class="me-2">{{ ucwords($price->jenis_pekerjaan) }}</span>
                                            - Rp {{ number_format($price->harga_per_jam, 0, ',', '.') }} /
                                            jam
                                        </li>
                                    @empty
                                        <li class="text-danger small">Harga belum tersedia</li>
                                    @endforelse
                                </h6>

                                <!-- Features -->
                                <ul class="list-unstyled text-muted small mb-4">
                                    <li>✔ Kondisi {{ ucwords($tool->status) }}</li>
                                    <li>✔ Operator Berpengalaman</li>
                                    <li>✔ Support Maintenance</li>
                                </ul>

                                <!-- CTA -->
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <a href="#contact" class="btn btn-primary btn-sm rounded-pill px-3">
                                        Sewa Sekarang
                                    </a>

                                    <span class="text-primary fs-5">→</span>
                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>
    </div>

@endsection

@section('kontak')

    <div class="py-5 bg-body-tertiary" id="contact">
        <div class="container">

            <!-- Heading -->
            <div class="text-center mb-5">
                <span class="badge bg-primary-subtle text-primary mb-3">
                    Lokasi
                </span>
                <h2 class="fw-bold display-6">
                    Lokasi Kami
                </h2>
                <p class="text-muted">
                    Kunjungi kami atau hubungi untuk informasi lebih lanjut
                </p>
            </div>

            <div class="row g-4 align-items-stretch">

                <!-- Maps -->
                <div class="col-lg-7">
                    <div class="shadow-sm rounded overflow-hidden w-100" style="height: 100%; min-height: 330px;">
                        <iframe src="https://www.google.com/maps?q=-6.200000,106.816666&hl=id&z=14&output=embed"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>

                <!-- Info -->
                <div class="col-lg-5">

                    <div class="card border-0 shadow-sm p-4">

                        <h5 class="fw-bold mb-3">
                            Informasi Kontak
                        </h5>

                        <ul class="list-unstyled small text-muted">
                            <li class="mb-3">
                                📍 <strong>Alamat:</strong><br>
                                Jl. Contoh No.123, Indonesia
                            </li>

                            <li class="mb-3">
                                📞 <strong>Telepon:</strong><br>
                                +62 812-xxxx-xxxx
                            </li>

                            <li class="mb-3">
                                📧 <strong>Email:</strong><br>
                                info@email.com
                            </li>
                        </ul>

                        <a href="https://maps.google.com" target="_blank"
                            class="btn btn-primary rounded-pill w-100 mt-2">
                            Buka di Google Maps
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection

<a href="https://wa.me/6285338508220?text=Halo%20saya%20ingin%20bertanya%20tentang%20alat%20berat" target="_blank"
    class="btn btn-success rounded-circle shadow position-fixed d-flex align-items-center justify-content-center"
    style="width:50px; height:50px; bottom:20px; right:20px; z-index:999;">

    <i class="mdi mdi-whatsapp fs-4"></i>
</a>

<a href="#home" id="btnTop"
    class="btn btn-primary rounded-circle shadow position-fixed d-flex align-items-center justify-content-center"
    style="width:50px; height:50px; bottom:90px; right:20px; z-index:999; display:none;">

    <i class="mdi mdi-arrow-up"></i>
</a>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const elements = document.querySelectorAll('.card, h1, h2, p, img');

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = "translateY(0)";
                }
            });
        });

        elements.forEach(el => {
            el.style.opacity = 0;
            el.style.transform = "translateY(20px)";
            el.style.transition = "all 0.6s ease";
            observer.observe(el);
        });
    });
</script>

<script>
    window.addEventListener("scroll", function() {
        const btn = document.getElementById("btnTop");

        if (window.scrollY > 300) {
            btn.style.display = "flex";
        } else {
            btn.style.display = "none";
        }
    });
</script>
