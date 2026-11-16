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
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderInvoiceMail;
use App\Mail\AdminNewOrderMail;
use App\Models\Coupon;
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

        // $deliveryFee = 0; 
        $grandTotal = $subtotal;
        $availableCoupons = Coupon::whereNull('expires_at')
                            ->orWhere('expires_at', '>', now())
                            ->get();

        return view('checkout.index', compact('cartItems', 'subtotal',  'grandTotal','availableCoupons'));
    }

    public function processShipping(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            // 'delivery_area' => 'required',
            'address' => 'required|string',
        ]);

        $cartItems = CartItem::with('product')
                             ->where('user_id', Auth::id())
                             ->get();

        $subtotal = 0;
        foreach($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        // $deliveryFee = (float) $request->delivery_area;
        $discount = 0;
        if (session()->has('coupon')) {
        $discount = session('coupon')['discount'];
    }
        // $grandTotal = ($subtotal-$discount) + $deliveryFee;
        $grandTotal = ($subtotal-$discount);
        if ($grandTotal < 0) {
        $grandTotal = 0;
    }
        session([
            'checkout_data' => [
                'phone' => $request->phone,
                // 'delivery_area' => $deliveryFee,
                'address' => $request->address,
                'subtotal' => $subtotal,
                'discount' => $discount,
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
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
    $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
    // $deliveryFee = $checkoutData['delivery_area'] ??0;
    $discount = 0;
    if (session()->has('coupon')) {
        $discount = session('coupon')['discount'];
    }
        // $grandTotal = ($subtotal - $discount) + $deliveryFee;
        $grandTotal = ($subtotal - $discount);
    if ($grandTotal < 0) {
        $grandTotal = 0;
    }
     $checkoutData['grand_Total'] = $grandTotal;
    $checkoutData['discount'] = $discount;
    session(['checkout_data' => $checkoutData]);

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
            
            $grandTotal = $checkoutData['grand_Total'];

            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name ?? 'Customer',
                'phone' => $checkoutData['phone'],
                'address' => $checkoutData['address'],
                'total_price' => $grandTotal,
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

            if (session()->has('coupon')) {
                $couponId = session('coupon')['id'];
                $coupon = Coupon::find($couponId);
                
                if ($coupon && $coupon->code === 'WELCOME5') {
                    Auth::user()->usedCoupons()->syncWithoutDetaching([$couponId]);
                }
            }

            CartItem::where('user_id', Auth::id())->delete();
            session()->forget(['checkout_data', 'coupon']);
            session()->save();
            DB::commit();

            $adminEmail = "b66873014@gmail.com";
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new AdminNewOrderMail($order));
            }

            return view('orders.success', compact('order'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'မှားယွင်းမှု ရှိသွားပါသည်။ ကျေးဇူးပြု၍ ထပ်မံကြိုးစားပါ။')->withInput();
        }
    }
    public function applyCouponAjax(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'ထည့်သွင်းလိုက်သော ကူပွန်ကုဒ် မရှိပါ။']);
        }

        if ($coupon->expires_at && now()->greaterThan($coupon->expires_at)) {
            return response()->json(['success' => false, 'message' => 'ဤကူပွန် သက်တမ်း ကုန်ဆုံးသွားပါပြီ။']);
        }

        if ($coupon->code === 'WELCOME5') {
            $alreadyUsed = Auth::user()->usedCoupons()->where('coupon_id', $coupon->id)->exists();
            if ($alreadyUsed) {
                return response()->json(['success' => false, 'message' => 'Welcome ကူပွန်ကို သင် အသုံးပြုပြီးသား ဖြစ်ပါသည်။']);
            }
        }

        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        if ($subtotal < $coupon->min_spend) {
            return response()->json([
                'success' => false, 
                'message' => 'ဤကူပွန်ကို အသုံးပြုရန်အတွက် စုစုပေါင်းငွေပမာဏ ' . number_format($coupon->min_spend) . ' MMK ပြည့်ရန် လိုအပ်ပါသည်။'
            ]);
        }

        if ($coupon->type === 'percent') {
            $discount = ($subtotal * $coupon->value) / 100;
        } else {
            $discount = $coupon->value;
        }

        session([
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount' => $discount,
            ]
        ]);

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'message' => 'ကူပွန် အောင်မြင်စွာ အသုံးပြုပြီးပါပြီ။'
        ]);
    }
public function removeCoupon()
{
    session()->forget('coupon');
    return back()->with('success', 'ကူပွန်ကို ဖယ်ရှားပြီးပါပြီ။');
}
}