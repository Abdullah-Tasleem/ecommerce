<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,canceled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'Order deleted successfully!');
    }
    public function exportPdf()
    {
        require(app_path('Libraries/fpdf.php'));

        $orders = Order::with('user')->get();

        $pdf = new \FPDF();
        $pdf->AddPage();

        // Title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Orders Report', 0, 1, 'C');
        $pdf->Ln(10);

        // Table Header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, 'ID', 1);
        $pdf->Cell(40, 10, 'User', 1);
        $pdf->Cell(25, 10, 'Total', 1);
        $pdf->Cell(25, 10, 'Status', 1);
        $pdf->Cell(30, 10, 'Payment', 1);
        $pdf->Cell(30, 10, 'Placed At', 1);
        $pdf->Ln();

        // Table Rows
        $pdf->SetFont('Arial', '', 9);
        foreach ($orders as $order) {
            $pdf->Cell(15, 10, $order->id, 1);
            $pdf->Cell(40, 10, $order->user->name ?? 'Guest', 1);
            $pdf->Cell(25, 10, '$' . $order->total, 1);
            $pdf->Cell(25, 10, ucfirst($order->status), 1);
            $pdf->Cell(30, 10, strtoupper($order->payment_method), 1);
            $pdf->Cell(30, 10, $order->created_at->format('d M Y'), 1);
            $pdf->Ln();
        }

        $pdf->Output('D', 'orders_report.pdf');
        exit;
    }

    public function exportCsv()
    {
        $fileName = 'orders.csv';
        $orders = Order::with('user')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'User', 'Total', 'Status', 'Payment Method', 'Payment Status', 'Placed At'];

        $callback = function () use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->user->name ?? 'Guest',
                    $order->total,
                    ucfirst($order->status),
                    strtoupper($order->payment_method),
                    ucfirst($order->payment_status),
                    $order->created_at->format('d M Y'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
