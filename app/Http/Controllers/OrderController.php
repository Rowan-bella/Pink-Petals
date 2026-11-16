<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment; 
use Barryvdh\DomPDF\Facade\Pdf; 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusMail;
class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['payment', 'items.product'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'payment', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        $payment = Payment::where('order_id', $order->id)->first();
        if ($payment) {
            $payment->update(['status' => $request->status]);
        }
        
        if (in_array($request->status, ['approved', 'delivered'])) {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new OrderStatusMail($order));
            }
        }

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function userOrders()
    {
        $orders = Order::with(['payment', 'items.product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('admin.users.orders', compact('orders'));
    }

    public function userReceived($id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        
        if ($order->status == 'delivered') {
            $order->update(['status' => 'received']);
            if ($order->payment) {
                $order->payment->update(['status' => 'received']);
            }
        }

        return back()->with('success', 'ပစ္စည်းလက်ခံရရှိကြောင်း အတည်ပြုပြီးပါပြီ။');
    }

    public function downloadPdf($id)
    {
        $order = Order::with(['user', 'payment', 'items.product'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $pdf = Pdf::loadView('pdf.invoice', compact('order'));
        return $pdf->stream('Invoice-Order-#' . $order->id . '.pdf');
    }

    public function export()
    {
        return Excel::download(new OrdersExport, 'customer-orders.xlsx');
    }
    
    }

