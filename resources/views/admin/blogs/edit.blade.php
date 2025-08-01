@extends('dashboard.layout.main')
@section('title', 'Edit Blog')
@section('dashboard')
    <div class="container">
        <h2 class="mt-2">Edit Blog</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
            </div>

            <!-- Slug -->
            <div class="mb-3">
                <label>Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $blog->slug) }}">
            </div>

            <!-- Author -->
            <div class="mb-3">
                <label>Author</label>
                <input type="text" name="author" class="form-control" value="{{ old('author', $blog->author) }}">
            </div>

            <!-- Categories (Multiple Select) -->
            <div class="mb-3">
                <label>Categories</label>
                <select name="categories[]" id="categories" class="form-control" multiple>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}"
                            {{ in_array($id, old('categories', $blog->categories ?? [])) ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Excerpt -->
            <div class="mb-3">
                <label>Excerpt</label>
                <textarea name="excerpt" class="form-control">{{ old('excerpt', $blog->excerpt) }}</textarea>
            </div>

            <!-- Content -->
            <div class="mb-3">
                <label>Content</label>
                <textarea id="content" name="content" class="form-control" rows="6">{{ old('content', $blog->content) }}</textarea>
            </div>

            <!-- Tags -->
            <div class="mb-3">
                <label>Tags</label>
                <select name="tags[]" id="tags" class="form-control" multiple>
                    @foreach ($tags as $id => $name)
                        <option value="{{ $id }}"
                            {{ in_array($id, old('tags', $blog->tags ?? [])) ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ old('status', $blog->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $blog->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Images -->
            <div class="mb-3">
                <label>Images (add or remove)</label>
                <input type="file" name="images[]" class="form-control" multiple>
                @if (!empty($blog->images))
                    <div class="mt-2 d-flex flex-wrap gap-3">
                        @foreach ($blog->images as $image)
                            <div class="position-relative text-center">
                                <img src="{{ asset('storage/' . $image) }}" width="100" class="rounded shadow mb-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="delete_images[]"
                                        value="{{ $image }}">
                                    <small>Delete</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
@push('script')
    <script src="https://cdn.tiny.cloud/1/q7713k7rim7e35m6va2uiuexqf9ra7u16iwqv4wezqv2qbnd/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            plugins: 'image media link code table lists advlist autolink charmap preview anchor pagebreak searchreplace wordcount visualblocks fullscreen insertdatetime media table emoticons help',
            toolbar: 'undo redo | formatselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image media link | code preview',
            automatic_uploads: true,
            images_upload_url: '{{ route('tinymce.upload') }}', // Laravel route
            file_picker_types: 'image media',
            relative_urls: false,
            convert_urls: false,
            file_picker_callback: function(callback, value, meta) {
                let input = document.createElement('input');
                input.setAttribute('type', 'file');
                if (meta.filetype === 'image') {
                    input.setAttribute('accept', 'image/*');
                } else if (meta.filetype === 'media') {
                    input.setAttribute('accept', 'video/*,audio/*');
                }
                input.onchange = function() {
                    let file = this.files[0];
                    let formData = new FormData();
                    formData.append('file', file);

                    fetch('{{ route('tinymce.upload') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            callback(data.location);
                        });
                };
                input.click();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tags').select2({
                placeholder: "Select tags",
                allowClear: true
            });

            $('select[name="categories[]"]').select2({
                placeholder: "Select categories",
                allowClear: true
            });

            // Image Preview
            $('#images').on('change', function() {
                $('#image-preview').html(''); // Clear previous previews
                Array.from(this.files).forEach(file => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-preview').append(
                            `<div class="m-1">
                                <img src="${e.target.result}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                             </div>`
                        );
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
@endpush
