<x-Landingpage.layout title="{{ $title }}">
    @if ($backgrounds)
        <!--<< Breadcrumb Section Start >>-->
        <div class="breadcrumb-wrapper bg-cover"
            style="background-image: url('{{ asset('storage/' . $backgrounds->about) }}');">
            <div class="border-shape">
                <img src="{{ asset('assets/img/element.png') }}" alt="shape-img">
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/img/line-element.png') }}" alt="shape-img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">ABOUT HMPI UPY</h1>
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <a href="/">
                                Home
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                        </li>
                        <li>
                            About
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <!--<< Breadcrumb Section Start >>-->
        <div class="breadcrumb-wrapper bg-cover"
            style="background-image: url('{{ asset('assets/img/default-img/about-default.jpg') }}');">
            <div class="border-shape">
                <img src="{{ asset('assets/img/element.png') }}" alt="shape-img">
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/img/line-element.png') }}" alt="shape-img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">ABOUT HMPI UPY</h1>
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <a href="/">
                                Home
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                        </li>
                        <li>
                            About
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if ($abouts)
        <!-- Team Section Start -->
        <section class="team-details-section fix section-padding">
            <div class="container">
                <div class="team-details-wrapper">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-5">
                            <div class="team-details-image">
                                <img src="{{ asset('storage/' . $abouts->background_image) }}"
                                    style="width: 470px; height: 528px; object-fit: cover;" alt="team-img">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="team-details-content">
                                <div class="details-info">
                                    <h3>{{ $abouts->title }}</h3>
                                </div>
                                <p class="mt-3">
                                    {!! $abouts->body !!}
                                </p>
                                <div class="social-icon">
                                    <span>Social Media:</span>
                                    <a href="{{ $abouts->instagram_url }}"><i class='bx bxl-instagram bx-tada'></i></a>
                                    <a href="{{ $abouts->tiktok_url }}"><i class='bx bxl-tiktok bx-tada'></i></a>
                                    <a href="{{ $abouts->youtube_url }}"><i class='bx bxl-youtube bx-tada'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- Team Section Start -->
        <section class="team-details-section fix section-padding">
            <div class="container">
                <div class="team-details-wrapper">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-5">
                            <div class="team-details-image">
                                <img src="{{ asset('assets/img/default-img/about-default.jpg') }}"
                                    style="width: 470px; height: 528px; object-fit: cover;" alt="team-img">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="team-details-content">
                                <div class="details-info">
                                    <h3>HMPI INFORMATIKA UPY</h3>
                                </div>
                                <p class="mt-3">
                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores quisquam
                                    dolorem sapiente labore adipisci cum ipsam repellendus, mollitia porro officia
                                    corrupti ex necessitatibus quia dolores. Soluta sint autem obcaecati fugiat adipisci
                                    repellendus delectus ipsam commodi qui eos minima mollitia, nisi quam suscipit illo
                                    at nemo saepe fuga quasi. Officiis, dolor.
                                </p>
                                <div class="social-icon">
                                    <span>Social Media:</span>
                                    <a href="https://www.instagram.com/hmpinformatika_upy?igsh=MTZjdzg3YWp0ZjhmeA=="
                                        target="_blank"><i class='bx bxl-instagram bx-tada'></i></a>
                                    <a href="https://www.tiktok.com/@hmpinformatikaupy1?_t=ZS-8vMXZWIPdBf&_r=1"
                                        target="_blank"><i class='bx bxl-tiktok bx-tada'></i></a>
                                    <a href="https://www.youtube.com/@hmpinformatikaupy" target="_blank"><i
                                            class='bx bxl-youtube bx-tada'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</x-Landingpage.layout>
