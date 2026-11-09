<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\CartItem; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product')
                             ->where('user_id', Auth::id())
                             ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.products')->with('error', 'သင့် Cart ထဲတွင် ပစ္စည်းများ မရှိသေးပါရှင်။');
        }
        $subtotal = 0;
        foreach($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        $deliveryFee = 2000; 
        $grandTotal = $subtotal + $deliveryFee;

        return view('checkout.index', compact('cartItems', 'subtotal', 'deliveryFee', 'grandTotal'));
    }

    public function processShipping(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'delivery_area' => 'required',
            'address' => 'required|string',
        ]);

        $cartItems = CartItem::with('product')
                             ->where('user_id', Auth::id())
                             ->get();

        $subtotal = 0;
        foreach($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
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
    
        $cartItems = CartItem::with('product')
                             ->where('user_id', Auth::id())
                             ->get();

        if (empty($checkoutData) || $cartItems->isEmpty()) {
            return redirect()->route('shop.products')->with('error', 'ဝယ်ယူမှု အချက်အလက်များ မရှိတော့ပါ။');
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name ?? 'Customer',
                'phone' => $checkoutData['phone'],
                'address' => $checkoutData['address'],
                'total_price' => $checkoutData['grand_Total'],
                'status' => 'pending',
            ]);
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }
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
            CartItem::where('user_id', Auth::id())->delete();
            session()->forget(['checkout_data']);
            session()->save();

            DB::commit();
            return view('orders.success', compact('order'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'မှားယွင်းမှု ရှိသွားပါသည်။ ကျေးဇူးပြု၍ ထပ်မံကြိုးစားပါ။')->withInput();
        }
    }
}