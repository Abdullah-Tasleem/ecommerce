@extends('dashboard.layout.main')
@section('title', 'View Blog')
@section('dashboard')
    <div class="container mt-2">
        <h2 class="mb-2">{{ $blog->title }}</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5><strong>Author:</strong></h5>
                <p>{{ $blog->author }}</p>

                <h5><strong>Published:</strong></h5>
                <p>{{ $blog->published_at ?? 'N/A' }}</p>

                <h5><strong>Excerpt:</strong></h5>
                <p>{{ $blog->excerpt }}</p>

                <h5><strong>Content:</strong></h5>
                <p>{!! $blog->content !!}</p>

                <h5><strong>Categories:</strong></h5>
                <p>
                    @if (!empty($categoryNames))
                        @foreach ($categoryNames as $category)
                            <span class="badge bg-info me-1">{{ $category }}</span>
                        @endforeach
                    @else
                        N/A
                    @endif
                </p>
                <h5><strong>Tags:</strong></h5>
                <p>
                    @if (!empty($tagNames))
                        @foreach ($tagNames as $tag)
                            <span class="badge bg-info me-1">{{ $tag }}</span>
                        @endforeach
                    @else
                        N/A
                    @endif
                </p>

                <h5 class="mt-4"><strong>Images:</strong></h5>
                <div class="row">
                    @if (!empty($blog->images))
                        @foreach ($blog->images as $image)
                            @if (is_string($image) && !empty($image))
                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    <div class="border rounded shadow-sm p-2 bg-light h-100">
                                        <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded"
                                            alt="Blog Image">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p>No images uploaded.</p>
                    @endif
                </div>

                <h5><strong>Status:</strong></h5>
                <p>{{ $blog->status ? 'Active' : 'Inactive' }}</p>

                <div class="mt-3">
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Back</a>
                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
        </div>
    </div>
@endsection
