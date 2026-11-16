<?php
namespace App\Exports;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Order::with(['items.product', 'payment'])->get();
    }

    public function headings(): array
    {
        return [
            "Order ID", 
            "Customer ID", 
            "Total Price", 
            "Payment Method", 
            "Status",          
            "Ordered Items",    
            "Created At"        
        ];
    }

    public function map($order): array
    {
        $itemsDetails = $order->items->map(function ($item) {
            $productName = $item->product->name ?? 'Product';
            return "•{$productName} (Qty: {$item->quantity}, Price: {$item->price})";
        })->implode("\n");
        $paymentMethod = $order->payment_method 
                      ?? optional($order->payment)->payment_method
                      ?? optional($order->payment)->method 
                      ?? 'COD';
        return [
            $order->id,                                    
            $order->user_id ?? '-',                         
            $order->total_price ?? $order->total_amount ?? 0, 
            strtoupper($paymentMethod), 
            $order->status,                                 
            $itemsDetails,                                  
            $order->created_at,                           
        ];
    }
}