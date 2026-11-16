<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <title>New Order Alert</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .email-box {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
        }
        .brand-title {
            font-size: 22px;
            font-weight: bold;
            color: #c75d83;
            margin-bottom: 5px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #71354c;
            border-bottom: 2px solid #f7e3e8;
            padding-bottom: 5px;
            margin-top: 20px;
            margin-bottom: 15px;
        }
        ul {
            padding-left: 20px;
            color: #333;
            line-height: 1.8;
        }
    </style>
</head>
<body>

<div class="email-box">
    <div class="brand-title">🌸 Pink Petals</div>
    <div style="color: #666; font-size: 12px; margin-bottom: 20px;">Online Flower Shop & Custom Bouquets</div>

    <div class="section-title">New Order Alert! 🌸</div>
    
    <p>Hello Admin,</p>
    <p>A new order has been placed on <strong>Pink Petals</strong>. Here are the order details:</p>

    <ul>
        <li><strong>Order ID:</strong> #{{ $order->id }}</li>
        <li><strong>Customer Name:</strong> {{ $order->user->name ?? $order->name ?? 'N/A' }}</li>
        <li><strong>Phone:</strong> {{ $order->phone ?? '-' }}</li>
        <li><strong>Total Amount:</strong> {{ number_format($order->total_price) }} Ks</li>
        <li><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</li>
    </ul>

    <div style="margin-top: 30px; text-align: center; color: #777; font-size: 11px; border-top: 1px solid #eee; padding-top: 15px;">
        Thank you for managing Pink Petals orders!<br>
        Website: www.pinkpetals.com
    </div>
</div>

</body>
</html>