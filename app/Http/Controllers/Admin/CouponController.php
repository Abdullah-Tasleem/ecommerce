<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    // Show all coupons
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    // Show form to create a new coupon
    public function create()
    {
        $categories = Category::all();
        return view('admin.coupons.create', compact('categories'));
    }

    // Store new coupon
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:fixed,percent',
            'discount_value' => 'required|numeric',
            'max_discount_amount' => 'nullable|numeric',
            'min_cart_value' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'usage_limit' => 'nullable|integer',
            'limit_per_user' => 'nullable|integer',
            'eligible_categories' => 'nullable|array',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Boolean flags
        $validated['first_time_users_only'] = $request->has('first_time_users_only');
        $validated['registered_users_only'] = $request->has('registered_users_only');
        $validated['exclude_sale_items'] = $request->has('exclude_sale_items');
        $validated['auto_apply'] = $request->has('auto_apply');

        $validated['eligible_categories'] = $request->filled('eligible_categories')
            ? array_filter($request->eligible_categories)
            : [];

        // Default status if not provided
        $validated['status'] = $request->input('status', 'inactive');

        Coupon::create($validated);

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully!');
    }

    public function show($code)
    {
        $coupon = Coupon::where('code', $code)->firstOrFail();
        return view('admin.coupons.show', compact('coupon'));
    }

    // Show form to edit existing coupon
    public function edit($code)
    {
        $coupon = Coupon::where('code', $code)->firstOrFail();
        $categories = Category::all();
        return view('admin.coupons.edit', compact('coupon', 'categories'));
    }

    // Update coupon
    public function update(Request $request, $code)
    {
        $coupon = Coupon::where('code', $code)->firstOrFail();

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                Rule::unique('coupons')->ignore($coupon->code, 'code'),
            ],
            'name' => 'required|string',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:fixed,percent',
            'discount_value' => 'required|numeric',
            'max_discount_amount' => 'nullable|numeric',
            'min_cart_value' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'usage_limit' => 'nullable|integer',
            'limit_per_user' => 'nullable|integer',
            'eligible_categories' => 'nullable|array',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Boolean flags
        $validated['first_time_users_only'] = $request->has('first_time_users_only');
        $validated['registered_users_only'] = $request->has('registered_users_only');
        $validated['exclude_sale_items'] = $request->has('exclude_sale_items');
        $validated['auto_apply'] = $request->has('auto_apply');

        $validated['eligible_categories'] = $request->filled('eligible_categories')
            ? array_filter($request->eligible_categories)
            : [];

        // Default status if not provided
        $validated['status'] = $request->input('status', 'inactive');

        $coupon->update($validated);

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully!');
    }

    // Delete coupon
    public function destroy($code)
    {
        $coupon = Coupon::where('code', $code)->firstOrFail();
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted.');
    }
}
