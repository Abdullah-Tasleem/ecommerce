<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OrderConfirmation;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:11',
            'password' => 'nullable|min:6',
            'payment_method' => 'required|in:cod,stripe',
        ]);

        $user = Auth::user();

        if ($user) {
            // Logged-in user: check if email matches
            if ($user->email !== $request->email) {
                return redirect()->back()->with('error', 'You are logged in as ' . $user->email . '. Please use this email or log out to use a different one.');
            }
        } else {
            // Not logged in: check if email exists
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return redirect()->back()->with('error', 'Email already registered. Please login.');
            }

            // Create new user
            $user = User::create([
                'name' => $request->first_name,
                'email' => $request->email,
                'password' => Hash::make($request->password ?? Str::random(12)),
            ]);
            Auth::login($user);
        }

        $cart = session('cart', []);
        $discount = session('discount_amount', 0);
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $finalAmount = $subtotal - $discount;

        $address = [
            'name' => $request->first_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
        ];

        // If Cash on Delivery
        if ($request->payment_method === 'cod') {
            $order = $this->storeOrder($user, $cart, $subtotal, $discount, $finalAmount, $address, 'pending', 'cod');

            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new OrderPlacedNotification($order));
            Mail::to($user->email)->send(new OrderConfirmation($order));
            session()->forget('cart');

            return redirect()->route('thankyou', $order->id)->with('success', 'Order placed successfully!');
        }

        // If Stripe Payment
        if ($request->payment_method === 'stripe') {
            // Store required data in session for success callback
            session([
                'checkout_user_id' => $user->id,
                'checkout_subtotal' => $subtotal,
                'checkout_discount' => $discount,
                'checkout_finalAmount' => $finalAmount,
                'checkout_address' => $address,
            ]);

            $lineItems = [];
            foreach ($cart as $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                $proportionalDiscount = ($subtotal > 0) ? ($itemTotal / $subtotal) * $discount : 0;
                $finalPrice = ($itemTotal - $proportionalDiscount) / $item['quantity'];

                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => $item['name']],
                        'unit_amount' => round($finalPrice * 100), // in cents
                    ],
                    'quantity' => $item['quantity'],
                ];
            }


            Stripe::setApiKey(env('STRIPE_SECRET'));

            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel'),
            ]);

            return redirect($checkoutSession->url);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $userId = session('checkout_user_id');
        $user = User::findOrFail($userId);

        $subtotal = session('checkout_subtotal');
        $discount = session('checkout_discount');
        $finalAmount = session('checkout_finalAmount');
        $cart = session('cart', []);
        $address = session('checkout_address');

        $order = $this->storeOrder($user, $cart, $subtotal, $discount, $finalAmount, $address, 'paid', 'stripe');

        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new OrderPlacedNotification($order));


        session()->forget([
            'cart',
            'checkout_user_id',
            'checkout_subtotal',
            'checkout_discount',
            'checkout_finalAmount',
            'checkout_address',
        ]);

        return redirect()->route('thankyou', $order->id)->with('success', 'Payment successful & order placed!');
    }
    public function paymentCancel()
    {
        return view('frontend.order-canceled');
    }

    private function storeOrder($user, $cart, $subtotal, $discount, $finalAmount, $address, $paymentStatus, $paymentMethod)
    {
        $order = Order::create([
            'user_id'        => $user->id,
            'subtotal'       => $subtotal,
            'discount'       => $discount,
            'total'          => $finalAmount,
            'name'           => $address['name'],
            'phone'          => $address['phone'],
            'address'        => $address['address'],
            'city'           => $address['city'],
            'state'          => $address['state'],
            'zip'            => $address['zip'],
            'status'         => 'pending',
            'payment_status' => $paymentStatus,
            'payment_method' => $paymentMethod,
            'order_number'   => 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
        ]);

        foreach ($cart as $productId => $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $proportionalDiscount = ($subtotal > 0) ? ($itemTotal / $subtotal) * $discount : 0;
            $finalPrice = ($itemTotal - $proportionalDiscount) / $item['quantity'];

            $order->orderItems()->create([
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => round($finalPrice, 2),
            ]);
        }

        return $order->load('orderItems.product');
    }
}
