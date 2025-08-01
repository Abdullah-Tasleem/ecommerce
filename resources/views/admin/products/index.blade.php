@extends('dashboard.layout.main')
@section('title', 'Products')
@section('dashboard')
    <div class="container mt-4">
        <h2>All Products</h2>

        <a href="{{ route('products.create') }}" class="btn btn-success mb-3">+ Add New Product</a>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Products Table --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            {{-- <th>Slug</th> --}}
                            <th>Regular Price ($)</th>
                            <th>Sale ($)</th>
                            <th>Stock</th>
                            <th>Featured</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                        <td>{{ $product->name }}</td>
                        {{-- <td>
                            {{ Str::limit($product->slug, 20) }}
                            <span class="text-muted small d-block">{{ url('/products/' . $product->slug) }}</span>
                        </td> --}}
                        <td>{{ $product->regular_price }}</td>
                        <td>{{ $product->sale_price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->feature }}</td>
                        <td>
                            @php
                                $images = $product->images;
                            @endphp

                            @if (is_array($images))
                                @foreach ($images as $img)
                                    @if (is_string($img))
                                        <img src="{{ asset('storage/' . $img) }}" width="60" class="me-1">
                                    @endif
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $product->status ? 'success' : 'danger' }}">
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-secondary">View</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>

                            <form method="POST" action="{{ route('products.destroy', $product->id) }}"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        {{ $products->links() }}
    </div>
@endsection

@push('script')
    <script>
        // Hide success message after 3 seconds
        setTimeout(function() {
            const msg = document.getElementById('successMessage');
            if (msg) {
                msg.style.transition = 'opacity 0.5s ease';
                msg.style.opacity = 0;
                setTimeout(() => msg.remove(), 500); // Remove from DOM after fade
            }
        }, 3000);
    </script>
@endpush
