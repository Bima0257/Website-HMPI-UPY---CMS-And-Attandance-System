<x-Dashboard.main-layout title="{{ $title }}">
    <x-Landingpage.layoutShowContent>
        <!--<< Team Section Start >>-->
        <section class="team-section-4 section-padding">
            <div class="container position-relative">
                <div class="position-absolute mb-5" style="z-index: 10;">
                    <a href="/dashboard/dataMemberSections" class="btn btn-primary shadow-sm text-white">
                        <i class='bx bx-arrow-back me-2'></i>Back
                    </a>
                </div>

                <div class="row g-4">
                    <h2 class="text-center">{{ $teams->divisi }}</h2>
                    <div class="row g-4 mb-5">
                        <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="team-card-items mt-0">
                                <div class="team-image">
                                    <img src="{{ asset('storage/' . $teams->foto) }}" alt="team-img">
                                    <div class="social-profile">
                                        <span class="plus-btn"><i class="fas fa-share-alt"></i></span>
                                        <ul>
                                            <li><a href="#"><i class='bx bxl-instagram bx-tada'></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="team-content text-center">
                                    <h3>
                                        <a href="#">{{ $teams->nama }}</a>
                                    </h3>
                                    <p>{{ $teams->divisi }}</p>
                                    <p>{{ $teams->jabatan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </x-Landingpage.layoutShowContent>
</x-Dashboard.main-layout>
