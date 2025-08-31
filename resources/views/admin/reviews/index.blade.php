@extends('dashboard.layout.main')
@section('title', 'Reviews')
@section('dashboard')
    <div class="container mt-4">
        <h2>All Reviews</h2>

        @if (session('success'))
            <div class="alert alert-success" id="successMessage">{{ session('success') }}</div>
        @endif

        <table id="datatable" class="table table-bordered">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>
                            {{ $review->user_name }}<br>
                            <small class="text-muted">{{ $review->user_email }}</small>
                        </td>
                        <td>{{ $review->product->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $review->rating }} / 5</span>
                        </td>
                        <td>{{ Str::limit($review->review, 50) }}</td>
                        <td>{{ $review->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                                style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $reviews->links() }}
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
