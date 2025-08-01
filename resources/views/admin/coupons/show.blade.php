@extends('dashboard.layout.main')
@section('title', 'View Coupon')
@section('dashboard')
    <div class="container mt-4">
        <h2>Coupon Details</h2>
        <div class="card">
            <div class="card-body">

                <h5 class="card-title">{{ $coupon->name }} ({{ $coupon->code }})</h5>
                <p class="card-text"><strong>Description:</strong> {{ $coupon->description ?? '—' }}</p>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Type:</strong> {{ ucfirst($coupon->discount_type) }}</li>
                    <li class="list-group-item"><strong>Value:</strong>
                        {{ $coupon->discount_type === 'percent' ? $coupon->discount_value . '%' : 'Rs ' . number_format($coupon->discount_value, 2) }}
                    </li>
                    <li class="list-group-item"><strong>Max Discount Amount:</strong> Rs
                        {{ number_format($coupon->max_discount_amount ?? 0, 2) }}</li>
                    <li class="list-group-item"><strong>Minimum Cart Value:</strong> Rs
                        {{ number_format($coupon->min_cart_value ?? 0, 2) }}</li>
                    <li class="list-group-item"><strong>Start Date:</strong> {{ $coupon->start_date ?? '—' }}</li>
                    <li class="list-group-item"><strong>End Date:</strong> {{ $coupon->end_date ?? '—' }}</li>
                    <li class="list-group-item"><strong>Usage Limit:</strong> {{ $coupon->usage_limit ?? '∞' }}</li>
                    <li class="list-group-item"><strong>Limit Per User:</strong> {{ $coupon->limit_per_user ?? '—' }}</li>
                    <li class="list-group-item"><strong>Status:</strong>
                        <span class="badge {{ $coupon->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($coupon->status) }}
                        </span>
                    </li>
                    <li class="list-group-item"><strong>First Time Users Only:</strong>
                        {{ $coupon->first_time_users_only ? 'Yes' : 'No' }}</li>
                    <li class="list-group-item"><strong>Registered Users Only:</strong>
                        {{ $coupon->registered_users_only ? 'Yes' : 'No' }}</li>
                    <li class="list-group-item"><strong>Exclude Sale Items:</strong>
                        {{ $coupon->exclude_sale_items ? 'Yes' : 'No' }}</li>
                    <li class="list-group-item"><strong>Auto Apply:</strong> {{ $coupon->auto_apply ? 'Yes' : 'No' }}</li>
                    <li class="list-group-item"><strong>Eligible Categories:</strong>
                        @php
                            $eligibleCategoryIds = is_array($coupon->eligible_categories)
                                ? $coupon->eligible_categories
                                : json_decode($coupon->eligible_categories ?? '[]', true);
                            $eligibleCategoryIds = is_array($eligibleCategoryIds) ? $eligibleCategoryIds : [];
                            $eligibleCategoryNames = \App\Models\Category::whereIn('id', $eligibleCategoryIds)->pluck(
                                'name',
                            );
                        @endphp

                        @if ($eligibleCategoryNames->isNotEmpty())
                            <ul class="mb-0">
                                @foreach ($eligibleCategoryNames as $name)
                                    <li>{{ $name }}</li>
                                @endforeach
                            </ul>
                        @else
                            —
                        @endif
                    </li>
                    <li class="list-group-item"><strong>Created At:</strong> {{ $coupon->created_at->format('Y-m-d H:i') }}
                    </li>
                    <li class="list-group-item"><strong>Updated At:</strong> {{ $coupon->updated_at->format('Y-m-d H:i') }}
                    </li>
                </ul>
                <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Back to Coupons</a>
                <a href="{{ route('coupons.edit', $coupon->code) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
@endsection
