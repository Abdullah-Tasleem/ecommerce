<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
public function index()
{
    $blogs = Blog::latest()->paginate(10);
    return view('admin.blogs.index', compact('blogs'));
}


    public function create()
    {
        $categories = Category::where('status', true)->pluck('name', 'id');
        $tags       = Tag::where('status', true)->pluck('name', 'id');

        return view('admin.blogs.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|unique:blogs,slug',
            'author'       => 'required|string|max:100',
            'images.*'     => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'excerpt'      => 'nullable|string',
            'content'      => 'required|string',
            'published_at' => 'nullable|date',
            'categories'   => 'required|array|min:1',
            'tags'         => 'required|array|min:1',
            'status'       => 'boolean',
        ]);

        $data['slug'] = $this->generateUniqueSlug($data['slug'] ?? null, $data['title']);

        // handle images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('blogs', 'public');
            }
        }
        $data['images'] = $imagePaths;
        $data['categories'] = $request->categories;
        $data['tags']       = $request->tags;
        $data['published_at'] = $data['published_at'] ?? now();

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function tinymceUpload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/tinymce', $fileName);

            return response()->json(['location' => asset('storage/tinymce/' . $fileName)]);
        }

        return response()->json(['error' => 'File upload failed!'], 400);
    }

    public function show(Blog $blog)
    {
        $categoryNames = Category::whereIn('id', $blog->categories ?? [])
            ->pluck('name')
            ->toArray();

        $tagNames = Tag::whereIn('id', $blog->tags ?? [])
            ->pluck('name')
            ->toArray();

        return view('admin.blogs.show', compact('blog', 'categoryNames', 'tagNames'));
    }

    public function edit(Blog $blog)
    {
        $categories = Category::where('status', true)->pluck('name', 'id');
        $tags       = Tag::where('status', true)->pluck('name', 'id');

        return view('admin.blogs.edit', compact('blog', 'categories', 'tags'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'slug'          => 'nullable|string|unique:blogs,slug,' . $blog->id,
            'author'        => 'required|string|max:100',
            'images.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'excerpt'       => 'nullable|string',
            'content'       => 'required|string',
            'published_at'  => 'nullable|date',
            'categories'    => 'required|array|min:1',
            'categories.*'  => 'integer|exists:categories,id',
            'tags'          => 'required|array|min:1',
            'tags.*'        => 'integer|exists:tags,id',
            'status'        => 'boolean',
            'delete_images'   => 'nullable|array',
            'delete_images.*' => 'string',
        ]);

        $data['slug'] = $this->generateUniqueSlug($data['slug'] ?? null, $data['title'], $blog->id);

        // existing images
        $existingImages = $blog->images ?? [];

        // delete selected old images
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imgPath) {
                Storage::disk('public')->delete($imgPath);
            }
            $existingImages = array_values(array_filter(
                $existingImages,
                fn($img) =>
                !in_array($img, $request->delete_images, true)
            ));
        }

        // add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $existingImages[] = $image->store('blogs', 'public');
            }
        }

        $data['images']     = array_values(array_filter($existingImages));
        $data['categories'] = $request->categories;
        $data['tags']       = $request->tags;
        $data['published_at'] = $data['published_at'] ?? $blog->published_at ?? now();

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $images = $blog->images ?? [];

        foreach ($images as $img) {
            Storage::disk('public')->delete($img);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    /**
     * Generate unique slug.
     */
    private function generateUniqueSlug(?string $slug, string $title, ?int $ignoreId = null): string
    {
        $base = $slug ? Str::slug($slug) : Str::slug($title);
        $unique = $base;
        $count = 1;

        $query = Blog::query();
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->where('slug', $unique)->exists()) {
            $unique = $base . '-' . $count++;
        }

        return $unique;
    }
}
