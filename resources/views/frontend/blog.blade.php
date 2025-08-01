@extends('frontend.layout.main')
@section('section')
    <!-- Body main wrapper start -->
    <main>
        <!-- Breadcrumb area start  -->
        <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
            <div class="breadcrumb__thumb" data-background="assets/imgs/bg/breadcrumb-bg.jpg"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-12">
                        <div class="breadcrumb__wrapper text-center">
                            <h2 class="breadcrumb__title">Blog</h2>
                            <div class="breadcrumb__menu">
                                <nav>
                                    <ul>
                                        <li><span><a href="{{ route('home') }}">Home</a></span></li>
                                        <li><span>Blog</span></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb area start  -->

        <!-- Postbox grid area start -->
        <section class="postbox__grid-area section-space">
            <div class="container">
                <div class="row g-4">
                    @foreach ($blogs as $blog)
                        <div class="col-xl-4 col-lg-6">
                            <div class="blog-item theme-bg-2"
                                style="height: 450px; display: flex; flex-direction: column; justify-content: space-between; padding-bottom: 15px;">
                                <div class="blog-thumb mb-20 w-img">
                                    <a href="{{ route('blogs.show', $blog->slug) }}">
                                        @php
                                            $images = collect($blog->images) // no json_decode
                                                ->map(fn($img) => str_replace('\\/', '/', $img))
                                                ->filter(fn($img) => is_string($img) && !empty($img))
                                                ->values();

                                            $firstImage = $images->first() ?? 'default.jpg';
                                        @endphp
                                        <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $blog->title }}"
                                            style="width:100%; height:250px; object-fit:cover;">
                                    </a>
                                </div>
                                <div class="blog-content"
                                    style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                    <div class="postbox__meta mb-15">
                                        <span><a href="#">By {{ $blog->author }}</a></span>
                                        <span>{{ \Carbon\Carbon::parse($blog->published_at)->format('d M, Y') }}</span>
                                    </div>
                                    <h4 class="blog-title">
                                        <a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a>
                                    </h4>
                                    <a class="text-btn mt-auto" href="{{ route('blogs.show', $blog->slug) }}">
                                        Read More<span><i class="fa-regular fa-angle-right"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                @if ($blogs->lastPage() > 1)
                    <div class="row">
                        <div class="col-xxl-12">
                            <div class="pagination__wrapper mt-50">
                                <div class="bd-basic__pagination d-flex align-items-center justify-content-center">
                                    <nav>
                                        <ul>
                                            {{-- Previous Page Link --}}
                                            @if ($blogs->onFirstPage())
                                                <li><span class="current"><i class="fa-regular fa-angle-left"></i></span>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{{ $blogs->previousPageUrl() }}"><i
                                                            class="fa-regular fa-angle-left"></i></a>
                                                </li>
                                            @endif

                                            {{-- Page Number Links --}}
                                            @for ($i = 1; $i <= $blogs->lastPage(); $i++)
                                                @if ($i == $blogs->currentPage())
                                                    <li><span class="current">{{ $i }}</span></li>
                                                @else
                                                    <li><a href="{{ $blogs->url($i) }}">{{ $i }}</a></li>
                                                @endif
                                            @endfor

                                            {{-- Next Page Link --}}
                                            @if ($blogs->hasMorePages())
                                                <li><a href="{{ $blogs->nextPageUrl() }}"><i
                                                            class="fa-regular fa-angle-right"></i></a></li>
                                            @else
                                                <li><span class="current"><i class="fa-regular fa-angle-right"></i></span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </section>

        <!-- Postbox grid area end -->

    </main>
    <!-- Body main wrapper end -->
@endsection
