<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class UserBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', 1)->latest()->paginate(6);
        return view('frontend.blog', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->where('status', 1)->firstOrFail();
        $categoriesNames = Category::whereIn('id', $blog->categories ?? [])->pluck('name')->toArray();
        $tagNames = Tag::whereIn('id', $blog->tags ?? [])->pluck('name')->toArray();
        $recentPosts = Blog::orderBy('created_at', 'desc')->take(3)->get();
        $comments = $blog->comments()->where('status', 'approved')->latest()->get();
        return view('frontend.blog-details', compact('blog', 'categoriesNames', 'tagNames', 'recentPosts', 'comments'));
    }
    public function searchBlog(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $blogs = Blog::query()
            ->select('id', 'title', 'slug', 'images')
            ->where('title', 'like', "%{$q}%")
            ->orderByRaw("CASE WHEN title LIKE ? THEN 0 ELSE 1 END", [$q . '%'])
            ->limit(5)
            ->get()
            ->map(function ($blog) {
                $thumb = null;

                if (!empty($blog->images)) {
                    $images = is_array($blog->images)
                        ? $blog->images
                        : json_decode($blog->images, true);

                    if (is_array($images) && count($images)) {
                        $thumb = asset('storage/' . $images[0]);
                    }
                }

                return [
                    'id'    => $blog->id,
                    'name'  => $blog->title,
                    'thumb' => $thumb,
                    'url'   => route('blogs.show', $blog->slug),
                ];
            })
            ->values();

        return response()->json($blogs);
    }
}
