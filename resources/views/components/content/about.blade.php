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
                            <img src="{{ asset('storage/' . $abouts->background_image) }}"
                                style="width: 609px; height: 561px; object-fit: cover;" alt="about-img">
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
                                <span class="wow fadeInUp">ABOUT HMPI UPY</span>
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
                            <img src="{{ asset('assets/img/default-img/about-default.jpg') }}"
                                style="width: 609px; height: 561px; object-fit: cover;" alt="about-img">
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
