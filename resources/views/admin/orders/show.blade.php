@extends('dashboard.layout.main')
@section('title', 'View Order')
@section('dashboard')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Order #{{ $order->id }} Details</h4>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-light">← Back to Orders</a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>User:</strong> {{ $order->user->name ?? 'Guest' }}</p>
                    <p><strong>Placed At:</strong> {{ $order->created_at->format('d M Y h:i A') }}</p>
                    <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                    <p>
                        <strong>Payment Status:</strong>
                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning text-dark' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Total:</strong> <span class="text-success">${{ number_format($order->total, 2) }}</span></p>
                    <p>
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>
            </div>

            <h5 class="border-bottom pb-2 mb-3">Ordered Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price (Each)</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product?->name ?? 'Product Deleted' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-4">
                <h5>Total Amount: <span class="text-primary">${{ number_format($order->total, 2) }}</span></h5>
            </div>
        </div>
    </div>
</div>
@endsection
