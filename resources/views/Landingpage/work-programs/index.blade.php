<x-Landingpage.layout title="{{ $title }}">
    @if ($backgrounds)
        <!--<< Breadcrumb Section Start >>-->
        <div class="breadcrumb-wrapper bg-cover"
            style="background-image: url('{{ asset('storage/' . $backgrounds->all_programs) }}');">
            <div class="border-shape">
                <img src="{{ asset('assets/img/element.png') }}" alt="shape-img">
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/img/line-element.png') }}" alt="shape-img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">ALL PROGRAMS</h1>
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
                            All Programs
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <!--<< Breadcrumb Section Start >>-->
        <div class="breadcrumb-wrapper bg-cover"
            style="background-image: url('{{ asset('assets/img/default-img/workPrograms-default-bg.jpg') }}');">
            <div class="border-shape">
                <img src="{{ asset('assets/img/element.png') }}" alt="shape-imgS">
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/img/line-element.png') }}" alt="shape-img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">ALL PROGRAMS</h1>
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
                            All Programs
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif


    <!-- Project Section Start -->
    <section class="project-section section-padding fix">
        <div class="container">

            <div class="container-fluid py-3 mb-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form action="/workPrograms" method="get" class="d-flex align-items-center">
                            @if (request('divisi'))
                                <input type="hidden" name="divisi" value="{{ request('divisi') }}">
                            @endif
                            <div class="input-group">
                                <input type="search" name="search" id="search" class="form-control"
                                    placeholder="Search" aria-label="Search" aria-describedby="search-button"
                                    autocomplete="off">

                                <button type="submit"
                                    class="btn btn-primary d-flex align-items-center justify-content-center"
                                    id="search-button">
                                    <i class='bx bx-search'></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @forelse ($events as $divisi => $items)
                <h2 class="text-center my-4">{{ $divisi }}</h2>
                <div class="row g-4 mb-5">
                    @foreach ($items as $item)
                        <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="project-items">
                                <div class="project-image">
                                    <img src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('assets/img/default-img/no-image.jpg') }}"
                                        alt="project-img">
                                    <div class="project-content">
                                        @if ($item->divisi)
                                            <a href="/workPrograms/{{ $item->divisi->nama_divisi }}">
                                                <p>{{ $item->divisi->nama_divisi }}</p>
                                            </a>
                                        @else
                                            <p class="text-muted">Divisi tidak tersedia</p>
                                        @endif
                                        <a href="/programDetail/{{ urlencode($item->judul) }}">
                                            <h4>{{ $item->judul }}</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if (request('search'))
                        <div class="d-flex flex-column align-items-center mt-3">
                            <a href="/workPrograms" class="btn btn-outline-primary">Back to All Programs</a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center text-warning fw-bold" role="alert">
                    <i class='bx bx-error'></i> Event Not Found !!
                    <div class="d-flex flex-column align-items-center mt-3">
                        <a href="/workPrograms" class="btn btn-outline-primary">Back to All Programs</a>
                    </div>
                </div>
            @endforelse

        </div>
    </section>
    <!-- Project Section End -->

</x-Landingpage.layout>
