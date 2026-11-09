<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $bestSellingProductIds = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(4)
            ->pluck('product_id');
        if ($bestSellingProductIds->isNotEmpty()) {
            $products = Product::with('category')
                ->whereIn('id', $bestSellingProductIds)
                ->get();
        } else {

            $products = Product::latest()->take(4)->get();
        }

        return view('home', compact('categories', 'products'));
    }
}