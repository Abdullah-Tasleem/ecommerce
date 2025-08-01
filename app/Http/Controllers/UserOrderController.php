<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('frontend.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        abort_if($order->user_id !== Auth::id(), 403);

        return view('frontend.orders.show', compact('order'));
    }
    public function thankYou($orderId)
    {
        $order = Order::with('orderItems.product')->findOrFail($orderId);
        return view('frontend.thankyou', compact('order'));
    }
    public function cancel(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('order.cancel.page', $order->id);
    }

    public function cancelPage(Order $order)
    {
        return view('frontend.order-canceled', compact('order'));
    }
}
