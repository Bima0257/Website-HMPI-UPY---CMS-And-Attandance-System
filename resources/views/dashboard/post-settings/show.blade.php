<x-Dashboard.main-layout title="{{ $title }}">
    <x-Landingpage.layoutShowContent>
        <!-- News Standard Section Start -->
        <section class="news-standard fix ">
            <div class="container position-relative">
                <!-- Tombol di pojok kiri atas -->
                <div class="position-absolute top-0 start-0 translate-middle-y mt-3 ms-3">
                    <a href="/dashboard/posts" class="btn btn-primary shadow-sm text-white">
                        <i class='bx bx-arrow-back me-2'></i>back
                    </a>
                </div>
                <div class="news-details-area pt-5 mt-4">
                    <div class="row g-5">
                        <div class="col-12 col-lg-8">
                            <div class="blog-post-details">
                                <div class="single-blog-post">
                                    <div class="post-featured-thumb bg-cover"
                                        style="background-image: url('{{ asset('storage/' . $post->background_image) }}'); height: 397px; width: 770px; object-fit: cover;">
                                    </div>
                                    <div class="post-content">
                                        <ul class="post-list d-flex align-items-center">
                                            <li>
                                                @if ($post->author)
                                                    <a href="/posts?author={{ $post->author->name }}">
                                                        <i class="fa-regular fa-user"></i>
                                                        By {{ $post->author->name }}
                                                    </a>
                                                @else
                                                    <span>
                                                        <i class="fa-regular fa-user"></i>
                                                        By unknown
                                                    </span>
                                                @endif
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-calendar-days"></i>
                                                {{ $post->created_at->format('d M, Y') }}
                                            </li>
                                            @if (isset($post->category))
                                                <li>
                                                    <a href="#">
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
                                        <h3>{{ $post->judul }}</h3>
                                        <p class="mb-3">
                                            {!! $post->body !!}
                                        </p>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="main-sidebar">
                                <div class="single-sidebar-widget">
                                    <div class="wid-title">
                                        <h3>Search</h3>
                                    </div>
                                    <div class="search-widget">
                                        <form action="/posts" method="get">
                                            @if (request('category'))
                                                <input type="hidden" name="category" value="{{ request('category') }}">
                                            @endif

                                            @if (request('author'))
                                                <input type="hidden" name="author" value="{{ request('author') }}">
                                            @endif
                                            <input type="search" name="search" id="search"
                                                placeholder="Search here" autocomplete="off">
                                            <button type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="single-sidebar-widget">
                                    <div class="wid-title">
                                        <h3>Categories</h3>
                                    </div>
                                    <div class="news-widget-categories">
                                        <ul>
                                            @forelse ($categories as $category)
                                                <li
                                                    class="{{ isset($post->category) && $category->id == $post->category->id ? 'active text-white' : '' }}">
                                                    <a href="#">
                                                        {{ $category->name }}
                                                        <span>({{ $category->posts_count }})</span>
                                                    </a>
                                                </li>
                                            @empty
                                                <li>
                                                    <span class="text-muted">Tidak ada kategori tersedia</span>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                <div class="single-sidebar-widget">
                                    <div class="wid-title">
                                        <h3>Recent Post</h3>
                                    </div>
                                    @foreach ($recentPosts as $item)
                                        <div class="recent-post-area">
                                            <div class="recent-items">
                                                <div class="recent-content">
                                                    <h6>
                                                        <a href="#">
                                                            {{ $item->judul }}
                                                        </a>
                                                    </h6>
                                                    <ul>
                                                        <li>
                                                            <i class="fa-solid fa-calendar-days"></i>
                                                            {{ $item->created_at->format('d M, Y') }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-Landingpage.layoutShowContent>
</x-Dashboard.main-layout>
