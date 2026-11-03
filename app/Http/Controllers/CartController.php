<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Add to Cart လုပ်ဆောင်ချက်
    public function addToCart(Request $request, $id)
    {
        // Login ဝင်မထားပါက Login Page သို့ ပို့မည်
        if (!auth()->check()) {
            session(['url.intended' => url()->previous()]);
            return redirect()->route('login')->with('error', 'ကျေးဇူးပြု၍ အရင်ဆုံး Login ဝင်ပေးပါရှင်။');
        }

        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        
        // Input ကလာသော quantity ကို ယူမည် (မပါပါက 1 ဟု သတ်မှတ်မည်)
        $requestedQuantity = (int) $request->input('quantity', 1);
        $currentCartQuantity = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        $totalQuantity = $currentCartQuantity + $requestedQuantity;

        // Stock ထက် ကျော်လွန်ခြင်း ရှိမရှိ စစ်ဆေးမည် (JavaScript Alert သုံးထားသဖြင့် ဤနေရာတွင် back() သာ ပြန်ပို့မည်)
        if ($totalQuantity > $product->stock) {
            return back();
        }

        // Cart Session ထဲသို့ ထည့်ခြင်း
        $cart[$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => $totalQuantity
        ];

        session()->put('cart', $cart);

        // အောင်မြင်ကြောင်း Success Message ဖြင့် မူလ မျက်နှာပြင်သို့ ပြန်ပို့မည်
        return back();
    }
    // Cart စာမျက်နှာပြသရန်
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }
    // Quantity တိုး/လျော့ လုပ်ခြင်း (+ / -)
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            if($request->change === 'increase') {
                $cart[$id]['quantity']++;
            } elseif($request->change === 'decrease') {
                $cart[$id]['quantity']--;
                if($cart[$id]['quantity'] <= 0) {
                    unset($cart[$id]);
                }
            }
            session()->put('cart', $cart);
        }
        
        return back();
    }

    // ပစ္စည်းတစ်ခုချင်း ဖျက်ခြင်း
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back();
    }

    // အားလုံးကို ဖျက်ခြင်း (Clear All)
    public function clear()
    {
        session()->forget('cart');
        return back();
    }

}