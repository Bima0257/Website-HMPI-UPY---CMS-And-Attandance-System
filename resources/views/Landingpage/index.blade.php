<x-Landingpage.layout title="{{ $title }}">
    {{-- Carousel --}}
    <!-- Home -->
    <section class="hero-section fix hero-3">
        <div class="bottom-shape">
            <img src="{{ asset('assets/img/hero/bottom-shape.png') }}" alt="shape-img">
        </div>
        <div class="array-button">
            <button class="array-prev"><i class="fal fa-arrow-right"></i></button>
            <button class="array-next"><i class="fal fa-arrow-left"></i></button>
        </div>
        <div class="swiper hero-slider">
            <div class="swiper-wrapper">

                @if ($carousels->isNotEmpty())
                    @foreach ($carousels as $carousel)
                        <div class="swiper-slide">
                            <div class="slider-image bg-cover"
                                style="background-image: url('{{ asset('storage/' . $carousel->background_image) }}')">
                                <div class="mask-shape" data-animation="slideInDown" data-duration="3s" data-delay="2s">
                                    <img src="{{ asset('assets/img/hero/mask-shape-2.png') }}" alt="shape-img">
                                </div>
                                <div class="border-shape" data-animation="slideInRight" data-duration="3s"
                                    data-delay="2.2s">
                                    <img src="{{ asset('assets/img/hero/border-shape.png') }}" alt="shape-img">
                                </div>
                                <div class="circle-shape" data-animation="slideInRight" data-duration="3s"
                                    data-delay="2.1s">
                                    <img src="{{ asset('assets/img/choose/circle.png') }}" alt="shape-img">
                                </div>
                                <div class="frame" data-animation="slideInLeft" data-duration="3s" data-delay="2.2s">
                                    <img src="{{ asset('assets/img/frame.png') }}" alt="shape-img">
                                </div>
                            </div>
                            <div class="container">
                                <div class="row g-4 align-items-center">
                                    <div class="col-lg-8">
                                        <div class="hero-content">
                                            <h5 data-animation="slideInRight" data-duration="2s" data-delay=".3s">
                                                {{ $carousel->subtitle }}
                                            </h5>
                                            <h1 data-animation="slideInRight" data-duration="2s" data-delay=".5s">
                                                {{ $carousel->title }}
                                            </h1>
                                            <div data-animation="slideInRight" data-duration="2s" data-delay=".9s"
                                                class="text-white">
                                                {!! $carousel->body !!}
                                            </div>
                                            <div class="hero-button">
                                                <a href="/workPrograms" data-animation="slideInRight" data-duration="2s"
                                                    data-delay=".9s" class="theme-btn hover-white">
                                                    Explore More
                                                    <i class="fa-solid fa-arrow-right-long"></i>
                                                </a>
                                                <a href="/about" data-animation="slideInRight" data-duration="2s"
                                                    data-delay=".9s" class="theme-btn border-white">
                                                    Contact Us
                                                    <i class="fa-solid fa-arrow-right-long"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="swiper-slide">
                        <div class="slider-image bg-cover"
                            style="background-image: url('{{ asset('assets/img/default-img/default-carousel.jpg') }}')">
                            <div class="mask-shape" data-animation="slideInDown" data-duration="3s" data-delay="2s">
                                <img src="{{ asset('assets/img/hero/mask-shape-2.png') }}" alt="shape-img">
                            </div>
                            <div class="border-shape" data-animation="slideInRight" data-duration="3s"
                                data-delay="2.2s">
                                <img src="{{ asset('assets/img/hero/border-shape.png') }}" alt="shape-img">
                            </div>
                            <div class="circle-shape" data-animation="slideInRight" data-duration="3s"
                                data-delay="2.1s">
                                <img src="{{ asset('assets/img/choose/circle.png') }}" alt="shape-img">
                            </div>
                            <div class="frame" data-animation="slideInLeft" data-duration="3s" data-delay="2.2s">
                                <img src="{{ asset('assets/img/frame.png') }}" alt="shape-img">
                            </div>
                        </div>
                        <div class="container">
                            <div class="row g-4 align-items-center">
                                <div class="col-lg-8">
                                    <div class="hero-content">
                                        <h5 data-animation="slideInRight" data-duration="2s" data-delay=".3s">
                                            Welcome to Our Website
                                        </h5>
                                        <h1 data-animation="slideInRight" data-duration="2s" data-delay=".5s">
                                            HMPI INFORMATIKA UPY
                                        </h1>
                                        <div data-animation="slideInRight" data-duration="2s" data-delay=".9s"
                                            class="text-white">
                                            <p>Let's join and work together</p>
                                        </div>
                                        <div class="hero-button">
                                            <a href="/workPrograms" data-animation="slideInRight" data-duration="2s"
                                                data-delay=".9s" class="theme-btn hover-white">
                                                Explore More
                                                <i class="fa-solid fa-arrow-right-long"></i>
                                            </a>
                                            <a href="/about" data-animation="slideInRight" data-duration="2s"
                                                data-delay=".9s" class="theme-btn border-white">
                                                Contact Us
                                                <i class="fa-solid fa-arrow-right-long"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </section>

    {{-- Carousel End --}}

    {{-- about content --}}

    @if ($abouts)
        <!-- About Section Start -->
        <section class="about-section section-padding fix bg-cover" id="about">
            <div class="container">
                <div class="about-wrapper-2">
                    <div class="row">
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".4s">
                            <!-- konten about image -->
                            <div class="about-image">
                                <div class="shape-image">
                                    <img src="{{ asset('assets/img/about/shape.png') }}" alt="shape-img">
                                </div>
                                <div class="circle-shape">
                                    <img src="{{ asset('assets/img/about/circle.png') }}" alt="shape-img">
                                </div>
                                <img src="{{ asset('storage/' . $abouts->background_image) }}" alt="about-img">
                                <div class="video-box">
                                    <a href="{{ $abouts->video_url }}" class="video-btn ripple video-popup">
                                        <i class="fa-solid fa-play"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4 mt-lg-0">
                            <!-- konten about content -->
                            <div class="about-content">
                                <div class="section-title">
                                    <span class="wow fadeInUp">ABOUT</span>
                                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                        {{ $abouts->title }}
                                    </h2>
                                </div>
                                <p class="mt-3 mt-md-0 wow fadeInUp" data-wow-delay=".5s">
                                    {!! Str::words(strip_tags($abouts->body), 10, '...') !!}
                                </p>

                                <div class="icon-area wow fadeInUp" data-wow-delay=".7s">
                                    <ul class="list">
                                        <li>
                                            <i class='bx bx-envelope bx-tada'></i>
                                            {{ $abouts->contact_email }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ $abouts->instagram_url }}" target="_blank"><i
                                                    class='bx bxl-instagram bx-tada'></i>
                                                hmpinformatika_upy</a>
                                        </li>
                                        <li>
                                            <a href="{{ $abouts->youtube_url }}" target="_blank"><i
                                                    class='bx bxl-youtube bx-tada'></i>
                                                HMP INFORMATIKA UPY</a>
                                        </li>
                                        <li>
                                            <a href="{{ $abouts->tiktok_url }}" target="_blank"><i
                                                    class='bx bxl-tiktok bx-tada'></i>
                                                hmpinformatikaupy</a>
                                        </li>
                                        <li>
                                            <i class='bx bxs-map bx-tada'></i>
                                            {{ $abouts->alamat }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="about-author">
                                    <div class="author-icon wow fadeInUp" data-wow-delay=".9s">
                                        <div class="about-button wow fadeInUp" data-wow-delay=".8s">
                                            <a href="/about" class="theme-btn">
                                                About Details
                                                <i class="fa-solid fa-arrow-right-long"></i>
                                            </a>
                                        </div>
                                        <div class="icon">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                        <div class="content">
                                            <span>Contact Us</span>
                                            <h5>
                                                {{ $abouts->contact_phone }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- About Section Start -->
        <section class="about-section section-padding fix bg-cover" id="about">
            <div class="container">
                <div class="about-wrapper-2">
                    <div class="row">
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay=".4s">
                            <!-- konten about image -->
                            <div class="about-image">
                                <div class="shape-image">
                                    <img src="{{ asset('assets/img/about/shape.png') }}" alt="shape-img">
                                </div>
                                <div class="circle-shape">
                                    <img src="{{ asset('assets/img/about/circle.png') }}" alt="shape-img">
                                </div>
                                <img src="{{ asset('assets/img/default-img/about-default.jpg') }}" alt="about-img">
                                <div class="video-box">
                                    <a href="https://www.youtube.com/@hmpinformatikaupy"
                                        class="video-btn ripple video-popup">
                                        <i class="fa-solid fa-play"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4 mt-lg-0">
                            <!-- konten about content -->
                            <div class="about-content">
                                <div class="section-title">
                                    <span class="wow fadeInUp">ABOUT HMPI UPY</span>
                                    <h2 class="wow fadeInUp" data-wow-delay=".3s">
                                        Lorem, ipsum.
                                    </h2>
                                </div>
                                <p class="mt-3 mt-md-0 wow fadeInUp" data-wow-delay=".5s">
                                    Lorem ipsum dolor sit amet consectetur.
                                </p>

                                <div class="icon-area wow fadeInUp" data-wow-delay=".7s">
                                    <ul class="list">
                                        <li>
                                            <i class='bx bx-envelope bx-tada'></i>
                                            hmpi@gmail.com
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com/hmpinformatika_upy?igsh=MTZjdzg3YWp0ZjhmeA=="
                                                target="_blank"><i class='bx bxl-instagram bx-tada'></i>
                                                hmpinformatika_upy</a>
                                        </li>
                                        <li>
                                            <a href="https://www.youtube.com/@hmpinformatikaupy" target="_blank"><i
                                                    class='bx bxl-youtube bx-tada'></i>
                                                HMP INFORMATIKA UPY</a>
                                        </li>
                                        <li>
                                            <a href="https://www.tiktok.com/@hmpinformatikaupy1?_t=ZS-8vMXZWIPdBf&_r=1"
                                                target="_blank"><i class='bx bxl-tiktok bx-tada'></i>
                                                hmpinformatikaupy</a>
                                        </li>
                                        <li>
                                            <i class='bx bxs-map bx-tada'></i>
                                            Lorem ipsum dolor sit amet.
                                        </li>
                                    </ul>
                                </div>
                                <div class="about-author">
                                    <div class="author-icon wow fadeInUp" data-wow-delay=".9s">
                                        <div class="about-button wow fadeInUp" data-wow-delay=".8s">
                                            <a href="/about" class="theme-btn">
                                                About Details
                                                <i class="fa-solid fa-arrow-right-long"></i>
                                            </a>
                                        </div>
                                        <div class="icon">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                        <div class="content">
                                            <span>Contact Us</span>
                                            <h5>
                                                0856983534535
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


    {{-- about end --}}

    {{-- Proker Content --}}
    @if ($proker)
        <section class="project-section-3 section-padding pb-0 fix bg-cover"
            style="background-image: url('{{ asset('storage/' . $proker->background_image) }}');" id="activity">
            <div class="container">
                <div class="section-title-area">
                    <div class="section-title">
                        <h2 class="text-white"> Work Programs </h2>
                    </div>
                    <a href="/workPrograms" class="theme-btn wow fadeInUp" data-wow-delay=".5s">
                        All Work Programs
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>
                <div class="project-wrapper style-2">
                    <div class="swiper project-slider-3">
                        <div class="swiper-wrapper">
                            @if ($events->isNotEmpty())
                                @foreach ($events as $item)
                                    <div class="swiper-slide">
                                        <div class="project-items style-2">
                                            <div class="project-image">
                                                <img style="height: 400px;"
                                                    src="{{ asset('storage/' . $item->foto) }}" alt="project-img">
                                                <div class="project-content">
                                                    <h3 class="text-dark">{{ $item->judul }}</h3>
                                                    <p>{{ $item->divisi->nama_divisi }}</p>
                                                    <a href="/programDetail/{{ $item->judul }}"
                                                        class="arrow-icon-2">
                                                        <i class="fa-solid fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="swiper-slide">
                                    <div class="project-items style-2">
                                        <div class="project-image">
                                            <img src="{{ asset('assets/img/default-img/event-default.jpg') }}"
                                                alt="default-project-img">
                                            <div class="project-content">
                                                <p>Events</p>
                                                <p>Coming Soon</p>
                                                <a href="#" class="arrow-icon-2">
                                                    <i class="fa-solid fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="project-section-3 section-padding pb-0 fix bg-cover"
            style="background-image: url('{{ asset('assets/img/default-img/proker-default.jpg') }}')" id="activity">
            <div class="container">
                <div class="section-title-area">
                    <div class="section-title">
                        <span class="text-white">Program Kerja</span>
                        <h2 class="text-white"> HMPI UPY </h2>
                    </div>
                    <a href="/workPrograms" class="theme-btn wow fadeInUp" data-wow-delay=".5s">
                        All Work Programs
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>
                <div class="project-wrapper style-2">
                    <div class="swiper project-slider-3">
                        <div class="swiper-wrapper">
                            @if ($events->isNotEmpty())
                                @foreach ($events as $item)
                                    <div class="swiper-slide">
                                        <div class="project-items style-2">
                                            <div class="project-image">
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="project-img">
                                                <div class="project-content">
                                                    <p>{{ $item->judul }}</p>
                                                    <p>{{ $item->divisi->nama_divisi }}</p>
                                                    <a href="/programDetail/{{ $item->judul }}"
                                                        class="arrow-icon-2">
                                                        <i class="fa-solid fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="swiper-slide">
                                    <div class="project-items style-2">
                                        <div class="project-image">
                                            <img src="{{ asset('assets/img/default-img/event-default.jpg') }}"
                                                alt="default-project-img">
                                            <div class="project-content">
                                                <p>Events</p>
                                                <p>Coming Soon</p>
                                                <a href="#" class="arrow-icon-2">
                                                    <i class="fa-solid fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Proker Content End --}}

    {{-- Member Content --}}
    @if ($members->isNotEmpty())

        <!--<< Team Section Start >>-->
        <section class="team-section-4 fix section-padding" id="teams">
            <div class="container">
                <div class="section-title-area">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".3s">
                            Divisions and Teams
                        </h2>
                    </div>
                    <a href="/teams" class="theme-btn wow fadeInUp mb-5" data-wow-delay=".5s">
                        All Member
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>
                <div class="swiper team-slider">
                    <div class="swiper-wrapper">
                        @foreach ($members as $item)
                            <div class="swiper-slide">
                                <div class="single-team-items mt-0">
                                    <div class="team-image">
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="team-img">
                                        <div class="social-profile">
                                            <ul>
                                                <li><a href="{{ $item->link_ig }}"><i
                                                            class='bx bxl-instagram bx-tada'></i></a>
                                                </li>

                                            </ul>
                                            <span class="plus-btn"><i class="fas fa-share-alt"></i></span>
                                        </div>
                                    </div>
                                    <div class="team-content text-center">
                                        <h3 class="text-white">
                                            {{ $item->nama }}
                                        </h3>
                                        <p>{{ $item->division->nama_divisi }}</p>
                                        <p>{{ $item->jabatan }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-dot-2">
                        <div class="dot-2"></div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <!--<< Team Section Start >>-->
        <section class="team-section-4 fix section-padding" id="teams">
            <div class="container">
                <div class="section-title-area">
                    <div class="section-title">
                        <span class="wow fadeInUp">Divisions and Teams</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".3s">
                            HMPI <br> Universitas PGRI Yogyakarta
                        </h2>
                    </div>
                    <a href="/teams" class="theme-btn wow fadeInUp mb-5" data-wow-delay=".5s">
                        All Member
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>
                <div class="swiper team-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="single-team-items mt-0">
                                <div class="team-image">
                                    <img src="{{ asset('assets/img/default-img/profile-default.jpg') }}"
                                        alt="team-img">
                                    <div class="social-profile">
                                        <ul>
                                            <li><a href="#"><i class='bx bxl-instagram bx-tada'></i></a>
                                            </li>

                                        </ul>
                                        <span class="plus-btn"><i class="fas fa-share-alt"></i></span>
                                    </div>
                                </div>
                                <div class="team-content text-center">
                                    <h3 class="text-white">
                                        No Name
                                    </h3>
                                    <p>coming soon</p>
                                    <p>coming soon</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-dot-2">
                        <div class="dot-2"></div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Member Content End --}}
    {{-- Article Content --}}
    @if ($articles->isNotEmpty())
        <!-- News Section Start -->
        <section class="news-section-3 fix section-padding" id="articles">
            <div class="container">
                <div class="section-title-area">
                    <div class="section-title">
                        <span class="wow fadeInUp">Latest Blog</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".3s">
                            Checkout Our Latest <br> News & Articles
                        </h2>
                    </div>
                    <div class="array-button">
                        <button class="array-prev"><i class="fal fa-arrow-right"></i></button>
                        <button class="array-next"><i class="fal fa-arrow-left"></i></button>
                    </div>
                </div>
                <div class="swiper news-slider">
                    <div class="swiper-wrapper">
                        @foreach ($articles as $article)
                            <div class="swiper-slide">
                                <div class="news-card-items style-2">
                                    <div class="news-image">
                                        <img src="{{ asset('storage/' . $article->image) }}" alt="news-img">
                                        <div class="post-date">
                                            <h3>
                                                {{ $article->created_at->translatedFormat('d') }} <br>
                                                <span>{{ Str::limit($article->created_at->translatedFormat('F'), 3, '') }}</span>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="news-content">
                                        <ul>
                                            @if ($article->author)
                                                <li>
                                                    <a href="/posts?author={{ $article->author->name }}">
                                                        <i class="fa-regular fa-user"></i>
                                                        By {{ $article->author->name }}
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <i class="fa-regular fa-user"></i> By Unknown
                                                </li>
                                            @endif
                                            @if (isset($article->category))
                                                <li>
                                                    <a href="/posts?category={{ $article->category->slug }}">
                                                        <i class="fa-solid fa-tag"></i>
                                                        {{ $article->category->name }}
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <i class="fa-solid fa-tag"></i> tidak ada category
                                                </li>
                                            @endif
                                        </ul>
                                        <h3>
                                            <a href="/postDetail/{{ $article->slug }}">{{ $article->judul }}</a>
                                        </h3>
                                        <a href="/postDetail/{{ $article->slug }}" class="theme-btn-2 mt-3">
                                            read More
                                            <i class="fa-solid fa-arrow-right-long"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="/posts" class="theme-btn wow fadeInUp" data-wow-delay=".5s">
                        Show More..
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>

            </div>
        </section>
    @else
        <!-- News Section Start -->
        <section class="news-section-3 fix section-padding" id="articles">
            <div class="container">
                <div class="section-title-area">
                    <div class="section-title">
                        <span class="wow fadeInUp">Latest Blog</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".3s">
                            Checkout Our Latest <br> News & Articles
                        </h2>
                    </div>
                    <div class="array-button">
                        <button class="array-prev"><i class="fal fa-arrow-right"></i></button>
                        <button class="array-next"><i class="fal fa-arrow-left"></i></button>
                    </div>
                </div>
                <div class="swiper news-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="news-card-items style-2">
                                <div class="news-image">
                                    <img src="{{ asset('assets/img/default-img/post-default.jpg') }}" alt="news-img">
                                    <div class="post-date">
                                        <h3>
                                            Soon
                                        </h3>
                                    </div>
                                </div>
                                <div class="news-content">
                                    <ul>
                                        <li>
                                            <a href="#"><i class="fa-regular fa-user"></i>
                                                By Post</a>
                                        </li>
                                        <li>
                                            <i class="fa-solid fa-tag"></i> tidak ada category
                                        </li>
                                    </ul>
                                    <h3>
                                        <a href="#">Soon</a>
                                    </h3>
                                    <a href="#" class="theme-btn-2 mt-3">
                                        read More
                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="/posts" class="theme-btn wow fadeInUp" data-wow-delay=".5s">
                        Show More..
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>

            </div>
        </section>
    @endif

    {{-- Article Content End --}}
</x-Landingpage.layout>
