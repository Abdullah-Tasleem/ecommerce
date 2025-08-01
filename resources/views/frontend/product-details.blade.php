@extends('frontend.layout.main')

@section('section')
    <main>
        <style>
            .star-rating {
                display: flex;
                gap: 5px;
                padding-left: 0;
                list-style: none;
            }

            .star-rating li a i {
                font-size: 24px;
                color: #ccc;
                cursor: pointer;
                transition: color 0.3s ease;
            }

            .star-rating li a i.active {
                color: #FFD700;
                /* Gold color */
            }
        </style>


        <!-- Breadcrumb area start  -->
        <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
            <div class="breadcrumb__thumb" data-background="{{ asset('assets/imgs/bg/breadcrumb-bg-furniture.jpg') }}"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-12">
                        <div class="breadcrumb__wrapper text-center">
                            <h2 class="breadcrumb__title">Product Details</h2>
                            <div class="breadcrumb__menu">
                                <nav>
                                    <ul>
                                        <li><span><a href="index.html">Home</a></span></li>
                                        <li><span>Product Details</span></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb area start  -->

        <!-- Product details area start -->
        <div class="product__details-area section-space-medium">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xxl-6 col-lg-6">
                        <div class="product__details-thumb-wrapper d-sm-flex align-items-start mr-50">
                            {{-- Thumbnail Tabs --}}
                            <div class="product__details-thumb-tab mr-20">
                                <nav>
                                    <div class="nav nav-tabs flex-nowrap flex-sm-column" id="product-image-tabs"
                                        role="tablist">
                                        @foreach ($product->images as $index => $image)
                                            @php
                                                $imagePath = is_array($image) ? $image['path'] ?? null : $image;
                                            @endphp

                                            @if ($imagePath)
                                                <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                                    id="thumb-tab-{{ $index }}" data-bs-toggle="tab"
                                                    data-bs-target="#image-tab-{{ $index }}" type="button"
                                                    role="tab" aria-controls="image-tab-{{ $index }}"
                                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="thumb"
                                                        style="width: 60px;">
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                </nav>
                            </div>

                            {{-- Main Image Display --}}
                            <div class="product__details-thumb-tab-content">
                                <div class="tab-content" id="product-image-tab-content">
                                    @foreach ($product->images as $index => $image)
                                        @php
                                            $imagePath = is_array($image) ? $image['path'] ?? null : $image;
                                        @endphp
                                        @if ($imagePath)
                                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                                id="image-tab-{{ $index }}" role="tabpanel"
                                                aria-labelledby="thumb-tab-{{ $index }}">
                                                <div class="product__details-thumb-big w-img">
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="main-image"
                                                        class="img-fluid"
                                                        style="width: 100%; height: 450px; object-fit: cover;">
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-lg-6">
                        <div class="product__details-content pr-80">
                            <div class="product__details-top d-sm-flex align-items-center mb-15">
                                <div class="product__details-tag mr-10">
                                    <a href="#">Product</a>
                                </div>
                                <div class="product__details-rating mr-10">
                                    <a href="#"><i class="fa-solid fa-star"></i></a>
                                    <a href="#"><i class="fa-solid fa-star"></i></a>
                                    <a href="#"><i class="fa-regular fa-star"></i></a>
                                </div>
                                <div class="product__details-review-count">
                                    <a href="#">{{ $product->reviews->count() }} Reviews</a>
                                </div>
                            </div>
                            <h3 class="product__details-title text-capitalize">{{ $product->name }}</h3>
                            <div class="product__details-price">
                                @if ($product->sale_price)
                                    <span class="old-price">${{ $product->regular_price }}</span>
                                    <span class="new-price"
                                        data-original-price="{{ $product->sale_price }}">${{ $product->sale_price }}</span>
                                @else
                                    <span class="new-price"
                                        data-original-price="{{ $product->regular_price }}">${{ $product->regular_price }}</span>
                                @endif
                            </div>
                            <p>{{ $product->excerpt }}</p>

                            <div class="product__details-action mb-35">
                                <div class="product__quantity">
                                    <div class="product-quantity-wrapper">
                                        <form action="#">
                                            <button class="cart-minus"><i class="fa-light fa-minus"></i></button>
                                            <input class="cart-input" type="text" value="1">
                                            <button class="cart-plus"><i class="fa-light fa-plus"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="product__add-cart">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="quantity" id="cartQuantity" value="1">
                                        {{-- This will be updated via JS --}}
                                        <button type="submit" class="fill-btn cart-btn">
                                            <span class="fill-btn-inner">
                                                <span class="fill-btn-normal">Add To Cart <i
                                                        class="fa-solid fa-basket-shopping"></i></span>
                                                <span class="fill-btn-hover">Add To Cart <i
                                                        class="fa-solid fa-basket-shopping"></i></span>
                                            </span>
                                        </button>
                                    </form>

                                </div>
                            </div>
                            <div class="product__details-meta mb-20">
                                <div class="categories">
                                    <span>Categories:</span>
                                    @foreach ($categoriesNames as $category)
                                        <a href="#">{{ $category }}</a>{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </div>

                                <div class="tag">
                                    <span>Tags:</span>
                                    @foreach ($tagNames as $tag)
                                        <a href="#">{{ $tag }}</a>{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </div>
                            </div>
                            <div class="product__details-share">
                                <span>Share:</span>
                                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-behance"></i></a>
                                <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product__details-additional-info section-space-medium-top">
                    <div class="row">
                        <div class="col-xxl-3 col-xl-4 col-lg-4">
                            <div class="product__details-more-tab mr-15">
                                <nav>
                                    <div class="nav nav-tabs flex-column " id="productmoretab" role="tablist">
                                        <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-description" type="button" role="tab"
                                            aria-controls="nav-description" aria-selected="true">Description</button>
                                        {{-- <button class="nav-link" id="nav-additional-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-additional" type="button" role="tab"
                                            aria-controls="nav-additional" aria-selected="false">Additional Information
                                        </button> --}}
                                        <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-review" type="button" role="tab"
                                            aria-controls="nav-review" aria-selected="false">Reviews
                                            ({{ $product->reviews->count() }})</button>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xxl-9 col-xl-8 col-lg-8">
                            <div class="product__details-more-tab-content">
                                <div class="tab-content" id="productmorecontent">
                                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                                        aria-labelledby="nav-description-tab">
                                        <div class="product__details-des">
                                            <p>{{ $product->description }}</p>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-additional" role="tabpanel"
                                        aria-labelledby="nav-additional-tab">
                                        <div class="product__details-info">
                                            <ul>
                                                <li>
                                                    <h4>Weight</h4>
                                                    <span>2 lbs</span>
                                                </li>
                                                <li>
                                                    <h4>Dimensions</h4>
                                                    <span>12 × 16 × 19 in</span>
                                                </li>
                                                <li>
                                                    <h4>Product</h4>
                                                    <span>Purchase this product on rag-bone.com</span>
                                                </li>
                                                <li>
                                                    <h4>Color</h4>
                                                    <span>Gray, Black</span>
                                                </li>
                                                <li>
                                                    <h4>Size</h4>
                                                    <span>S, M, L, XL</span>
                                                </li>
                                                <li>
                                                    <h4>Model</h4>
                                                    <span>Model </span>
                                                </li>
                                                <li>
                                                    <h4>Shipping</h4>
                                                    <span>Standard shipping: $5,95</span>
                                                </li>
                                                <li>
                                                    <h4>Care Info</h4>
                                                    <span>Machine Wash up to 40ºC/86ºF Gentle Cycle</span>
                                                </li>
                                                <li>
                                                    <h4>Brand</h4>
                                                    <span>Kazen</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-review" role="tabpanel"
                                        aria-labelledby="nav-review-tab">
                                        <div class="product__details-review">
                                            <h3 class="comments-title">{{ $product->reviews->count() }} reviews for
                                                “{{ $product->name }}”</h3>
                                            <div class="latest-comments mb-50">
                                                <ul>
                                                    @forelse ($product->reviews as $review)
                                                        <li>
                                                            <div class="comments-box d-flex">
                                                                <div class="comments-avatar mr-10">
                                                                    <img src="{{ asset('assets/imgs/user/user-01.png') }}"
                                                                        alt="">
                                                                </div>
                                                                <div class="comments-text">
                                                                    <div
                                                                        class="comments-top d-sm-flex align-items-start justify-content-between mb-5">
                                                                        <div class="avatar-name">
                                                                            <h5>{{ $review->user_name }}</h5>
                                                                            <div class="comments-date">
                                                                                <span>{{ $review->created_at->format('F d, Y h:i A') }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="user-rating">
                                                                            <ul>
                                                                                @for ($i = 1; $i <= 5; $i++)
                                                                                    <li>
                                                                                        <a href="#"><i
                                                                                                class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i></a>
                                                                                    </li>
                                                                                @endfor
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <p>{{ $review->review }}</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @empty
                                                        <li>
                                                            <p>No reviews yet.</p>
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </div>

                                            @auth
                                                <div class="product__details-comment section-space-medium-bottom">
                                                    <div class="comment-title mb-20">
                                                        <h3>Add a review</h3>
                                                        <p>Your email address will not be published. Required fields are marked
                                                            *</p>
                                                    </div>
                                                    <div class="comment-input-box">
                                                        <form action="{{ route('review.store') }}" method="POST">
                                                            @csrf
                                                            <div class="comment-rating mb-20">
                                                                <span>Overall ratings</span>
                                                                <ul class="star-rating">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <li>
                                                                            <a href="#"
                                                                                data-value="{{ $i }}"><i
                                                                                    class="fa fa-star"
                                                                                    id="star-{{ $i }}"></i></a>
                                                                        </li>
                                                                    @endfor
                                                                </ul>
                                                                <input type="hidden" name="rating" id="rating" required>
                                                            </div>

                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}">
                                                            <div class="row">
                                                                <div class="col-xxl-12">
                                                                    <div class="comment-input">
                                                                        <textarea name="review" placeholder="Your review" required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xxl-6">
                                                                    <div class="comment-input">
                                                                        <input type="text" name="user_name"
                                                                            placeholder="Your Name*" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xxl-6">
                                                                    <div class="comment-input">
                                                                        <input type="email" name="user_email"
                                                                            placeholder="Your Email*" required>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xxl-12">
                                                                    <div class="comment-agree d-flex align-items-center mb-25">
                                                                        <input class="z-check-input" type="checkbox"
                                                                            id="z-agree">
                                                                        <label class="z-check-label" for="z-agree">Save my
                                                                            name, email, and
                                                                            website in this browser for the next time I
                                                                            comment.</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xxl-12">
                                                                    <div class="comment-submit">
                                                                        <button type="submit" class="fill-btn">
                                                                            <span class="fill-btn-inner">
                                                                                <span class="fill-btn-normal">submit now</span>
                                                                                <span class="fill-btn-hover">submit now</span>
                                                                            </span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endauth
                                            @guest
                                                <div class="product__details-comment section-space-medium-bottom">
                                                    <div class="alert alert-warning">
                                                        Please <strong><a href="{{ route('login') }}">login</a></strong> to
                                                        add a review.
                                                    </div>
                                                </div>
                                            @endguest

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product details area end -->

    </main>
    <!-- Body main wrapper end -->
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- Auto-activate first product image tab
            const firstTab = document.querySelector('#product-image-tabs .nav-link');
            const firstPane = document.querySelector('#product-image-tab-content .tab-pane');

            if (firstTab && firstPane && !firstTab.classList.contains('active')) {
                firstTab.classList.add('active');
                firstTab.setAttribute('aria-selected', 'true');

                firstPane.classList.add('show', 'active');
            }

            // --- Star Rating Logic
            const stars = document.querySelectorAll(".star-rating li a");
            const ratingInput = document.getElementById("rating");
            let selectedRating = 0;

            stars.forEach((star, index) => {
                const icon = star.querySelector('i'); // <i class="fa fa-star">

                star.addEventListener("mouseenter", function() {
                    updateStars(index + 1, "hover");
                });

                star.addEventListener("mouseleave", function() {
                    updateStars(selectedRating, "active");
                });

                star.addEventListener("click", function(e) {
                    e.preventDefault();
                    selectedRating = index + 1;
                    ratingInput.value = selectedRating;
                    updateStars(selectedRating, "active");
                });
            });

            function updateStars(count, type) {
                stars.forEach((star, i) => {
                    const icon = star.querySelector('i');
                    icon.classList.remove("active", "hover");
                    if (i < count) {
                        icon.classList.add(type);
                    }
                });
            }
        });
    </script>
   <script>
    document.addEventListener("DOMContentLoaded", function() {
        const plusBtn = document.querySelector(".cart-plus");
        const minusBtn = document.querySelector(".cart-minus");
        const qtyInput = document.querySelector(".cart-input");
        const priceSpan = document.querySelector(".product__details-price .new-price");
        const cartQuantity = document.getElementById("cartQuantity"); // ✅ Add this line here

        if (!plusBtn || !minusBtn || !qtyInput || !priceSpan || !cartQuantity) return;

        const originalPrice = parseFloat(priceSpan.dataset.originalPrice);

        function updatePrice() {
            let quantity = parseInt(qtyInput.value);
            if (isNaN(quantity) || quantity < 1) quantity = 1;

            const newPrice = (originalPrice * quantity).toFixed(2);
            priceSpan.innerText = "$" + newPrice;

            // ✅ Update hidden input value for cart
            cartQuantity.value = quantity;
        }

        plusBtn.addEventListener("click", function() {
            let current = parseInt(qtyInput.value);
            qtyInput.value = isNaN(current) ? 1 : current + 1;
            updatePrice();
        });

        minusBtn.addEventListener("click", function() {
            let current = parseInt(qtyInput.value);
            if (!isNaN(current) && current > 1) {
                qtyInput.value = current - 1;
                updatePrice();
            }
        });

        qtyInput.addEventListener("input", updatePrice);
    });
</script>

@endpush
