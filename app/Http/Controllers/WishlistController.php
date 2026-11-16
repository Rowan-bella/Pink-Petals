<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product')->where('user_id', auth()->id())->get();
        return view('wishlist.index', compact('wishlists'));
    }
    public function toggle(Product $product)
    {
        $userId = auth()->id();

        $existingWishlist = Wishlist::where('user_id', $userId)
                                    ->where('product_id', $product->id)
                                    ->first();

        if ($existingWishlist) {
            $existingWishlist->delete();
            return back()->with('success',);
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $product->id
            ]);
            return back()->with('success',);
        }
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $wishlist->delete();

        return back()->with('success', );
    }
}