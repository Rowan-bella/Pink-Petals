<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Session (သို့မဟုတ် Database) မှ Cart အချက်အလက်များကို ရယူရန်
        $cart = session()->get('cart', []);
        
        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // ဥပမာ - ပို့ဆောင်ခ (Delivery Fee) 2,000 Ks
        $deliveryFee = 2000; 
        $grandTotal = $subtotal + $deliveryFee;

        return view('checkout.index', compact('cart', 'subtotal', 'deliveryFee', 'grandTotal'));
    }

    public function store(Request $request)
    {
        // Form မှ Data များကို Validate လုပ်ပြီး Orders / Order Items သို့ သိမ်းဆည်းရန်
        $request->validate([
            'phone' => 'required|string',
            'address' => 'required|string',
            'delivery_area' => 'required',
        ]);

        // Order သိမ်းဆည်းခြင်း Logic များကို ဤနေရာတွင် ဆက်လက် ရေးသားနိုင်ပါသည်။
        
        return redirect()->route('home')->with('success', 'မှာယူမှု အောင်မြင်ပါသည်။');
    }
    public function paymentPage(Request $request)
{
    // Form မှ အချက်အလက်များကို Validate လုပ်ရန်
    $request->validate([
        'phone' => 'required|string',
        'delivery_area' => 'required',
        'address' => 'required|string',
    ]);

    // Cart ထဲက Subtotal ကို တွက်ချက်ရန်
    $cart = session('cart', []);
    $subtotal = 0;
    foreach($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    $deliveryFee = (float) $request->delivery_area;
    $grandTotal = $subtotal + $deliveryFee;

    // Delivery အချက်အလက်များကို Session တွင် ခေတ္တသိမ်းထားရန်
    session([
        'checkout_data' => [
            'phone' => $request->phone,
            'delivery_area' => $deliveryFee,
            'address' => $request->address,
            'subtotal' => $subtotal,
            'grand_Total' => $grandTotal
        ]
    ]);

    return view('checkout.payment', compact('grandTotal'));
}
}