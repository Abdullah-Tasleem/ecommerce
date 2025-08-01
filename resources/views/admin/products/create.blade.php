@extends('dashboard.layout.main')
@section('title', 'Create Product')

@section('dashboard')
    <div class="container mt-4">
        <h2>Add New Product</h2>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorMessage">
                <strong>Validation Errors:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Product Form --}}
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Basic Info --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="Enter product name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Slug</label>
                    <input type="text" name="slug" placeholder="Auto-generated if left blank" class="form-control" value="{{ old('slug') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Regular Price</label>
                    <input type="number" step="0.01" name="regular_price" class="form-control" value="{{ old('regular_price') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Sale Price</label>
                    <input type="number" step="0.01" name="sale_price" placeholder="Optional sale price" class="form-control" value="{{ old('sale_price') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Discount (%)</label>
                    <input type="number" name="off" placeholder="Discount percentage" class="form-control" value="{{ old('off') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}">
                </div>
            </div>

            {{-- Excerpt & Description --}}
            <div class="mb-3">
                <label>Excerpt</label>
                <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
            </div>

            {{-- Categories --}}
            <div class="mb-3">
                <label>Categories</label>
                <select name="categories[]" class="form-control selectpicker" multiple data-live-search="true">
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}" {{ in_array($id, old('categories', [])) ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tags --}}
            <div class="mb-3">
                <label>Tags</label>
                <select name="tags[]" class="form-control selectpicker" multiple data-live-search="true">
                    @foreach ($tags as $id => $name)
                        <option value="{{ $id }}" {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Rating & Status --}}
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Rating</label>
                    <input type="number" step="0.1" name="rating" class="form-control" value="{{ old('rating', 0) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Review Count</label>
                    <input type="number" name="review_count" class="form-control" value="{{ old('review_count', 0) }}">
                </div>

                <div class="col-md-2 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label>Feature</label>
                    <select name="feature" class="form-control">
                        <option value="1" {{ old('feature', 1) == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('feature', 1) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>
                {{-- Images --}}
            <div class="mb-3">
                <label>Images</label>
                <input type="file" name="images[]" id="imagesInput" class="form-control" multiple>
                <div class="row mt-2" id="imagePreviewContainer"></div>
            </div>


            <button type="submit" class="btn btn-success">Create Product</button>
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
        $(document).ready(function () {
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

        imageInput.addEventListener('change', function () {
            previewContainer.innerHTML = '';
            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function (e) {
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

