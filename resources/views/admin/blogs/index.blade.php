@extends('dashboard.layout.main')
@section('title', 'Blogs')
@section('dashboard')
    <div class="container">
        <h2 class="mt-2">Blog List</h2>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary mb-3">Create New Blog</a>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <table id="datatable" class="table table-bordered text-center">
            <thead class="text-center">
                <tr>
                    <th class="text-center">Title</th>
                    <th class="text-center">Published At</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->published_at }}</td>
                        <td>
                            @if ($blog->images)
                                @foreach ($blog->images as $img)
                                    <img src="{{ asset('storage/' . $img) }}" alt="Blog Image"
                                        style="width: 60px; height: 60px; object-fit: cover; margin: 2px;">
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $blog->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
                                style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
        // Auto-hide success message
        setTimeout(() => {
            const msg = document.getElementById('successMessage');
            if (msg) {
                msg.classList.add('fade');
                setTimeout(() => msg.remove(), 500);
            }
        }, 3000);
    </script>
@endpush
