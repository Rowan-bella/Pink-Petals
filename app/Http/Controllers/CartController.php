<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Add to Cart (AJAX ဖြင့် လက်ခံရန်)
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = (int) $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        // return response()->json([
        //     'success' => true,
        //     'message' => $cart
        // ]);

        $currentCartQuantity = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        $totalQuantity = $currentCartQuantity + $quantity;

        if ($totalQuantity > $product->stock) {
            return response()->json([
                'success' => false, 
                'message' => 'လက်ကျန်ပမာဏထက် ကျော်လွန်နေပါသည်။'
            ], 400);
        }

        $cart[$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => $totalQuantity
        ];

        session()->put('cart', $cart);
        session()->save();

        return response()->json([
            'success' => true, 
            'message' => 'Cart ထဲသို့ ပစ္စည်းထည့်ပြီးပါပြီရှင်!'
        ]);
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