@extends('dashboard.layout.main')
@section('title', 'Orders')
@section('dashboard')
    <div class="container mt-3">
        <h2>All Orders</h2>
        <div class="d-flex gap-2 mb-3">
            <a href="{{ route('admin.orders.export.pdf') }}" class="btn btn-primary">Export to PDF</a>
            <a href="{{ route('admin.orders.export.csv') }}" class="btn btn-success">Export to CSV</a>
            <div id="datatable-buttons"></div>
        </div>
        <table id="ordersTable" class="table table-bordered ">
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
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                        <td>${{ $order->total }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ strtoupper($order->payment_method) }}</td>
                        <td>
                            @if ($order->payment_status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-secondary">View</a>
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-success">Change
                                Status</a>

                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                style="display:inline;">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#ordersTable').DataTable({
                pageLength: 10,
                order: [
                    [0, "desc"]
                ],
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }],
                buttons: [{
                    extend: 'excelHtml5',
                    text: 'Export Google Sheet (Excel)',
                    className: 'btn btn-info'
                }],
                dom: '<"top d-flex justify-content-between align-items-center mb-2"lfB>rtip'
            });


            // Button ko apne custom div me move karna
            table.buttons().container().appendTo('#datatable-buttons');
        });
    </script>
@endpush
