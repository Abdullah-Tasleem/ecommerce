@extends('dashboard.layout.main')
@section('title', 'Categories')
@section('dashboard')
    <div class="container mt-2">
        <h2>All Categories</h2>

        <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">+ Add New Category</a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table id="datatable" class="table table-striped text-center align-middle">
            <thead class="text-center">
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="text-center">
                @forelse ($categories as $category)
                    <tr>
                        <td class="text-center">{{ $category->name }}</td>
                        <td class="text-center">
                            @if ($category->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('categories.show', $category->id) }}"
                                class="btn btn-sm btn-secondary">View</a>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-success">Edit</a>
                            <form method="POST" action="{{ route('categories.destroy', $category->id) }}"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

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
