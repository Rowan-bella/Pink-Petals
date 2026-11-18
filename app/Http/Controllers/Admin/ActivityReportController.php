<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;

class ActivityReportController extends Controller
{
    public function index()
    {
        $topCustomers = User::withCount(['orders' => function ($query) {
                $query->whereIn('status', ['delivered', 'approved']);
            }])
            ->withSum(['orders' => function ($query) {
                $query->whereIn('status', ['delivered', 'approved']);
            }], 'total_price')
            ->having('orders_count', '>', 0)
            ->orderByDesc('orders_sum_total_price')
            ->take(10)
            ->get();

        $bestSellers = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(price * quantity) as total_earned'))
            ->whereHas('order', function ($query) {
                $query->whereIn('status', ['delivered', 'approved']);
            })
            ->with('product.category')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        $mostWishlisted = Wishlist::select('product_id', DB::raw('COUNT(*) as wishlist_count'))
            ->with('product.category')
            ->groupBy('product_id')
            ->orderByDesc('wishlist_count')
            ->take(10)
            ->get();

        return view('admin.reports.activity', compact('topCustomers', 'bestSellers', 'mostWishlisted'));
    }
}