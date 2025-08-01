<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->pluck('name', 'id');
        $tags       = Tag::where('status', true)->pluck('name', 'id');
        return view('admin.products.create', compact('categories', 'tags'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'regular_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'off' => 'nullable|in:10,20,30,40,50,60,70,80,90',
            'stock' => 'required|integer',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'categories'   => 'required|array|min:1',
            'tags'         => 'required|array|min:1',
            'rating' => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer',
            'status' => 'boolean',
            'feature' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $originalSlug = Str::slug($data['name']);
            $slug = $originalSlug;
            $count = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $data['slug'] = $slug;
        }

        // Store multiple images and save JSON
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
        }

        $data['images'] = $imagePaths;
        $data['categories'] = $request->categories;
        $data['tags']       = $request->tags;
        $data['rating'] = $data['rating'] ?? 0;
        $data['review_count'] = $data['review_count'] ?? 0;
        $product = Product::create($data);


        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }


    public function edit(Product $product)
    {
        $categories = Category::where('status', 1)->pluck('name', 'id');
        $tags = Tag::where('status', 1)->pluck('name', 'id');

        // Decode JSON fields from the product
        $selectedCategories = is_array($product->categories)
            ? $product->categories
            : json_decode($product->categories, true) ?? [];

        $selectedTags = is_array($product->tags)
            ? $product->tags
            : json_decode($product->tags, true) ?? [];

        return view('admin.products.edit', compact('product', 'categories', 'tags', 'selectedCategories', 'selectedTags'));
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'regular_price' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'off' => 'nullable|in:10,20,30,40,50,60,70,80,90',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'categories' => 'required|array|min:1',
            'tags' => 'array',
            'rating' => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
            'feature' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if (empty($validated['slug'])) {
            $originalSlug = Str::slug($validated['name']);
            $slug = $originalSlug;
            $count = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $validated['slug'] = $slug;
        }

        // Update basic fields
        $product->update($validated);

        $product->tags = $request->tags ?? [];
        $product->categories = $request->categories ?? [];


        // Handle deleting selected old images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imagePath) {
                Storage::delete('public/' . $imagePath);
            }

            // Remove from DB array
            $product->images = array_values(array_filter($product->images, function ($img) use ($request) {
                return !in_array($img, $request->delete_images);
            }));
        }
        if ($request->hasFile('images')) {
            $newImages = [];
            foreach ($request->file('images') as $imageFile) {
                $newImages[] = $imageFile->store('products', 'public');
            }

            // Merge with remaining existing images (if any)
            $product->images = array_merge($product->images ?? [], $newImages);
        }

        // Filter out invalid or empty entries
        $product->images = array_values(array_filter($product->images ?? [], function ($img) {
            return is_string($img) && !empty($img);
        }));

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated!');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted!');
    }
    public function show(Product $product)
    {
        $categoryNames = Category::whereIn('id', $product->categories ?? [])->pluck('name')->toArray();
        $tagNames = Tag::whereIn('id', $product->tags ?? [])->pluck('name')->toArray();
        return view('admin.products.show', compact('product', 'categoryNames', 'tagNames'));
    }
}
