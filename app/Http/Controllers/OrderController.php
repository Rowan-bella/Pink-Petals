<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment; // 💡 Payment Model ကို use လုပ်ရန်

class OrderController extends Controller
{
    // Admin / Manager များအတွက် Order စာရင်းပြရန်
    public function index()
    {
        // Orders များကို Payment နှင့် User အချက်အလက်များပါ တွဲခေါ်မည်
        $orders = Order::with(['payment', 'items.product'])->latest()->paginate(10);
        
        return view('admin.orders.index', compact('orders'));
    }

    // Order Status အပြောင်းအလဲကို သိမ်းဆည်းရန်
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        
        // ၁။ Orders table ထဲရှိ status ကို Admin ရွေးလိုက်သည့် တန်ဖိုးအတိုင်း အပ်ဒိတ်လုပ်မည်
        if($request->has('status')) {
            $order->update(['status' => $request->status]);

            // ၂။ 💡 သက်ဆိုင်ရာ Payments table ထဲရှိ status ကိုပါ တစ်ခါတည်း လိုက်လံ အပ်ဒိတ်လုပ်မည်
            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment) {
                $payment->update(['status' => $request->status]);
            }
        }

        return back()->with('success', 'Order status updated successfully.');
    }
}