@extends('dashboard.layout.main')
@section('title', 'Create Tags')
@section('dashboard')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">

                                {{-- ✅ Success Message --}}
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- ✅ Validation Error Alert --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>There were some problems with your input:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('tags.store') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-success">Create</button>
                                    <a href="{{ route('tags.index') }}" class="btn btn-secondary">Cancel</a>
                                </form>
                            </div> <!-- end col -->
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div>
@endsection

@section('scripts')
<script>
    // ✅ Auto-hide success alert after 3 seconds
    setTimeout(() => {
        const successBox = document.getElementById('successMessage');
        if (successBox) {
            successBox.style.transition = 'opacity 0.5s ease';
            successBox.style.opacity = 0;
            setTimeout(() => successBox.remove(), 500);
        }
    }, 3000);
</script>
@endsection
