<x-Landingpage.layout title="{{ $title }}">
    @if ($backgrounds)
        <!--<< Breadcrumb Section Start >>-->
        <div class="breadcrumb-wrapper bg-cover"
            style="background-image: url('{{ asset('storage/' . $backgrounds->our_teams) }}');">
            <div class="border-shape">
                <img src="{{ asset('assets/img/element.png') }}" alt="shape-img">
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/img/line-element.png') }}" alt="shape-img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">OUR TEAMS</h1>
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
                            Our Team
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <!--<< Breadcrumb Section Start >>-->
        <div class="breadcrumb-wrapper bg-cover"
            style="background-image: url('{{ asset('assets/img/default-img/teams-default.jpg') }}');">
            <div class="border-shape">
                <img src="{{ asset('assets/img/element.png') }}" alt="shape-img">
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/img/line-element.png') }}" alt="shape-img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">OUR TEAMS</h1>
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
                            Our Team
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif


    <!--<< Team Section Start >>-->
    <section class="team-section-4 section-padding">
        <div class="container">

            <div class="container-fluid py-3 mb-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form action="/teams" method="get" class="d-flex align-items-center">
                            @if (request('divisi'))
                                <input type="hidden" name="divisi" value="{{ request('divisi') }}" id="divisi">
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

            <div class="row g-4">
                @forelse ($teams as $divisi => $members)
                    <h2 class="text-center">{{ $divisi }}</h2>
                    <div class="row g-4 mb-5">
                        @foreach ($members as $team)
                            <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                                <div class="team-card-items mt-0">
                                    <div class="team-image">
                                        <img src="{{ asset('storage/' . $team->foto) }}"
                                            style="width: 410px; height: 512px; object-fit: cover;" alt="team-img">
                                        <div class="social-profile">
                                            <span class="plus-btn"><i class="fas fa-share-alt"></i></span>
                                            <ul>
                                                <li><a href="{{ $team->link_ig }}" target="_blank"><i class='bx bxl-instagram bx-tada'></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="team-content text-center">
                                        <h3>
                                            {{ $team->nama }}
                                        </h3>
                                        <p>{{ $team->divisi }}</p>
                                        <p>{{ $team->jabatan }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if (request('search'))
                            <div class="d-flex flex-column align-items-center mt-3">
                                <a href="/teams" class="btn btn-outline-primary">Back to All Members</a>
                            </div>
                        @endif

                    @empty
                        <div class="text-center text-warning fw-bold" role="alert">
                            <i class='bx bx-error'></i> Data Members Not Found !!
                            <div class="d-flex flex-column align-items-center mt-3">
                                <a href="/teams" class="btn btn-outline-primary">Back to All Members</a>
                            </div>
                        </div>
                @endforelse
            </div>
        </div>
    </section>
</x-Landingpage.layout>
