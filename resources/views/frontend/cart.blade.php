@extends('frontend.layout.main')
@section('section')
    <main>
        <!-- Breadcrumb area start  -->
        <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
            <div class="breadcrumb__thumb" data-background="{{ asset('assets/imgs/bg/breadcrumb-bg.jpg') }}"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-12">
                        <div class="breadcrumb__wrapper text-center">
                            <h2 class="breadcrumb__title">Cart</h2>
                            <div class="breadcrumb__menu">
                                <nav>
                                    <ul>
                                        <li><span><a href="{{ route('home') }}">Home</a></span></li>
                                        <li><span>Cart</span></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb area end  -->

        <!-- Cart area start  -->
        <div class="cart-area section-space">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Images</th>
                                        <th class="cart-product-name">Product</th>
                                        <th class="product-price">Unit Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach (session('cart', []) as $id => $item)
                                        @php
                                            $subtotal = $item['price'] * $item['quantity'];
                                            $total += $subtotal;

                                            $validImages = collect(
                                                is_array($item['image']) ? $item['image'] : [$item['image']],
                                            )
                                                ->filter(function ($img) {
                                                    return is_string($img) && !empty($img);
                                                })
                                                ->values(); // reindex from 0
                                        @endphp
                                        <tr data-id="{{ $id }}">
                                            <td>
                                                @if (isset($validImages[0]))
                                                    <img src="{{ asset('storage/' . $validImages[0]) }}" width="70">
                                                @else
                                                    <span>No image</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('details', ['product' => $item['id'], 'slug' => $item['slug']]) }}">
                                                    {{ $item['name'] }}
                                                </a>
                                            </td>

                                            <td>${{ number_format($item['price'], 2) }}</td>
                                            <td class="product-quantity text-center">
                                                <div class="product-quantity mt-10 mb-10">
                                                    <div class="product-quantity-form">
                                                        <button type="button" class="cart-minus"><i
                                                                class="far fa-minus"></i></button>
                                                        <input class="cart-input cart-qty" type="text" name="quantity"
                                                            value="{{ $item['quantity'] }}">
                                                        <button type="button" class="cart-plus"><i
                                                                class="far fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="item-subtotal">${{ number_format($subtotal, 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"><i class="fa fa-times"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="coupon-all">
                                    <div class="coupon d-flex align-items-center">
                                        <input id="coupon_code" class="input-text" name="coupon_code"
                                            placeholder="Coupon code" type="text">
                                        <button class="fill-btn" id="apply-coupon-btn" type="button">
                                            <span class="fill-btn-inner">
                                                <span class="fill-btn-normal">apply coupon</span>
                                                <span class="fill-btn-hover">apply coupon</span>
                                            </span>
                                        </button>
                                        <div class="mt-2 text-success" id="coupon-success-msg"></div>
                                        <div class="mt-2 text-danger" id="coupon-error-msg"></div>
                                    </div>
                                    <div class="coupon2">
                                        <button onclick="window.location.reload()" class="fill-btn" type="submit">
                                            <span class="fill-btn-inner">
                                                <span class="fill-btn-normal">Update cart</span>
                                                <span class="fill-btn-hover">Update cart</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 ml-auto">
                                <div class="cart-page-total">
                                    <h2>Cart totals</h2>
                                    <ul class="mb-20">
                                        <li>Subtotal <span id="cart-subtotal">${{ number_format($total, 2) }}</span></li>
                                        </li>
                                        @php
                                            $appliedCoupon = session('applied_coupon');
                                            $discountAmount = session('discount_amount', 0);
                                        @endphp
                                        <li>
                                            Discount
                                            @if (session('applied_coupon'))
                                                ({{ session('applied_coupon') }})
                                            @endif
                                            <span
                                                class="text-success">-${{ number_format(session('discount_amount', 0), 2) }}</span>
                                        </li>

                                        <li>Total
                                            <span id="cart-total">
                                                ${{ number_format($total - $discountAmount, 2) }}
                                            </span>
                                        </li>
                                    </ul>

                                    <a class="fill-btn" href="{{ route('checkout') }}">
                                        <span class="fill-btn-inner">
                                            <span class="fill-btn-normal">Proceed to checkout</span>
                                            <span class="fill-btn-hover">Proceed to checkout</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart area end  -->
    </main>
    @push('scripts')
        <script>
            $(document).ready(function() {
                let updateTimeouts = {}; // Store timeout per item ID

                $('.cart-plus, .cart-minus').off('click').on('click', function() {
                    let row = $(this).closest('tr');
                    let input = row.find('.cart-qty');
                    let id = row.data('id');
                    let quantity = parseInt(input.val());

                    if (isNaN(quantity) || quantity < 1) quantity = 1;

                    if ($(this).hasClass('cart-plus')) quantity++;
                    else if (quantity > 1) quantity--;

                    input.val(quantity);

                    // Clear any previous timeout for this item
                    clearTimeout(updateTimeouts[id]);

                    // Set a new timeout to update the cart after 300ms
                    updateTimeouts[id] = setTimeout(function() {
                        updateCart(id, quantity);
                    }, 300);
                });

                $('.cart-qty').off('input').on('input', function() {
                    let row = $(this).closest('tr');
                    let id = row.data('id');
                    let quantity = parseInt($(this).val());
                    if (isNaN(quantity) || quantity < 1) quantity = 1;

                    clearTimeout(updateTimeouts[id]);
                    updateTimeouts[id] = setTimeout(function() {
                        updateCart(id, quantity);
                    }, 300);
                });

                function updateCart(id, quantity) {
                    $('#preloader').fadeIn(); // Show global preloader

                    $.ajax({
                        url: '{{ route('cart.ajax.update') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            quantity: quantity
                        },
                        success: function(res) {
                            if (res.success) {
                                let row = $('tr[data-id="' + id + '"]');
                                row.find('.item-subtotal').text(`$${res.subtotal}`);
                                $('#cart-total').text(`$${res.total}`);
                                $('#cart-subtotal').text(`$${res.total}`);
                                $('#cart-badge').text(res.cartCount);
                            }
                        },
                        complete: function() {
                            $('#preloader').fadeOut(); // Hide preloader after request
                        }
                    });
                }
                $('#apply-coupon-btn').on('click', function() {
                    const code = $('#coupon_code').val().trim();
                    $('#coupon-success-msg').text('');
                    $('#coupon-error-msg').text('');

                    if (!code) {
                        $('#coupon-error-msg').text('Please enter a coupon code.');
                        return;
                    }

                    $.ajax({
                        url: '{{ route('cart.applyCoupon') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            coupon_code: code
                        },
                        success: function(res) {
                            if (res.success) {
                                $('#coupon-success-msg').text(
                                    `Coupon "${res.coupon_code}" applied. Discount: $${res.discount}`
                                );
                                $('#cart-total').text(`$${res.total}`);
                                $('span.text-success').text(`-$${res.discount}`);

                                if (res.coupon_code) {
                                    $('.cart-page-total li:contains("Discount")')
                                        .contents()
                                        .filter(function() {
                                            return this.nodeType === 3;
                                        })
                                        .first()
                                        .replaceWith(`Discount (${res.coupon_code})`);
                                }
                            } else {
                                $('#coupon-error-msg').text(res.message);
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
