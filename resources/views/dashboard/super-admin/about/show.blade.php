<x-Dashboard.main-layout title="{{ $title }}">
    <x-Landingpage.layoutShowContent>
        <!-- Team Section Start -->
        <!-- Tombol Back di atas section -->
        <div class="container position-relative mt-3 mb-3">
            <a href="/dashboard/about" class="btn btn-primary shadow-sm text-white"
                style="z-index: 10; position: relative;">
                <i class='bx bx-arrow-back me-2'></i>Back
            </a>
        </div>
        <section class="team-details-section fix ">
            <div class="container">
                <div class="team-details-wrapper">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-5">
                            <div class="team-details-image">
                                <img src="{{ asset('storage/' . $about->background_image) }}" alt="team-img">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="team-details-content">
                                <div class="details-info">
                                    <h3>{{ $about->title }}</h3>
                                </div>
                                <p class="mt-3">
                                    {!! $about->body !!}
                                </p>
                                <div class="social-icon">
                                    <span>Social Media:</span>
                                    <a href="{{ $about->instagram_url }}"><i class='bx bxl-instagram bx-tada'></i></a>
                                    <a href="{{ $about->tiktok_url }}"><i class='bx bxl-tiktok bx-tada'></i></a>
                                    <a href="{{ $about->youtube_url }}"><i class='bx bxl-youtube bx-tada'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-Landingpage.layoutShowContent>
</x-Dashboard.main-layout>
