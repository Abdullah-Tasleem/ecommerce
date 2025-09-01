<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Product;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Review;
use App\Models\Tag;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $bannerProducts = Product::where('status', 1)->where('feature', 1)->latest()->take(3)->get();
        $latestProducts = Product::where('status', 1)->latest()->take(2)->get();
        $products = Product::where('status', 1)->latest()->paginate(8);
        $featuredProducts = Product::where('feature', 1)->where('status', 1)->latest()->get();
        $recentBlogs = Blog::latest()->take(2)->get();
        $latestReviews = Review::latest()->take(3)->get();

        return view('frontend.index', compact('bannerProducts', 'latestProducts', 'products', 'featuredProducts', 'recentBlogs', 'latestReviews'));
    }

    public function view(Product $product, $slug)
    {
        if ($product->slug !== $slug) {
            return redirect()->route('details', [$product->id, $product->slug]);
        }

        $categoriesNames = Category::whereIn('id', $product->categories ?? [])->pluck('name')->toArray();
        $tagNames = Tag::whereIn('id', $product->tags ?? [])->pluck('name')->toArray();
        $reviews = $product->reviews()->latest()->get();

        return view('frontend.product-details', compact('product', 'categoriesNames', 'tagNames', 'reviews'));
    }

    public function all_products(Request $request)
    {
        $perPage = $request->get('show', 8);
        $products = Product::where('status', 1)->latest()->paginate($perPage);

        return view('frontend.shop', compact('products'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function checkout()
    {
        return view('frontend.checkout');
    }

    public function quickView($id)
    {
        $product = Product::with('reviews')->findOrFail($id);
        $tags = Tag::whereIn('id', $product->tags)->get();
        $category = Category::find($product->category_id);
        return view('frontend.quickview-modal', compact('product', 'tags', 'category'));
    }

    public function searchProduct(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $products = Product::query()
            ->select('id', 'name', 'slug', 'images')
            ->where('name', 'like', "%{$q}%")
            ->orderByRaw("CASE WHEN name LIKE ? THEN 0 ELSE 1 END", [$q . '%'])
            ->limit(3)
            ->get()
            ->map(function ($p) {
                $thumb = null;

                if (is_array($p->images) && count($p->images)) {
                    $thumb = asset('storage/' . $p->images[0]);
                }

                return [
                    'id'    => $p->id,
                    'name'  => $p->name,
                    'thumb' => $thumb,
                    'url'   => route('details', [$p->id, $p->slug]),
                ];
            })
            ->values();

        return response()->json($products);
    }
}
