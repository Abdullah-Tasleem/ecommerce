<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function stripeCheckout(Request $request)
    {
        $cart = session('cart', []);
        $lineItems = [];

        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => $item['price'] * 100,
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $discount = session('discount_amount', 0);
        $totalAmount = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']) - $discount;

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
        ]);

        return redirect($checkoutSession->url);
    }
}
