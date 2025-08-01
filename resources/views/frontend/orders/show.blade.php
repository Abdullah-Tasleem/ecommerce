<div class="container py-5">
    <h2>Order Details (#{{ $order->id }})</h2>

    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
    <p><strong>Ordered At:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

    {{-- Add more details here, like product items if needed --}}
</div>
