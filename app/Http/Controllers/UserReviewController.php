<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to leave a review.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'review' => $request->review,
            'user_name' => Auth::user()->name,
            'user_email' => Auth::user()->email,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
