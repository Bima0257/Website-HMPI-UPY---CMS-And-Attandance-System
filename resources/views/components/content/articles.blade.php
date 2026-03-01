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
                                    <img src="{{ asset('storage/' . $article->image) }}"
                                        style="height: 240px; width: 370px; object-fit: cover;" alt="news-img">
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
                                <img src="{{ asset('assets/img/default-img/post-default.jpg') }}"
                                    style="height: 240px; width: 370px; object-fit: cover;" alt="news-img">
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
