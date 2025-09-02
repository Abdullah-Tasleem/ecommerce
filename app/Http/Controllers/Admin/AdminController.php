<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
{
    $usersCount = User::count();
    $ordersCount = Order::count();
    $productsCount = Product::count();
    $notifications = auth()->user()->notifications()->latest()->take(10)->get();

    return view('dashboard.dashboard', compact('usersCount', 'ordersCount', 'productsCount', 'notifications'));
}

}
