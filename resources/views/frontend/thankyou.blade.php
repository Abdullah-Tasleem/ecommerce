@extends('frontend.layout.main')

@section('section')
<div class="thankyou-container" style="padding: 40px; text-align: center;">
    <h1>Thank you for your order!</h1>
    <p>Your order number is:</p>
    <h2 style="color: green;">{{ $order->order_number }}</h2>

    <p>We’ve sent a confirmation to your email. You’ll be notified when your order ships.</p>
</div>
@if ($order->orderItems && $order->orderItems->count())
    <div class="container mt-5">
        <h3 class="text-center mb-4">Your Ordered Products</h3>
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

    <div class="thankyou-container" style="padding: 40px; text-align: center;">
        {{-- Show cancel button only if order is still pending --}}
        @if ($order->status === 'pending')
            <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger mb-3">Cancel Order</button>
            </form>
        @endif

        <a href="{{ route('home') }}" class="btn btn-success mt-2">Back to Home</a>
    </div>
@endif
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notyf = new Notyf();

        @if(session('success'))
            notyf.success(@json(session('success')));
        @endif

        @if(session('error'))
            notyf.error(@json(session('error')));
        @endif
    });
</script>
@endpush
