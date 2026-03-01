<x-Dashboard.main-layout title="{{ $title }}">
    <x-Landingpage.layoutShowContent>
        <!-- Tombol Back di atas section -->
        <div class="container position-relative mt-3 mb-3">
            <a href="/dashboard/homeSections" class="btn btn-primary shadow-sm text-white"
                style="z-index: 10; position: relative;">
                <i class='bx bx-arrow-back me-2'></i>Back
            </a>
        </div>
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
                    <div class="swiper-slide">
                        <div class="slider-image bg-cover"
                            style="background-image: url('{{ asset('storage/' . $carousel->background_image) }}'); width: 1920px; height: 900px; object-fit: cover;">
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
                                            <a href="#" data-animation="slideInRight" data-duration="2s"
                                                data-delay=".9s" class="theme-btn hover-white">
                                                Explore More
                                                <i class="fa-solid fa-arrow-right-long"></i>
                                            </a>
                                            <a href="#" data-animation="slideInRight" data-duration="2s"
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
                </div>
            </div>
        </section>
    </x-Landingpage.layoutShowContent>
</x-Dashboard.main-layout>
