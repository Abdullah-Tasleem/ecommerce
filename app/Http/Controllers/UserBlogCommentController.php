<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class UserBlogCommentController extends Controller
{
    public function store(Request $request){
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to comment.');
        }

        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'comment' => 'required|string|max:2000',
        ]);

        BlogComment::create([
            'blog_id' => $request->blog_id,
            'user_id' => Auth::id(),
            'name'    => Auth::user()->name,
            'email'   => Auth::user()->email,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Your comment has been submitted successfully.');
    }
}
