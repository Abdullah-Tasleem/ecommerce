@extends('dashboard.layout.main')
@section('title', 'View Products')
@section('dashboard')
    <div class="container mt-4">
        <h2>View Product</h2>

        <div class="card">
            <div class="card-body">
                <h4>Name:</h4>
                <p>{{ $product->name }}</p>

                <h4>Slug:</h4>
                <p>{{ $product->slug }}</p>

                <h4>Regular Price:</h4>
                <p>{{ $product->regular_price }}</p>

                <h4>Sale Price:</h4>
                <p>{{ $product->sale_price }}</p>

                <h4>Off (%):</h4>
                <p>{{ $product->off ?? 'N/A' }}%</p>

                <h4>Categories:</h4>
                <p>
                    @forelse ($categoryNames as $category)
                        <span class="badge bg-info">{{ $category }}</span>
                    @empty
                        N/A
                    @endforelse
                </p>

                <h4>Tags:</h4>
                <p>
                    @forelse ($tagNames as $tag)
                        <span class="badge bg-primary">{{ $tag }}</span>
                    @empty
                        N/A
                    @endforelse
                </p>

                <h4>Rating:</h4>
                <p>{{ $product->rating ?? 'N/A' }} / 5</p>

                <h4>Review Count:</h4>
                <p>{{ $product->review_count ?? 'N/A' }}</p>

                <h4>Status:</h4>
                <p>{{ $product->status ? 'Active' : 'Inactive' }}</p>

                <h4>Excerpt:</h4>
                <p>{{ $product->excerpt }}</p>

                <h4>Description:</h4>
                <p>{{ $product->description }}</p>

                <h4>Stock:</h4>
                <p>{{ $product->stock }}</p>

                <h4>Feature:</h4>
                <p>{{ $product->feature ?? 'N/A' }}</p>

                <div class="mb-4">
                    <h5 class="fw-bold">Images:</h5>
                    <div class="row">
                        @forelse ($product->images as $image)
                            @if (is_string($image) && !empty($image))
                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    <div class="border rounded shadow-sm p-2 h-100 bg-light">
                                        <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded"
                                            alt="Product Image">
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p>No images available.</p>
                        @endforelse
                    </div>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
@endsection
