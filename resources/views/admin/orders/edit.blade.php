@extends('dashboard.layout.main')
@section('title', 'Edit Order')
@section('dashboard')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Order #{{ $order->id }}</h4>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-light">← Back to Orders</a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label"><strong>Status</strong></label>
                    <select name="status" class="form-select">
                        @foreach(['pending', 'processing', 'shipped', 'delivered', 'canceled'] as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Payment Method</strong></label>
                    <select name="payment_method" class="form-select">
                        @foreach(['cod', 'stripe'] as $method)
                            <option value="{{ $method }}" {{ $order->payment_method === $method ? 'selected' : '' }}>
                                {{ strtoupper($method) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Payment Status</strong></label>
                    <select name="payment_status" class="form-select">
                        @foreach(['unpaid', 'paid'] as $status)
                            <option value="{{ $status }}" {{ $order->payment_status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">Update Order</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
