<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport; 

class OrderReportController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Order::with(['user', 'items.product']);

        
        if ($status) {
            $query->where('status', $status);
        }

    
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

         $orders = $query->latest()->paginate(10);

        
        $totalOrdersCount = Order::count();
        $totalOrderRevenue = Order::whereIn('status', ['delivered', 'approved'])->sum('total_price');

        return view('admin.reports.orders', compact('orders', 'totalOrdersCount', 'totalOrderRevenue', 'status', 'startDate', 'endDate'));
    }
}