@extends('dashboard.layout.main')
@section('title', 'Edit Category')
@section('dashboard')
<div class="container">
   <h2>Edit Category</h2>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}">
            @error('name') <div class="text-danger error-message">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ $category->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$category->status ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <div class="text-danger error-message">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    setTimeout(() => {
        document.querySelectorAll('.error-message').forEach(el => {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity = 0;
            setTimeout(() => el.remove(), 500);
        });
    }, 3000);
</script>
@endsection
