<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">
                    Order Details <span class="text-muted">#{{ $order->id }}</span>
                </h2>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">← Back</a>
            </div>

            <div class="card-body">
                @php
                    $status = strtolower($order->status ?? 'pending');
                    $badgeMap = [
                        'pending' => 'bg-warning text-dark',
                        'processing' => 'bg-info text-dark',
                        'shipped' => 'bg-primary',
                        'completed' => 'bg-success',
                        'cancelled' => 'bg-danger',
                        'failed' => 'bg-danger',
                        'refunded' => 'bg-secondary',
                    ];
                    $badgeClass = $badgeMap[$status] ?? 'bg-secondary';
                @endphp

                <div class="row g-4">
                    <div class="col-md-12">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Status</span>
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total</span>
                                <strong>Rs. {{ number_format($order->total, 2) }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Ordered At</span>
                                <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </li>

                            @if (!empty($order->payment_method))
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Payment</span>
                                    <span class="text-capitalize">{{ $order->payment_method }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="col-md-6">
                        @if (!empty($order->shipping_name) || !empty($order->shipping_address))
                            <div class="border rounded p-3 h-100">
                                <h6 class="mb-2">Shipping</h6>
                                <div class="small text-muted">
                                    @if (!empty($order->shipping_name))
                                        <div>{{ $order->shipping_name }}</div>
                                    @endif
                                    @if (!empty($order->shipping_phone))
                                        <div>{{ $order->shipping_phone }}</div>
                                    @endif
                                    @if (!empty($order->shipping_address))
                                        <div>{{ $order->shipping_address }}</div>
                                    @endif
                                    @if (!empty($order->shipping_city) || !empty($order->shipping_postal))
                                        <div>{{ $order->shipping_city }} {{ $order->shipping_postal }}</div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
