@extends('dashboard.layout.main')
@section('title', 'View Category')
@section('dashboard')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Category Details</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name:</label>
                                <div>{{ $category->name }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status:</label>
                                <div>
                                    @if($category->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to Categories</a>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>
@endsection
