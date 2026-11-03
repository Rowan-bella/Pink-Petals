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

        // Stock ထက် ကျော်လွန်ခြင်း ရှိမရှိ စစ်ဆေးမည်
        if ($totalQuantity > $product->stock) {
            return back()->with('error', "တောင်းဆိုထားသော ပမာဏသည် လက်ကျန် Stock ({$product->stock}) ထက် ကျော်လွန်နေပါသည်။");
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
        return back()->with('success', 'ပန်းပစ္စည်းကို Cart ထဲသို့ အောင်မြင်စွာ ထည့်သွင်းပြီးပါပြီ။');
    }
}