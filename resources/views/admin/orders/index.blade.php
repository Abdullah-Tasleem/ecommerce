@extends('dashboard.layout.main')
@section('title', 'Orders')
@section('dashboard')
<div class="container mt-4">
    <h2>All Orders</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#ID</th>
                <th>User</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Placed At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name ?? 'Guest' }}</td>
                <td>${{ $order->total }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ strtoupper($order->payment_method) }}</td>
                <td>
                    @if($order->payment_status === 'paid')
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-secondary">View</a>
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-success">Change Status</a>

                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
