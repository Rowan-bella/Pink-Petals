<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333333;
            line-height: 1.5;
            font-size: 13px;
            background-color: #ffffff;
            margin: 0;
            padding: 15px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 25px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        .header-table, .details-table, .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
        }
        .brand-title {
            font-size: 24px;
            font-weight: bold;
            color: #d95785;
            margin: 0;
        }
        .brand-subtitle {
            color: #666;
            font-size: 12px;
            margin-top: 3px;
        }
        .invoice-info {
            text-align: right;
        }
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #71354c;
            text-transform: uppercase;
            margin: 0 0 8px 0;
        }
        .badge {
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .badge-received { background-color: #d1e7dd; color: #0f5132; }
        .badge-pending { background-color: #fff3cd; color: #664d03; }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #71354c;
            border-bottom: 2px solid #f7e3e8;
            padding-bottom: 4px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        
        .items-table th {
            background-color: #fff5f7;
            color: #71354c;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            border-bottom: 2px solid #f7e3e8;
            font-size: 12px;
        }
        .items-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
            font-size: 12px;
        }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        
        .total-section {
            margin-top: 15px;
            float: right;
            width: 300px;
        }
        .total-table {
            width: 100%;
            border-collapse: collapse;
        }
        .total-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }
        .grand-total {
            font-size: 14px;
            font-weight: bold;
            color: #d95785;
            border-top: 2px solid #d95785 !important;
            border-bottom: 2px solid #d95785 !important;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #777;
            font-size: 11px;
            border-top: 1px solid #eee;
            padding-top: 12px;
            clear: both;
        }
    </style>
</head>
<body>

<div class="invoice-box">

    <table class="header-table">
        <tr>
            <td>
                <h2 class="brand-title">🌸 Pink Petals</h2>
                <div class="brand-subtitle">Online Flower Shop & Custom Bouquets</div>
                <div class="brand-subtitle">Yangon, Myanmar | Ph: +95 9 450310990</div>
            </td>
            <td class="invoice-info">
                <h2 class="invoice-title">INVOICE</h2>
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: right; color: #555; padding-bottom: 3px;"><strong>Order ID:</strong></td>
                        <td style="text-align: right; padding-bottom: 3px; width: 90px;">#{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right; color: #555; padding-bottom: 3px;"><strong>Date:</strong></td>
                        <td style="text-align: right; padding-bottom: 3px;">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right; color: #555;"><strong>Status:</strong></td>
                        <td style="text-align: right;">
                            <span class="badge {{ $order->status == 'received' ? 'badge-received' : 'badge-pending' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="section-title">Customer Information</div>
    <table style="width: 100%; font-size: 12px;">
        <tr>
            <td style="width: 50%;">
                <strong>Name:</strong> {{ $order->user->name ?? 'Valued Customer' }}<br>
                <strong>Email:</strong> {{ $order->user->email ?? '-' }}
            </td>
            <td style="width: 50%;">
                <strong>Payment Method:</strong> <span style="text-transform: uppercase;">{{ $order->payment->payment_method ?? 'COD' }}</span><br>
                <strong>Payment Status:</strong> <span style="text-transform: uppercase;">{{ $order->payment->status ?? 'Pending' }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">Order Summary</div>
    <table class="items-table">
        <thead>
            <tr>
                <th>Item / Flower Name</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Price</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <strong>{{ $item->product->name ?? 'Product Unavailable' }}</strong>
                </td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-end">{{ number_format($item->price) }} Ks</td>
                <td class="text-end" style="font-weight: bold; color: #d95785;">
                    {{ number_format($item->price * $item->quantity) }} Ks
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $itemsSubtotal = $order->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
    
       $calculatedDiscount = ($itemsSubtotal) - $order->total_price;

    @endphp
 <!-- $deliveryFee = $order->delivery_fee ?? 2000;
         -->
    <div class="total-section">
        <table class="total-table">
            <tr>
                <td>Subtotal:</td>
                <td class="text-end">{{ number_format($itemsSubtotal) }} Ks</td>
            </tr>
            @if($calculatedDiscount > 0)
                <tr>
                    <td style="color: #2e7d32;">Discount:</td>
                    <td class="text-end" style="color: #2e7d32;">-{{ number_format($calculatedDiscount) }} Ks</td>
                </tr>
            @endif
            
            <tr class="grand-total">
                <td>Total Amount:</td>
                <td class="text-end">{{ number_format($order->total_price) }} Ks</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Thank you for shopping with Pink Petals! We truly appreciate your support.<br>
        Website: www.pinkpetals.com | Contact: support@pinkpetals.com
    </div>
</div>

</body>
</html>