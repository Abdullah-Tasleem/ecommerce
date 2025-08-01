@extends('dashboard.layout.main')
@section('title', 'View Review')
@section('dashboard')
<div class="container mt-4">
    <h2 class="mb-4">Review Details</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Review #{{ $review->id }}</h5>

            <dl class="row">
                <dt class="col-sm-3">User Name</dt>
                <dd class="col-sm-9">{{ $review->user_name }}</dd>

                <dt class="col-sm-3">User Email</dt>
                <dd class="col-sm-9">{{ $review->user_email }}</dd>

                <dt class="col-sm-3">Product</dt>
                <dd class="col-sm-9">{{ $review->product->name ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Rating</dt>
                <dd class="col-sm-9">
                    @for($i=1; $i<=5; $i++)
                        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                    @endfor
                    <span class="badge bg-primary ms-2">{{ $review->rating }} / 5</span>
                </dd>

                <dt class="col-sm-3">Review Text</dt>
                <dd class="col-sm-9">{{ $review->review }}</dd>

                @if($review->admin_reply)
                <dt class="col-sm-3">Admin Reply</dt>
                <dd class="col-sm-9">{{ $review->admin_reply }}</dd>
                @endif

                <dt class="col-sm-3">Submitted At</dt>
                <dd class="col-sm-9">{{ $review->created_at->format('d M Y, h:i A') }}</dd>
            </dl>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
