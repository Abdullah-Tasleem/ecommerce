<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>
    <div class="container">
        @if ($orders->count())
            <table id="ordersTable" class="table table-bordered table-striped align-middle text-center">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ ucfirst($order->status) }}</td>

                            <td data-order="{{ $order->total }}">
                                Rs. {{ number_format($order->total, 2) }}
                            </td>

                            <td data-order="{{ $order->created_at->timestamp }}">
                                {{ $order->created_at->format('d M Y') }}
                            </td>

                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No orders found.</p>
        @endif
    </div>

    @push('scripts')
        {{-- jQuery + DataTables --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(function() {
                const dt = $('#ordersTable').DataTable({
                    order: [
                        [0, 'desc']
                    ], // Default: Order ID desc
                    columnDefs: [{
                            targets: -1,
                            orderable: false,
                            searchable: false
                        } // Action col not sortable
                    ],
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'All']
                    ],
                    pageLength: 10,
                    language: {
                        emptyTable: 'No orders found.'
                    }
                });

                // Search input placeholder
                $('#ordersTable_filter input').attr('placeholder', 'Search orders...');
            });
        </script>
    @endpush

</x-app-layout>
