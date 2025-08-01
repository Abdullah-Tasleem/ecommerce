@extends('dashboard.layout.main')

@section('title', 'View Comment')

@section('dashboard')
<div class="container py-4">
    <h1 class="mb-4">Comment #{{ $comment->id }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Blog:</strong> {{ $comment->blog->title ?? 'N/A' }}</p>
            <p><strong>Author:</strong> {{ $comment->name }} ({{ $comment->email }})</p>
            <p><strong>Status:</strong>
                <span class="badge bg-{{ $comment->status === 'approved' ? 'success' : ($comment->status === 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($comment->status) }}
                </span>
            </p>
            <p><strong>Created At:</strong> {{ $comment->created_at->format('d M Y, h:i A') }}</p>
            <hr>
            <p><strong>Comment:</strong></p>
            <div class="p-3 bg-light rounded border">{{ $comment->comment }}</div>
        </div>
    </div>

    <a href="{{ route('admin.comments.edit', $comment->id) }}" class="btn btn-secondary">Edit</a>
    <a href="{{ route('admin.comments.index') }}" class="btn btn-primary">Back</a>
</div>
@endsection
