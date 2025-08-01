<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $discount = session('discount_amount', 0);
        $total = $subtotal - $discount;

        return view('frontend.cart', compact('cart', 'subtotal', 'discount', 'total'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id'       => $product->id,
                "name"     => $product->name,
                'slug'     => $product->slug,
                "price"    => $product->sale_price ?? $product->regular_price,
                "quantity" => $quantity,
                "image"    => $product->images[0] ?? null,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }


    public function ajaxUpdate(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;
        $quantity = max((int) $request->quantity, 1);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session(['cart' => $cart]);
        }

        // Recalculate totals
        $subtotal = $cart[$id]['price'] * $quantity;
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $cartCount = collect($cart)->sum('quantity');

        // Reset applied coupon when cart changes
        session()->forget(['applied_coupon', 'discount_amount']);

        return response()->json([
            'success'   => true,
            'subtotal'  => round($subtotal, 2),
            'total'     => round($total, 2),
            'cartCount' => $cartCount
        ]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            // Reset coupon when an item is removed
            session()->forget(['applied_coupon', 'discount_amount']);
        }

        return back()->with('success', 'Product removed from cart.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('status', 'active')
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or inactive coupon code.'
            ]);
        }

        // Check validity dates
        $now = now();
        if ($coupon->start_date && $now->lt($coupon->start_date)) {
            return response()->json(['success' => false, 'message' => 'Coupon is not yet valid.']);
        }

        if ($coupon->end_date && $now->gt($coupon->end_date)) {
            return response()->json(['success' => false, 'message' => 'Coupon has expired.']);
        }

        // Calculate cart total
        $cart = session('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.']);
        }

        // Decode eligible categories
        $eligibleCategoryIds = is_array($coupon->eligible_categories)
            ? $coupon->eligible_categories
            : json_decode($coupon->eligible_categories ?? '[]', true);

        $eligibleCategoryIds = is_array($eligibleCategoryIds) ? $eligibleCategoryIds : [];

        // Calculate cart total for eligible items only
        $eligibleCartItems = [];

        foreach ($cart as $id => $item) {
            $product = Product::with('category')->find($id);

            if (!$product || !$product->category) continue;

            $productCategoryIds = [$product->category->id];

            // Check if product belongs to any eligible category
            $isEligible = count(array_intersect($eligibleCategoryIds, $productCategoryIds)) > 0;

            if ($isEligible) {
                $eligibleCartItems[$id] = $item;
            }
        }


        // Check if there are any eligible items
        if (empty($eligibleCartItems)) {
            return response()->json(['success' => false, 'message' => 'This coupon does not apply.']);
        }

        // Calculate subtotal for eligible items only
        $eligibleTotal = collect($eligibleCartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $discount = 0;
        if ($coupon->discount_type === 'fixed') {
            $discount = min($coupon->discount_value, $eligibleTotal);
        } elseif ($coupon->discount_type === 'percent') {
            $discount = ($coupon->discount_value / 100) * $eligibleTotal;
            if ($coupon->max_discount_amount) {
                $discount = min($discount, $coupon->max_discount_amount);
            }
        }
        $cartTotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        // Check minimum cart value
        if ($coupon->min_cart_value && $cartTotal < $coupon->min_cart_value) {
            return response()->json(['success' => false, 'message' => 'Cart total is below minimum required for this coupon.']);
        }
        $totalAfterDiscount = $cartTotal - $discount;


        session([
            'applied_coupon'  => $coupon->code,
            'discount_amount' => $discount,
        ]);

        return response()->json([
            'success'     => true,
            'discount'    => number_format($discount, 2),
            'total'       => number_format($totalAfterDiscount, 2),
            'coupon_code' => $coupon->code,
        ]);
    }
}
