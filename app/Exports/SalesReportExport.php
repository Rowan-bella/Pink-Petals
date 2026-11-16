<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $orders;
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Customer Name',
            'Items & Quantity',
            'Total Price (MMK)',
            'Date',
        ];
    }

    public function map($order): array
    {
        $itemsList = [];
        foreach ($order->items as $item) {
            $itemsList[] = ($item->product->name ?? 'Flower') . ' (x' . $item->quantity . ')';
        }

        return [
            '#' . $order->id,
            $order->user->name ?? 'Guest',
            implode(', ', $itemsList),
            $order->total_price,
            $order->created_at->format('d M Y, h:i A'),
        ];
    }
}