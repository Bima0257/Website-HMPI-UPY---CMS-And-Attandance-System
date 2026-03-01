@if ($proker)
    <section class="project-section-3 section-padding pb-0 fix bg-cover"
        style="background-image: url('{{ asset('storage/' . $proker->background_image) }}');" id="activity">
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
                                            <img src="{{ asset('storage/' . $item->foto) }}"
                                                style=" width:465px; height:450px; object-fit:cover;" alt="project-img">
                                            <div class="project-content">
                                                <h3 class="text-dark">{{ $item->judul }}</h3>
                                                <p>{{ $item->divisi->nama_divisi }}</p>
                                                <a href="/programDetail/{{ $item->judul }}" class="arrow-icon-2">
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
                                            style=" width:465px; height:450px; object-fit:cover;"
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
        style="background-image: url('{{ asset('assets/img/default-img/proker-default.jpg') }}');" id="activity">
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
                                            <img src="{{ asset('storage/' . $item->foto) }}"
                                                style=" width:465px; height:450px; object-fit:cover;" alt="project-img">
                                            <div class="project-content">
                                                <p>{{ $item->judul }}</p>
                                                <p>{{ $item->divisi->nama_divisi }}</p>
                                                <a href="/programDetail/{{ $item->judul }}" class="arrow-icon-2">
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
                                            style=" width:465px; height:450px; object-fit:cover;"
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
