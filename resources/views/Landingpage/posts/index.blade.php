<x-Landingpage.layout title="{{ $title }}">

    @if ($backgrounds)
        <!--<< Breadcrumb Section Start >>-->
        <div class="breadcrumb-wrapper bg-cover"
            style="background-image: url('{{ asset('storage/' . $backgrounds->all_articles) }}');">
            <div class="border-shape">
                <img src="{{ asset('assets/img/element.png') }}" alt="shape-img">
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/img/line-element.png') }}" alt="shape-img">
            </div>
            <div class="container">
                <div class="page-heading">
                    @if (isset($category))
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">
                            {{ $category->name ?? 'Kategori tidak ditemukan' }}</h1>
                    @elseif (isset($author))
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ $author->name ?? 'Author tidak ditemukan' }}
                        </h1>
                    @else
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">ALL ARTICLES & NEWS</h1>
                    @endif
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <a href="/">
                                Home
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                        </li>
                        @if (isset($category))
                            <li>
                                <a href="/categories">
                                    Kategori
                                </a>
                            </li>
                            <li>
                                <i class="fas fa-chevron-right"></i>
                            </li>
                            <li>
                                {{ $category->name }}
                            </li>
                        @elseif (isset($author))
                            <li>
                                <a href="/posts">
                                    Post
                                </a>
                            </li>
                            <li>
                                <a>
                                    Author
                                </a>
                            </li>
                        @else
                            <li>
                                all articles & news
                            </li>
                        @endif
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
                    @if (isset($category))
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ $category->name }}</h1>
                    @elseif (isset($author))
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ $author->name }}</h1>
                    @else
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">ALL ARTICLES & NEWS</h1>
                    @endif
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <a href="/">
                                Home
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                        </li>
                        @if (isset($category))
                            <li>
                                <a href="/categories">
                                    Kategori
                                </a>
                            </li>
                            <li>
                                <i class="fas fa-chevron-right"></i>
                            </li>
                            <li>
                                {{ $category->name }}
                            </li>
                        @elseif (isset($author))
                            <li>
                                <a href="/posts">
                                    Post
                                </a>
                            </li>
                            <li>
                                <a>
                                    Author
                                </a>
                            </li>
                        @else
                            <li>
                                all articles & news
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    @endif


    <!-- News Section Start -->
    <section class="news-section-4 fix section-padding">

        <div class="container">
            @if (request('category'))
                @if ($posts->isNotEmpty())
                    <div class="section-title text-center mb-5">
                        <h2 class="wow fadeInUp" data-wow-delay=".3s">
                            Artikel Kategori: {{ $posts->first()->category->name ?? 'Kategori tidak ditemukan!' }}
                        </h2>
                    </div>
                @endif
            @elseif (request('author'))
                @if ($posts->isNotEmpty())
                    <div class="section-title text-center mb-5">
                        <h2 class="wow fadeInUp" data-wow-delay=".3s">
                            Artikel Post By: {{ $posts->first()->author->name ?? 'Unknown' }}
                        </h2>
                    </div>
                @endif
            @endif



            <div class="container-fluid py-3 mb-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form action="/posts" method="get" class="d-flex align-items-center">
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif

                            @if (request('author'))
                                <input type="hidden" name="author" value="{{ request('author') }}">
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

            @if ($posts->isNotEmpty())
                <div class="row g-4">
                    @forelse ($posts as $post)
                        <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                            <div class="news-card-items style-2 mt-0 pb-0">
                                <div class="news-image">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="news-img">
                                    <div class="post-date">
                                        <h3>
                                            17 <br>
                                            <span>Feb</span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="news-content">
                                    <ul>
                                        <li>
                                            @if ($post->author)
                                                <a href="/posts?author={{ $post->author->name }}">
                                                    <i class="fa-regular fa-user"></i>
                                                    By {{ $post->author->name }}
                                                </a>
                                            @else
                                                <span>
                                                    <i class="fa-regular fa-user"></i>
                                                    By Unknown
                                                </span>
                                            @endif
                                        </li>
                                        @if (isset($post->category))
                                            <li>
                                                <a href="/posts?category={{ $post->category->slug }}">
                                                    <i class="fa-solid fa-tag"></i>
                                                    {{ $post->category->name }}
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <i class="fa-solid fa-tag"></i> tidak ada category
                                            </li>
                                        @endif
                                    </ul>
                                    <h3>
                                        <a href="/postDetail/{{ $post->slug }}">{{ $post->judul }}</a>
                                    </h3>
                                    <a href="/postDetail/{{ $post->slug }}" class="theme-btn-2 mt-3">
                                        read More
                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-warning fw-bold" role="alert">
                            <i class='bx bx-error'></i> Article Not Found !!
                            <div class="d-flex flex-column align-items-center mt-3">
                                <a href="/posts" class="btn btn-outline-primary">Back to Post</a>
                            </div>
                        </div>
                    @endforelse
                </div>
                @if ($posts->lastPage() > 1)
                    <div class="page-nav-wrap pt-5 text-center wow fadeInUp" data-wow-delay=".3s">
                        <ul>
                            <li>
                                <a class="page-numbers" href="{{ $posts->previousPageUrl() }}"
                                    {{ $posts->onFirstPage() ? 'style=visibility:hidden' : '' }}>
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                <li>
                                    <a class="page-numbers {{ $i == $posts->currentPage() ? 'active bg-primary text-white' : '' }}"
                                        href="{{ $posts->url($i) }}">
                                        {{ sprintf('%02d', $i) }}
                                    </a>
                                </li>
                            @endfor
                            <li>
                                <a class="page-numbers" href="{{ $posts->nextPageUrl() }}"
                                    {{ $posts->currentPage() == $posts->lastPage() ? 'style=visibility:hidden' : '' }}>
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada Artikel yang tersedia</h5>
                    <p class="text-secondary">Silakan tambahkan atau cek Artikel terlebih dahulu.</p>
                </div>
            @endif

        </div>
    </section>

</x-Landingpage.layout>
