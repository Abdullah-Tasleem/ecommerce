@extends('dashboard.layout.main')
@section('title', 'Edit Product')

@section('dashboard')
    <div class="container mt-4">
        <h2>Edit Product</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control"
                        value="{{ old('slug', $product->slug ?? '') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Price</label>
                    <input type="number" name="regular_price" class="form-control"
                        value="{{ old('regular_price', $product->regular_price ?? '') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Sale Price</label>
                    <input type="number" name="sale_price" class="form-control"
                        value="{{ old('sale_price', $product->sale_price ?? '') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control"
                        value="{{ old('stock', $product->stock ?? '') }}">
                </div>

                <div class="col-12 mb-3">
                    <label>Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $product->excerpt ?? '') }}</textarea>
                </div>

                <div class="col-12 mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Rating</label>
                    <input type="number" step="0.1" name="rating" class="form-control"
                        value="{{ old('rating', $product->rating ?? '') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Review Count</label>
                    <input type="number" name="review_count" class="form-control"
                        value="{{ old('review_count', $product->review_count ?? '') }}">
                </div>

                <div class="col-12 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status', $product->status ?? 1) == 1 ? 'selected' : '' }}>Active
                        </option>
                        <option value="0" {{ old('status', $product->status ?? 1) == 0 ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label>Categories</label>
                    <select name="categories[]" class="form-control selectpicker" multiple data-live-search="true">
                        @foreach ($categories as $id => $name)
                            <option value="{{ $id }}"
                                {{ in_array($id, $selectedCategories) ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label>Tags</label>
                    <select name="tags[]" class="form-control selectpicker" multiple data-live-search="true">
                        @foreach ($tags as $id => $name)
                            <option value="{{ $id }}" {{ in_array($id, $selectedTags) ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label>Images</label>
                    <input type="file" id="imagesInput" name="images[]" class="form-control" multiple>

                    @if (!empty($product->images))
                        <div class="mt-3 d-flex flex-wrap gap-2" id="imagePreviewContainer">
                            @foreach ($product->images as $image)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Image" width="120"
                                        height="120" class="img-thumbnail rounded shadow">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Hide error alert after 4 seconds
        setTimeout(() => {
            const alert = document.getElementById('errorMessage');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500);
            }
        }, 4000);

        // Initialize Select2
        $(document).ready(function() {
            $('select[name="categories[]"]').select2({
                placeholder: "Select categories",
                allowClear: true,
                width: '100%'
            });

            $('select[name="tags[]"]').select2({
                placeholder: "Select tags",
                allowClear: true,
                width: '100%'
            });
        });

        // Image preview
        const imageInput = document.getElementById('imagesInput');
        const previewContainer = document.getElementById('imagePreviewContainer');

        imageInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.classList.add('col-md-3', 'mb-2');
                    col.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" class="img-fluid rounded shadow">
                            <span class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image" style="z-index:1;">&times;</span>
                        </div>`;
                    previewContainer.appendChild(col);

                    col.querySelector('.remove-image').addEventListener('click', () => {
                        imageInput.value = '';
                        col.remove();
                    });
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
