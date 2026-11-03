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

        // 1. Order Items ဇယားမှ အများဆုံး ဝယ်ယူထားသော Product ID များ (Top 4) ကို ရှာခြင်း
        $bestSellingProductIds = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(4)
            ->pluck('product_id');

        // 2. Orders ရှိပါက အဆိုပါ ID များနှင့် ကိုက်ညီသော Product များကို ဆွဲထုတ်ရန်
        if ($bestSellingProductIds->isNotEmpty()) {
            $products = Product::with('category')
                ->whereIn('id', $bestSellingProductIds)
                ->get();
        } else {
            // Orders မရှိသေးပါက နောက်ဆုံးထည့်ထားသော ပစ္စည်း ၄ ခုကို ပြရန်
            $products = Product::latest()->take(4)->get();
        }

        return view('home', compact('categories', 'products'));
    }
}