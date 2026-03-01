@if ($members->isNotEmpty())

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
                    @foreach ($members as $item)
                        <div class="swiper-slide">
                            <div class="single-team-items mt-0">
                                <div class="team-image">
                                    <img src="{{ asset('storage/' . $item->foto) }}"
                                        style="width: 300px; height: 300px; object-fit: cover" alt="team-img">
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
                                        style="width: 300px; height: 300px; object-fit: cover" alt="team-img">
                                    <div class="social-profile">
                                        <ul>
                                            <li><a href="#"><i
                                                        class='bx bxl-instagram bx-tada'></i></a>
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
