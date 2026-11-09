<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'ကျေးဇူးပြု၍ Login အရင်ဝင်ပေးပါရှင်။'
            ], 401);
        }

        $product = Product::findOrFail($id);
        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $userId = auth()->id();

        $cartItem = CartItem::where('user_id', $userId)
                            ->where('product_id', $id)
                            ->first();
        $targetQty = $cartItem ? $quantity : $quantity; 

        if ($targetQty > $product->stock) {
            return response()->json([
                'success' => false, 
                'message' => 'တောင်းဆိုထားသော ပမာဏသည် လက်ကျန် Stock (' . $product->stock . ') ထက် ကျော်လွန်နေပါသည်။'
            ], 400);
        }

        if ($cartItem) {
            $cartItem->update(['quantity' => $quantity]);
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $id,
                'quantity' => $quantity
            ]);
        }

        $newCartCount = CartItem::where('user_id', $userId)->sum('quantity');

        return response()->json([
            'success' => true, 
            'message' => 'Cart ထဲသို့ ပစ္စည်းထည့်ပြီးပါပြီရှင်!',
            'cartCount' => $newCartCount
        ]);
    }

    public function index()
    {
        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();
        return view('cart.index', compact('cartItems'));
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::where('user_id', auth()->id())->where('id', $id)->first();

        if ($cartItem) {
            if ($request->change === 'increase') {
                if ($cartItem->quantity < $cartItem->product->stock) {
                    $cartItem->increment('quantity');
                }
            } elseif ($request->change === 'decrease') {
                $cartItem->decrement('quantity');
                if ($cartItem->quantity <= 0) {
                    $cartItem->delete();
                }
            }
        }

        return back();
    }

    public function remove($id)
    {
        CartItem::where('user_id', auth()->id())->where('id', $id)->delete();
        return back();
    }

    public function clear()
    {
        CartItem::where('user_id', auth()->id())->delete();
        return back();
    }
}