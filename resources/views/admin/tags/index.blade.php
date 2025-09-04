@extends('dashboard.layout.main')
@section('title', 'Tags')
@section('dashboard')
    <div class="container mt-2">
        <h2>All Tags</h2>

        <a href="{{ route('tags.create') }}" class="btn btn-success mb-3">+ Add New Tag</a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table id="datatable" class="table table-bordered text-center align-middle">
            <thead class="text-center">
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($tags as $tag)
                    <tr>
                        <td>{{ $tag->name }}</td>
                        <td>
                            @if ($tag->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-sm btn-success">Edit</a>
                            <form method="POST" action="{{ route('tags.destroy', $tag->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No tags found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $tags->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
        // Auto-hide success message after 3 seconds
        setTimeout(() => {
            const alert = document.getElementById('successMessage');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);
    </script>
@endpush
