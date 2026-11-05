<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Add to Cart လုပ်ဆောင်ချက်
    
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        
        $requestedQuantity = (int) $request->input('quantity', 1);
        $currentCartQuantity = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        $totalQuantity = $currentCartQuantity + $requestedQuantity;

        if ($totalQuantity > $product->stock) {
            return back();
        }

        $cart[$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => $totalQuantity
        ];

        session()->put('cart', $cart);
        session()->save();

        // 💡 Login ဝင်မထားပါက လက်ရှိ Products Page ရဲ့ URL ကို သိမ်းပြီး product_id ပါ တွဲပို့မည်
        if (!auth()->check()) {
            session(['url.intended' => url()->previous()]);
            session()->save();
            return redirect()->to(route('login') . '?product_id=' . $id);
        }

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
            session()->save();
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
            session()->save();
        }
        return back();
    }

    // အားလုံးကို ဖျက်ခြင်း (Clear All)
    public function clear()
    {
        session()->forget('cart');
        session()->save();
        return back();
    }
}