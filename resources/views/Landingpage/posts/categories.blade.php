<x-Landingpage.layout title="{{ $title }}">

    @if ($backgrounds)
        <!--<< Breadcrumb Section Start >>-->
        <div class="breadcrumb-wrapper bg-cover"
            style="background-image: url('{{ asset('storage/' . $backgrounds->category) }}');">
            <div class="border-shape">
                <img src="{{ asset('assets/img/element.png') }}" alt="shape-img">
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/img/line-element.png') }}" alt="shape-img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">Categories</h1>
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                        </li>
                        <li>
                            Categories
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <!--<< Breadcrumb Section Start >>-->
        <div class="breadcrumb-wrapper bg-cover"
            style="background-image: url('{{ asset('assets/img/default-img/post-default.jpg') }}');">
            <div class="border-shape">
                <img src="{{ asset('assets/img/element.png') }}" alt="shape-img">
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/img/line-element.png') }}" alt="shape-img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">Categories</h1>
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <a href="index.html">
                                Home
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                        </li>
                        <li>
                            Categories
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif


    <!-- Project Section Start -->
    <section class="project-section section-padding fix">
        <div class="container">
            @if ($categories->isNotEmpty())
                <div class="row g-4 mb-5">
                    @foreach ($categories as $item)
                        <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="project-items">
                                <div class="project-image">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="project-img">
                                    <a href="/posts?category={{ $item->slug }}">
                                        <div class="project-content">
                                            <h4>
                                                <p>{{ $item->name }}</p>
                                            </h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- pagination start --}}
                @if ($categories->lastPage() > 1)
                    <div class="page-nav-wrap pt-5 text-center wow fadeInUp" data-wow-delay=".3s">
                        <ul>
                            <li>
                                <a class="page-numbers" href="{{ $categories->previousPageUrl() }}"
                                    {{ $categories->onFirstPage() ? 'style=visibility:hidden' : '' }}>
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $categories->lastPage(); $i++)
                                <li>
                                    <a class="page-numbers {{ $i == $categories->currentPage() ? 'active bg-primary text-white' : '' }}"
                                        href="{{ $categories->url($i) }}">
                                        {{ sprintf('%02d', $i) }}
                                    </a>
                                </li>
                            @endfor
                            <li>
                                <a class="page-numbers" href="{{ $categories->nextPageUrl() }}"
                                    {{ $categories->currentPage() == $categories->lastPage() ? 'style=visibility:hidden' : '' }}>
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada Categories yang tersedia</h5>
                    <p class="text-secondary">Silakan tambahkan atau cek Categories terlebih dahulu.</p>
                </div>
            @endif

        </div>
    </section>
    <!-- Project Section End -->

</x-Landingpage.layout>
