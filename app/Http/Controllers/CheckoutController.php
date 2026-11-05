<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $deliveryFee = 2000; 
        $grandTotal = $subtotal + $deliveryFee;

        return view('checkout.index', compact('cart', 'subtotal', 'deliveryFee', 'grandTotal'));
    }

    // ၁။ Shipping Form မှ data များကို လက်ခံပြီး Session တွင်သိမ်းကာ Payment Page သို့ Redirect မည် (POST)
    public function processShipping(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'delivery_area' => 'required',
            'address' => 'required|string',
        ]);

        $cart = session('cart', []);
        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $deliveryFee = (float) $request->delivery_area;
        $grandTotal = $subtotal + $deliveryFee;

        session([
            'checkout_data' => [
                'phone' => $request->phone,
                'delivery_area' => $deliveryFee,
                'address' => $request->address,
                'subtotal' => $subtotal,
                'grand_Total' => $grandTotal
            ]
        ]);

        return redirect()->route('checkout.payment');
    }

    // ၂။ Payment Page ကို (GET method ဖြင့်) ပြသပေးမည် (Refresh လုပ်လျှင် Error မတက်တော့ပါ)
    public function showPaymentForm()
    {
        $checkoutData = session('checkout_data');
        if (empty($checkoutData)) {
            return redirect()->route('checkout.index')->with('error', 'ကျေးဇူးပြု၍ ပထမဦးစွာ လိပ်စာဖြည့်ပါ။');
        }

        $grandTotal = $checkoutData['grand_Total'];

        return view('checkout.payment', compact('grandTotal'));
    }

    public function store(Request $request)
    {
        // 💡 KBZPay သို့မဟုတ် WavePay ရွေးလျှင် payment_slip ကို မဖြစ်မနေ တင်ရမည်ဟု စစ်ဆေးခြင်း
        $request->validate([
            'payment_method' => 'required|string',
            'payment_slip' => 'required_if:payment_method,kbzpay,wavepay|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'payment_slip.required_if' => 'ကျေးဇူးပြု၍ ငွေလွှဲပြေစာ (Screenshot) ပုံ တင်ပေးပါရန်။',
            'payment_slip.image' => 'တင်လိုက်သော ဖိုင်သည် ပုံဖြစ်ရပါမည်။',
            'payment_slip.mimes' => 'jpeg, png, jpg ပုံစံမျိုးသာ ဖြစ်ရပါမည်။',
            'payment_slip.max' => 'ပုံအရွယ်အစား 2MB ထက် မကြီးရပါ။',
        ]);

        $checkoutData = session('checkout_data');
        $cart = session('cart', []);

        if (empty($checkoutData) || empty($cart)) {
            return redirect()->route('shop.products')->with('error', 'ဝယ်ယူမှု အချက်အလက်များ မရှိတော့ပါ။');
        }

        DB::beginTransaction();
        try {
            // ၁။ Orders table သို့ သိမ်းခြင်း
            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name ?? 'Customer',
                'phone' => $checkoutData['phone'],
                'address' => $checkoutData['address'],
                'total_price' => $checkoutData['grand_Total'],
                'status' => 'pending',
            ]);

            // ၂။ Order Items များကို သိမ်းခြင်း နှင့် Product Stock များကို နှုတ်ခြင်း
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $product = Product::find($id);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            // ၃။ Payments table သို့ ငွေပေးချေမှု အချက်အလက် သိမ်းခြင်း
            $slipPath = null;
            if ($request->hasFile('payment_slip')) {
                $slipPath = $request->file('payment_slip')->store('slips', 'public');
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'payment_slip' => $slipPath,
                'status' => 'pending',
            ]);

            // ၄။ Cart နှင့် Checkout Session များကို ရှင်းလင်းခြင်း
            session()->forget(['cart', 'checkout_data']);
            session()->save();

            DB::commit();

            // ၅။ အောင်မြင်ပါက Success Page သို့ ပို့မည်
            return view('orders.success', compact('order'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'မှားယွင်းမှု ရှိသွားပါသည်။ ကျေးဇူးပြု၍ ထပ်မံကြိုးစားပါ။')->withInput();
        }
    }
}