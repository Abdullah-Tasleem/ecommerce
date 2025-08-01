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
                            <h2 class="breadcrumb__title">Checkout</h2>
                            <div class="breadcrumb__menu">
                                <nav>
                                    <ul>
                                        <li><span><a href="{{ route('home') }}">Home</a></span></li>
                                        <li><span>checkout</span></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb area start  -->

        <!-- checkout-area start -->
        <section class="checkout-area section-space">
            <div class="container">
                <form method="POST" action="{{ route('checkout.placeOrder') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkbox-form">
                                <h3 class="mb-15">Billing Details</h3>
                                <div class="row g-5">
                                    <div class="col-md-12">
                                        <div class="country-select">
                                            <label>Country <span class="required">*</span></label>
                                            <select name="country" id="country">
                                                <option value="us">United States</option>
                                                <option value="dz">Algeria</option>
                                                <option value="af">Afghanistan</option>
                                                <option value="gh">Ghana</option>
                                                <option value="al">Albania</option>
                                                <option value="bh">Bahrain</option>
                                                <option value="co">Colombia</option>
                                                <option value="do">Dominican Republic</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>First Name <span class="required">*</span></label>
                                            <input type="text" name="first_name" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Last Name <span class="required">*</span></label>
                                            <input type="text" name="last_name" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Company Name</label>
                                            <input type="text" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Address <span class="required">*</span></label>
                                            <input type="text" name="address" placeholder="Street address">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <input type="text" placeholder="Apartment, suite, unit etc. (optional)">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Town / City <span class="required">*</span></label>
                                       <input type="text" name="city" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>State / County <span class="required">*</span></label>
                                            <input type="text" name="state" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Postcode / Zip <span class="required">*</span></label>
                                            <input type="text" name="zip" placeholder="Postcode / Zip">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Email Address <span class="required">*</span></label>
                                            <input type="email" name='email' placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Phone <span class="required">*</span></label>
                                            <input type="text" name="phone" placeholder="Postcode / Zip">
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-12">
                                        <div class="checkout-form-list create-acc d-flex align-content-center">
                                            <input class="e-check-input" id="xbox" type="checkbox"
                                                name="create_account">
                                            <label class="mb-0">Create an account?</label>
                                        </div>
                                        <div id="cbox_info" class="checkout-form-list create-account">
                                            <p>Create an account by entering the information below. If you are a
                                                returning
                                                customer please login at the top of the page.</p>
                                            <label>Account password <span class="required">*</span></label>
                                            <input type="password" name='password' placeholder="password">
                                        </div>
                                    </div> --}}
                                </div>
                                {{-- <div class="different-address">
                                    <div class="ship-different-title">
                                        <label>Ship to a different address?</label>
                                        <input class="e-check-input" id="ship-box" type="checkbox">
                                    </div>
                                    <div id="ship-box-info">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="country-select">
                                                    <label>Country <span class="required">*</span></label>
                                                    <select>
                                                        <option value="volvo">Bangladesh</option>
                                                        <option value="saab">Algeria</option>
                                                        <option value="mercedes">Afghanistan</option>
                                                        <option value="audi">Ghana</option>
                                                        <option value="audi2">Albania</option>
                                                        <option value="audi3">Bahrain</option>
                                                        <option value="audi4">Colombia</option>
                                                        <option value="audi5">Dominican Republic</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>First Name <span class="required">*</span></label>
                                                    <input type="text" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>Last Name <span class="required">*</span></label>
                                                    <input type="text" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkout-form-list">
                                                    <label>Company Name</label>
                                                    <input type="text" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkout-form-list">
                                                    <label>Address <span class="required">*</span></label>
                                                    <input type="text" placeholder="Street address">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkout-form-list">
                                                    <input type="text"
                                                        placeholder="Apartment, suite, unit etc. (optional)">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkout-form-list">
                                                    <label>Town / City <span class="required">*</span></label>
                                                    <input type="text" placeholder="Town / City">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>State / County <span class="required">*</span></label>
                                                    <input type="text" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>Postcode / Zip <span class="required">*</span></label>
                                                    <input type="text" placeholder="Postcode / Zip">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>Email Address <span class="required">*</span></label>
                                                    <input type="email" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>Phone <span class="required">*</span></label>
                                                    <input type="text" placeholder="Postcode / Zip">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="your-order">
                                <h3>Your order</h3>
                                <div class="your-order-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-name">Product</th>
                                                <th class="product-total">Total</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $cart = session('cart', []);
                                            $subtotal = collect($cart)->sum(
                                                fn($item) => $item['price'] * $item['quantity'],
                                            );
                                            $discount = session('discount_amount', 0);
                                        @endphp
                                        <tbody>
                                            @foreach ($cart as $item)
                                                <tr class="cart_item">
                                                    <td class="product-name">
                                                        {{ $item['name'] }}
                                                        <strong class="product-quantity">× {{ $item['quantity'] }}</strong>
                                                    </td>
                                                    <td class="product-total">
                                                        <span
                                                            class="amount">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="cart-subtotal">
                                                <th>Cart Subtotal</th>
                                                <td><span class="amount">${{ number_format($subtotal, 2) }}</span></td>
                                            </tr>

                                            @if (session('applied_coupon'))
                                                <tr class="cart-discount">
                                                    <th>Discount ({{ session('applied_coupon') }})</th>
                                                    <td><span class="amount text-success">-
                                                            ${{ number_format($discount, 2) }}
                                                        </span></td>
                                                </tr>
                                            @endif

                                            <tr class="order-total">
                                                <th>Order Total</th>
                                                <td><strong><span
                                                            class="amount">${{ number_format($subtotal - $discount, 2) }}</span></strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="payment-method">
                                    <div class="accordion" id="checkoutAccordion">
                                        <!-- Cash on Delivery -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="checkoutCod">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseCod" aria-expanded="true"
                                                    aria-controls="collapseCod">
                                                    Cash on Delivery
                                                </button>
                                            </h2>
                                            <div id="collapseCod" class="accordion-collapse collapse show"
                                                aria-labelledby="checkoutCod" data-bs-parent="#checkoutAccordion">
                                                <div class="accordion-body">
                                                    <label>
                                                        <input type="radio" name="payment_method" value="cod"
                                                            checked>
                                                        Your order will be paid in cash when delivered.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Stripe -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="checkoutStripe">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseStripe"
                                                    aria-expanded="false" aria-controls="collapseStripe">
                                                    Stripe
                                                </button>
                                            </h2>
                                            <div id="collapseStripe" class="accordion-collapse collapse"
                                                aria-labelledby="checkoutStripe" data-bs-parent="#checkoutAccordion">
                                                <div class="accordion-body">
                                                    <label>
                                                        <input type="radio" name="payment_method" value="stripe">
                                                        Pay securely with your credit/debit card using Stripe.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="order-button-payment mt-4">
                                    <button class="fill-btn" type="submit">
                                        <span class="fill-btn-inner">
                                            <span class="fill-btn-normal">Place Order</span>
                                            <span class="fill-btn-hover">Place Order</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- checkout-area end -->

    </main>
    <!-- Body main wrapper end -->
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll('input[name="payment_method"]');
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const selectedMethod = this.value;

                    // Collapse all accordions
                    const allAccordions = document.querySelectorAll('.accordion-collapse');
                    allAccordions.forEach(acc => acc.classList.remove('show'));

                    // Deactivate all buttons
                    const allButtons = document.querySelectorAll('.accordion-button');
                    allButtons.forEach(btn => btn.classList.add('collapsed'));

                    // Find matching accordion item
                    const item = document.querySelector(`.accordion-item[data-method="${selectedMethod}"]`);
                    if (item) {
                        const button = item.querySelector('.accordion-button');
                        const collapse = item.querySelector('.accordion-collapse');

                        // Expand the selected
                        collapse.classList.add('show');
                        button.classList.remove('collapsed');
                    }
                });
            });
        });
    </script>
@endpush
