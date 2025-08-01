@extends('dashboard.layout.main')
@section('title', 'Coupons')
@section('dashboard')
    <div class="container mt-3">
        <h2>All Coupons</h2>
        <a href="{{ route('coupons.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Add New Coupon
        </a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Usage Limit</th>
                        <th>Status</th>
                        <th>Expires At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->name }}</td>
                            <td>{{ ucfirst($coupon->discount_type) }}</td>
                            <td>
                                {{ $coupon->discount_type === 'percent' ? $coupon->discount_value . '%' : 'Rs ' . number_format($coupon->discount_value, 2) }}
                            </td>
                            <td>
                                {{ $coupon->usage_limit ?? '∞' }}
                            </td>
                            <td>
                                @if ($coupon->status === 'active' || $coupon->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                {{ $coupon->end_date ? \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d') : '—' }}
                            </td>
                            <td>
                                <a href="{{ route('coupons.show', $coupon->code) }}" class="btn btn-sm btn-secondary">View</a>
                                <a href="{{ route('coupons.edit', ['coupon' => $coupon->code]) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('coupons.destroy', ['code' => $coupon->code]) }}" method="POST"
                                    style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No coupons found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
    <script>
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
