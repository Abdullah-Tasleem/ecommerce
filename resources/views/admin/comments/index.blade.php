@extends('dashboard.layout.main')

@section('title', 'Comments')

@section('dashboard')
    <div class="container py-4">
        <h1 class="mb-4">Comments</h1>
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Blog</th>
                        <th>Author</th>
                        <th>Email</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comments as $comment)
                        <tr>
                            <td>{{ $loop->iteration + ($comments->currentPage() - 1) * $comments->perPage() }}</td>
                            <td>{{ $comment->blog->title ?? 'N/A' }}</td>
                            <td>{{ $comment->name }}</td>
                            <td>{{ $comment->email }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($comment->comment, 60) }}</td>
                            <td>
                                @php
                                    $badge =
                                        [
                                            'approved' => 'success',
                                            'pending' => 'warning',
                                            'spam' => 'danger',
                                        ][$comment->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ ucfirst($comment->status) }}</span>
                            </td>
                            <td>{{ $comment->created_at->format('d M Y, h:i A') }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.comments.show', $comment->id) }}"
                                    class="btn btn-sm btn-secondary">View</a>
                                <a href="{{ route('admin.comments.edit', $comment->id) }}"
                                    class="btn btn-sm btn-success">Edit</a>
                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No comments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $comments->withQueryString()->links() }}
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
        setTimeout(() => {
            const successMsg = document.getElementById('successMessage');
            const errorMsg = document.getElementById('errorMessage');

            if (successMsg) {
                successMsg.classList.add('fade');
                setTimeout(() => successMsg.remove(), 500);
            }
            if (errorMsg) {
                errorMsg.classList.add('fade');
                setTimeout(() => errorMsg.remove(), 500);
            }
        }, 3000);
    </script>
@endpush
