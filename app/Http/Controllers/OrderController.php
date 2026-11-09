<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment; 
class OrderController extends Controller
{
    public function index()
    {

        $orders = Order::with(['payment', 'items.product'])->latest()->paginate(10);
        
        return view('admin.orders.index', compact('orders'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        if($request->has('status')) {
            $order->update(['status' => $request->status]);
            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment) {
                $payment->update(['status' => $request->status]);
            }
        }

        return back()->with('success', 'Order status updated successfully.');
    }
}