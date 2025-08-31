@extends('dashboard.layout.main')
@section('title', 'Create Category')
@section('dashboard')
<div class="container-fluid">
   <h2 class="mt-2">Create Category</h2>
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form method="POST" action="{{ route('categories.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="example-select" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Create</button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
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
