<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <title>Order Invoice - Pink Petals</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #333333;
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
            font-size: 24px;
            font-weight: bold;
            color: #c75d83;
            margin-bottom: 3px;
        }
        .brand-subtitle {
            color: #666;
            font-size: 12px;
            margin-bottom: 25px;
            border-bottom: 2px solid #f7e3e8;
            padding-bottom: 12px;
        }
        .content {
            font-size: 14px;
            line-height: 1.6;
            color: #444444;
        }
        .footer {
            margin-top: 35px;
            text-align: center;
            color: #777;
            font-size: 11px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>

<div class="email-box">
    <div class="brand-title">🌸 Pink Petals</div>
    <div class="brand-subtitle">Online Flower Shop & Custom Bouquets</div>

    <div class="content">
        <p><strong>Hello {{ $order->user->name ?? 'Valued Customer' }},</strong></p>
        
        <p>Thank you for shopping with <strong>Pink Petals</strong>! 🌸</p>
        
        <p>Your order <strong>#{{ $order->id }}</strong> has been <strong>{{ $order->status }}</strong> successfully.</p>
        
        <p>Please find your attached invoice PDF for your records.</p>
        
        <p style="margin-top: 25px;">
            Best regards, <br>
            <strong>Pink Petals Team</strong>
        </p>
    </div>

    <div class="footer">
        Thank you for choosing Pink Petals! We truly appreciate your support.<br>
        Website: www.pinkpetals.com | Contact: support@pinkpetals.com
    </div>
</div>

</body>
</html>