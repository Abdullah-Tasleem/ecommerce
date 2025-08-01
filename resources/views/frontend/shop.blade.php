@extends('frontend.layout.main')
@section('section')
    </style>
    <!-- Body main wrapper start -->
    <main>

        <!-- Breadcrumb area start  -->
        <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
            <div class="breadcrumb__thumb" data-background="{{ asset('assets/imgs/bg/breadcrumb-bg-furniture.jpg') }}"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-12">
                        <div class="breadcrumb__wrapper text-center">
                            <h2 class="breadcrumb__title">Products</h2>
                            <div class="breadcrumb__menu">
                                <nav>
                                    <ul>
                                        <li><span><a href="{{ route('home') }}">Home</a></span></li>
                                        <li><span>Products</span></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb area start  -->

        <!-- Product area start -->
        <section class="bd-product__area section-space">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                        <div class="bd-product__result mb-30">
                            <h4>{{ $products->count() }} Item{{ $products->count() > 1 ? 's' : '' }} On List</h4>
                        </div>
                    </div>
                    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-6">
                        <div
                            class="product__filter-wrapper d-flex flex-wrap gap-3 align-items-center justify-content-md-end mb-30">
                            {{-- <div class="bd-product__filter-btn">
                                <button type="button"><i class="fa-solid fa-list"></i> Filter</button>
                            </div> --}}
                            <div class="product__filter-count d-flex align-items-center">
                                <form method="GET" id="productFilterForm">
                                    <div class="btn-dropdown__options">
                                        <select name="show" class="me-4"
                                            onchange="document.getElementById('productFilterForm').submit()"
                                            class="form-select">
                                            <option value="8" {{ request('show') == 8 ? 'selected' : '' }}>Show 8
                                            </option>
                                            <option value="16" {{ request('show') == 16 ? 'selected' : '' }}>Show 16
                                            </option>
                                            <option value="24" {{ request('show') == 24 ? 'selected' : '' }}>Show 24
                                            </option>
                                            <option value="32" {{ request('show') == 32 ? 'selected' : '' }}>Show 32
                                            </option>
                                        </select>
                                    </div>
                                </form>

                                <div class="bd-product__filter-style nav nav-tabs" role="tablist">
                                    <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-grid" type="button" role="tab" aria-selected="false"><i
                                            class="fa-solid fa-grid"></i></button>
                                    <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-list" type="button" role="tab" aria-selected="true"><i
                                            class="fa-solid fa-bars"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="product__filter-tab">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade active show" id="nav-grid" role="tabpanel"
                                    aria-labelledby="nav-grid-tab">
                                    <div class="row g-5">
                                        @foreach ($products as $item)
                                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                                <div class="product-item">
                                                    @if ($item->off)
                                                        <div class="product-badge">
                                                            <span class="product-trending">{{ $item->off }}% off</span>
                                                        </div>
                                                    @endif
                                                    <div class="product-thumb">
                                                        <a href="{{ route('details', [$item->id, $item->slug]) }}">
                                                            @php
                                                                // Filter out any empty arrays
                                                                $validImages = collect($item->images)
                                                                    ->filter(function ($img) {
                                                                        return is_string($img) && !empty($img);
                                                                    })
                                                                    ->values(); // reindex the array

                                                                $firstImage = $validImages->first();
                                                            @endphp

                                                            @if ($firstImage)
                                                                <img src="{{ asset('storage/' . ltrim($firstImage, '/')) }}"
                                                                    width="60" class="me-1">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="product-action-item">
                                                        <form action="{{ route('cart.add', $item->id) }}" method="POST"
                                                            style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="product-action-btn">
                                                                <svg width="20" height="22" viewBox="0 0 20 22"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M13.0768 10.1416C13.0768 11.9228 11.648 13.3666 9.88542 13.3666C8.1228 13.3666 6.69401 11.9228 6.69401 10.1416M1.375 5.84163H18.3958M1.375 5.84163V12.2916C1.375 19.1359 2.57494 20.3541 9.88542 20.3541C17.1959 20.3541 18.3958 19.1359 18.3958 12.2916V5.84163M1.375 5.84163L2.91454 2.73011C3.27495 2.00173 4.01165 1.54163 4.81754 1.54163H14.9533C15.7592 1.54163 16.4959 2.00173 16.8563 2.73011L18.3958 5.84163"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                                <span class="product-tooltip">Add to Cart</span>
                                                            </button>
                                                        </form>
                                                        <button type="button" class="product-action-btn quick-view-btn"
                                                            data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#productQuickViewModal">
                                                            <svg width="26" height="18" viewBox="0 0 26 18"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M13.092 4.55026C10.5878 4.55026 8.55683 6.58125 8.55683 9.08541C8.55683 11.5896 10.5878 13.6206 13.092 13.6206C15.5961 13.6206 17.6271 11.5903 17.6271 9.08541C17.6271 6.5805 15.5969 4.55026 13.092 4.55026ZM13.092 12.1089C11.4246 12.1089 10.0338 10.7196 10.0338 9.05216C10.0338 7.38473 11.3898 6.02872 13.0572 6.02872C14.7246 6.02872 16.0807 7.38473 16.0807 9.05216C16.0807 10.7196 14.7594 12.1089 13.092 12.1089ZM25.0965 8.8768C25.0875 8.839 25.092 8.79819 25.0807 8.76115C25.0761 8.74528 25.0655 8.73621 25.0603 8.7226C25.0519 8.70144 25.0542 8.67574 25.0429 8.65533C22.8441 3.62131 18.1064 0.724854 13.0572 0.724854C8.00807 0.724854 3.17511 3.61677 0.975559 8.65079C0.966488 8.67196 0.968 8.69388 0.959686 8.71806C0.954395 8.73318 0.943812 8.74074 0.938521 8.7551C0.927184 8.7929 0.931719 8.83296 0.92416 8.8715C0.910555 8.93953 0.897705 9.00605 0.897705 9.07483C0.897705 9.14361 0.910555 9.20862 0.92416 9.2774C0.931719 9.31519 0.926428 9.35677 0.938521 9.39229C0.943057 9.40968 0.954395 9.41648 0.959686 9.4316C0.967244 9.45201 0.965732 9.4777 0.975559 9.49887C3.17511 14.5314 7.96121 17.381 13.0104 17.381C18.0595 17.381 22.8448 14.5374 25.0436 9.5034C25.055 9.48148 25.0527 9.45956 25.061 9.43538C25.0663 9.42253 25.0761 9.4127 25.0807 9.39758C25.092 9.36055 25.089 9.32049 25.0965 9.28118C25.1101 9.21315 25.1222 9.14739 25.1222 9.0771C25.1222 9.01058 25.1094 8.94482 25.0958 8.87604L25.0965 8.8768ZM13.0104 15.8692C8.72841 15.8692 4.51298 13.6123 2.44193 9.07407C4.49333 4.55177 8.76469 2.23582 13.0572 2.23582C17.349 2.23582 21.5251 4.55404 23.5773 9.07861C21.5266 13.6002 17.3036 15.8692 13.0104 15.8692Z"
                                                                    fill="white" />
                                                            </svg>
                                                            <span class="product-tooltip">Quick View</span>
                                                        </button>
                                                    </div>
                                                    <div class="product-content">
                                                        <div class="product-tag">
                                                            <span>ACCESSORIES</span>
                                                        </div>
                                                        <h4 class="product-title"><a
                                                                href="{{ route('details', [$item->id, $item->slug]) }}">{{ $item->name }}</a>
                                                        </h4>
                                                        </h4>
                                                        <div class="product-price">
                                                            @if ($item->sale_price)
                                                                <span
                                                                    class="product-old-price text-muted text-decoration-line-through">USD
                                                                    {{ $item->regular_price }}</span>
                                                                <span class="product-new-price ms-2 fw-bold">USD
                                                                    {{ $item->sale_price }}</span>
                                                            @else
                                                                <span class="product-new-price fw-bold">USD
                                                                    {{ $item->regular_price }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-list" role="tabpanel"
                                    aria-labelledby="nav-list-tab">
                                    <div class="row g-5">
                                        @foreach ($products as $item)
                                            <div class="col-xxl-12">
                                                <div class="product-item d-flex align-items-center">
                                                    <div class="product-thumb me-4 position-relative"
                                                        style="width: 300px; height: 300px; overflow: hidden; border-radius: 10px;">
                                                        <a href="{{ route('details', [$item->id, $item->slug]) }}">
                                                            @php
                                                                $validImages = collect($item->images)
                                                                    ->filter(
                                                                        fn($img) => is_string($img) && !empty($img),
                                                                    )
                                                                    ->values();
                                                                $firstImage = $validImages->first();

                                                                $price = $item->regular_price;
                                                                $sale = $item->sale_price;
                                                                $discount =
                                                                    $sale && $price && $sale < $price
                                                                        ? round((($price - $sale) / $price) * 100)
                                                                        : null;
                                                            @endphp
                                                            @if ($firstImage)
                                                                <img src="{{ asset('storage/' . ltrim($firstImage, '/')) }}"
                                                                    class="img-fluid w-100 h-100"
                                                                    style="object-fit: cover;">
                                                            @endif

                                                            @if ($discount)
                                                                <span
                                                                    class="badge bg-danger position-absolute top-0 start-0 m-1 mt-4">
                                                                    {{ $discount }}% OFF
                                                                </span>
                                                            @endif
                                                        </a>
                                                    </div>

                                                    <div class="product-content">
                                                        <h4 class="product-title mb-2">
                                                            <a
                                                                href="{{ route('details', [$item->id, $item->slug]) }}">{{ $item->name }}</a>
                                                        </h4>
                                                        <div class="product-price mb-2">
                                                            @if ($item->sale_price)
                                                                <span class="text-muted text-decoration-line-through">USD
                                                                    {{ $item->regular_price }}</span>
                                                                <span class="ms-2 fw-bold">USD
                                                                    {{ $item->sale_price }}</span>
                                                            @else
                                                                <span class="fw-bold">USD
                                                                    {{ $item->regular_price }}</span>
                                                            @endif
                                                        </div>
                                                        <form action="{{ route('cart.add', $item->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary btn-sm">Add to
                                                                Cart</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if ($products->hasPages())
                            <div class="row">
                                <div class="bd-basic__pagination mt-50 d-flex align-items-center justify-content-center">
                                    <nav>
                                        <ul>
                                            {{-- Previous Page Link --}}
                                            @if ($products->onFirstPage())
                                                <li>
                                                    <span class="current"><i class="fa-regular fa-angle-left"></i></span>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{{ $products->previousPageUrl() }}"><i
                                                            class="fa-regular fa-angle-left"></i></a>
                                                </li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                                @if ($page == $products->currentPage())
                                                    <li><span class="current">{{ $page }}</span></li>
                                                @else
                                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                                @endif
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($products->hasMorePages())
                                                <li>
                                                    <a href="{{ $products->nextPageUrl() }}"><i
                                                            class="fa-regular fa-angle-right"></i></a>
                                                </li>
                                            @else
                                                <li>
                                                    <span class="current"><i class="fa-regular fa-angle-right"></i></span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="modal fade" id="productQuickViewModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div id="quickViewContent">
                                    <!-- AJAX-loaded content will appear here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product area end -->

    </main>
    <!-- Body main wrapper end -->
@endsection

