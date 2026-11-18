<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'monthly');
        $dateValue = $request->input('date_value'); 
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Order::with('items.product')->whereIn('status', ['delivered', 'approved']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } elseif ($dateValue) {
            if ($filter == 'daily') {
                $query->whereDate('created_at', $dateValue);
            } elseif ($filter == 'monthly') {
                
                $parts = explode('-', $dateValue);
                if (count($parts) == 2) {
                    $query->whereYear('created_at', $parts[0])
                          ->whereMonth('created_at', $parts[1]);
                }
            } elseif ($filter == 'yearly') {
            
                $query->whereYear('created_at', $dateValue);
            }
        } else {
    
            if ($filter == 'daily') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($filter == 'weekly') {
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($filter == 'monthly') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            } elseif ($filter == 'yearly') {
                $query->whereYear('created_at', Carbon::now()->year);
            }
        }

        $orders = $query->latest()->get();
        $totalRevenue = $orders->sum('total_price');
        $totalOrdersCount = $orders->count();
        
        $totalItemsSold = 0;
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $totalItemsSold += $item->quantity;
            }
        }

        return view('admin.reports.sales', compact(
            'orders', 'totalRevenue', 'totalOrdersCount', 'totalItemsSold', 'filter', 'dateValue', 'startDate', 'endDate'
        ));
    }

    public function exportExcel(Request $request)
    {
        $filter = $request->input('filter', 'monthly');
        $dateValue = $request->input('date_value');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Order::with('items.product', 'user')->whereIn('status', ['delivered', 'approved']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } elseif ($dateValue) {
            if ($filter == 'daily') {
                $query->whereDate('created_at', $dateValue);
            } elseif ($filter == 'monthly') {
                $parts = explode('-', $dateValue);
                if (count($parts) == 2) {
                    $query->whereYear('created_at', $parts[0])
                          ->whereMonth('created_at', $parts[1]);
                }
            } elseif ($filter == 'yearly') {
                $query->whereYear('created_at', $dateValue);
            }
        } else {
            if ($filter == 'daily') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($filter == 'weekly') {
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($filter == 'monthly') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            } elseif ($filter == 'yearly') {
                $query->whereYear('created_at', Carbon::now()->year);
            }
        }

        $orders = $query->latest()->get();

        return Excel::download(new SalesReportExport($orders), 'sales_report_' . date('Y-m-d') . '.xlsx');
    }
}