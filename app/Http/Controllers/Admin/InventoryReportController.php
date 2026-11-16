<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    public function index(Request $request)
    {
        $threshold = 10;
        $outOfStockProducts = Product::where('stock', '<=', 0)->get();

        $lowStockProducts = Product::where('stock', '>', 0)->where('stock', '<=', $threshold)->get();

        $allProducts = Product::latest()->get();

        return view('admin.reports.inventory', compact('outOfStockProducts', 'lowStockProducts', 'allProducts', 'threshold'));
    }
}