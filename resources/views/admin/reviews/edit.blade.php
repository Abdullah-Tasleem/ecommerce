@extends('dashboard.layout.main')
@section('title', 'Edit Review')
@section('dashboard')
<h2 class="mt-3">Edit Review</h2>

<form action="{{ route('admin.reviews.update', $review) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Rating</label>
        <input type="number" name="rating" class="form-control" value="{{ old('rating', $review->rating) }}" min="1" max="5" required>
    </div>

    <div class="mb-3">
        <label>Review</label>
        <textarea name="review" class="form-control" rows="5">{{ old('review', $review->review) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Review</button>
    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Cancel</a>

</form>
@endsection
