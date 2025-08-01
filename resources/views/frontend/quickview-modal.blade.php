<div class="product-modal-wrapper p-relative">
    <button type="button" class="close product-modal-close" data-bs-dismiss="modal" aria-label="Close">
        <i class="fal fa-times"></i>
    </button>

    <div class="modal__inner">
        <div class="bd__shop-details-inner">
            <div class="row">
                <div class="col-xxl-6 col-lg-6">
                    <div class="product__details-thumb-wrapper d-sm-flex align-items-start">
                        <div class="product__details-thumb-tab-content w-100">
                            <div class="product__details-thumb-big w-img text-center">
                                @php
                                    $firstImage = collect($product->images)
                                        ->filter(fn($img) => is_string($img) && !empty($img))
                                        ->first();
                                @endphp
                                @if ($firstImage)
                                    <img src="{{ asset('storage/' . ltrim($firstImage, '/')) }}"
                                        alt="{{ $product->name }}" class="img-fluid">
                                @else
                                    <img src="{{ asset('assets/imgs/no-image.png') }}" alt="No Image" class="img-fluid">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 col-lg-6">
                    <div class="product__details-content">
                        <div class="product__details-top d-flex flex-wrap gap-3 align-items-center mb-15">
                            <div class="product__details-tag">
                                @if ($product->category)
                                    <a href="#">{{ $product->category->name }}</a>
                                @endif
                            </div>
                            @php
                                $avgRating = round($product->reviews->avg('rating'), 1);
                            @endphp
                            <div class="product__details-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <a href="#">
                                        <i class="fa{{ $i <= $avgRating ? '-solid' : '-regular' }} fa-star"></i>
                                    </a>
                                @endfor
                            </div>
                            <div class="product__details-review-count">
                                <a href="#">{{ $product->reviews->count() }} Reviews</a>
                            </div>
                        </div>

                        <h3 class="product__details-title">{{ $product->name }}</h3>
                        <div class="product__details-price mb-2">
                            @if ($product->sale_price)
                                <span class="old-price">${{ $product->regular_price }}</span>
                                <span class="new-price ms-2">${{ $product->sale_price }}</span>
                            @else
                                <span class="new-price">${{ $product->regular_price }}</span>
                            @endif
                        </div>

                        <p>{{ Str::limit($product->description, 150) }}</p>

                        <div class="product__details-action mb-35 mt-3">
                            <div class="product__quantity">
                                <form action="#">
                                    <div class="product-quantity-wrapper">
                                        <button class="cart-minus" type="button"><i
                                                class="fa-light fa-minus"></i></button>
                                        <input class="cart-input" type="text" value="1">
                                        <button class="cart-plus" type="button"><i
                                                class="fa-light fa-plus"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="product__add-cart mt-3">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="fill-btn cart-btn">
                                        <span class="fill-btn-inner">
                                            <span class="fill-btn-normal">
                                                Add To Cart <i class="fa-solid fa-basket-shopping"></i>
                                            </span>
                                            <span class="fill-btn-hover">
                                                Add To Cart <i class="fa-solid fa-basket-shopping"></i>
                                            </span>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="product__details-meta">
                            <div class="sku">
                                <span>SKU:</span>
                                <a href="#">SKU-{{ $product->id }}</a>
                            </div>
                            <div class="tag">
                                <span>Tags:</span>
                                @foreach ($tags as $tag)
                                    <a href="#">{{ $tag->name }}</a>{{ !$loop->last ? ',' : '' }}
                                @endforeach
                            </div>
                            <div class="categories">
                                <span>Categories:</span>
                                <a href="#">{{ $category->name ?? 'N/A' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- bd__shop-details-inner -->
    </div> <!-- modal__inner -->
</div> <!-- product-modal-wrapper -->
