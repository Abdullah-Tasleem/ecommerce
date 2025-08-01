@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Orders</h2>

    @if($orders->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>Rs. {{ $order->total }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No orders found.</p>
    @endif
</div>
@endsection
