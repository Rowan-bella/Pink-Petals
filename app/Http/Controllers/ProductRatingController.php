<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ProductRating;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductRatingController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);
        ProductRating::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $productId],
            ['rating' => $request->rating, 'review' => $request->review]
        );

        $product = Product::find($productId);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'ကျေးဇူးတင်ပါတယ်! သင့်ရဲ့ Rating ကို သိမ်းဆည်းပြီးပါပြီ။',
                'average' => number_format($product->averageRating(), 1),
                'count' => $product->ratings()->count()
            ]);
        }

        return redirect()->back()->with('success', 'ကျေးဇူးတင်ပါတယ်! သင့်ရဲ့ Rating ကို သိမ်းဆည်းပြီးပါပြီ။');
    }
}