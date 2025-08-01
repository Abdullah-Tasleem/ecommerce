@extends('dashboard.layout.main')

@section('title', 'Edit Comment')

@section('dashboard')
    <div class="container py-4">
        <h1 class="mb-4">Edit Comment #{{ $comment->id }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There are some errors:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST" class="card">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Blog</label>
                    <input type="text" class="form-control" value="{{ $comment->blog->title ?? 'N/A' }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Author Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $comment->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Author Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $comment->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Comment</label>
                    <textarea name="comment" rows="5" class="form-control @error('comment') is-invalid @enderror">{{ old('comment', $comment->comment) }}</textarea>
                    @error('comment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="pending" {{ old('status', $comment->status) == 'pending' ? 'selected' : '' }}>
                            Pending</option>
                        <option value="approved" {{ old('status', $comment->status) == 'approved' ? 'selected' : '' }}>
                            Approved</option>
                        <option value="spam" {{ old('status', $comment->status) == 'spam' ? 'selected' : '' }}>Spam
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card-footer d-flex gap-2">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
