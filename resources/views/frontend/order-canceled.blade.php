@extends('frontend.layout.main')

@section('section')
    <div class="text-center py-5">
        <h1 class="text-danger">Order Canceled</h1>
        <p>Your order has been successfully canceled. If this was a mistake, please contact our support.</p>
    </div>

    @if ($order->orderItems && $order->orderItems->count())
        <div class="container mt-5">
            <h3 class="text-center mb-4">Canceled Products</h3>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="text-center py-5">
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Go Back to Home</a>
    </div>
@endsection
