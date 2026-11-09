<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Success | Pink Petals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-bg: #fff5f7;
            --dark-pink: #a8476b;
        }

        body {
            background-color: var(--pink-bg);
            background-image: radial-gradient(#f8d7e0 1px, transparent 1px);
            background-size: 20px 20px;
            font-family: system-ui, -apple-system, sans-serif;
            color: #563b47;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-card {
            background: white;
            border-radius: 28px;
            padding: 40px 30px;
            width: 100%;
            max-width: 580px;
            box-shadow: 0 12px 35px rgba(216, 141, 165, 0.18);
            border: 1px solid #fce4ec;
            text-align: center;
        }

        .success-icon-box {
            width: 70px;
            height: 70px;
            background-color: #e8f5e9;
            color: #2e7d32;
            font-size: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.15);
        }

        .info-box {
            background-color: #fffafb;
            border: 1px dashed #f8d7e0;
            border-radius: 16px;
            padding: 20px;
            margin-top: 25px;
            margin-bottom: 25px;
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #fce4ec;
            font-size: 0.95rem;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .btn-home {
            background: var(--pink-primary);
            color: white;
            border-radius: 16px;
            padding: 14px 20px;
            font-weight: 600;
            width: 100%;
            border: none;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(199, 93, 131, 0.3);
            text-decoration: none;
            display: inline-block;
        }

        .btn-home:hover {
            background: var(--dark-pink);
            color: white;
            transform: translateY(-1px);
        }

        .status-badge {
            background-color: #fff8e1;
            color: #f57f17;
            border: 1px solid #ffe082;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="success-card">
        <div class="success-icon-box">
            <i class="fa-solid fa-check"></i>
        </div>
        <h3 class="fw-bold mb-2" style="color: var(--pink-primary);">
            Order တင်ခြင်း အောင်မြင်ပါသည်။
        </h3>
        <p class="text-muted small mb-4 px-3" style="line-height: 1.6;">
            လူကြီးမင်း၏ Order ကို အောင်မြင်စွာ လက်ခံရရှိပြီး ဖြစ်ပါသည်။ ယုံကြည်စိတ်ချစွာ ဝယ်ယူအားပေးမှုအတွက် ကျေးဇူးတင်ရှိပါသည်။
        </p>
        <div class="info-box">
            <div class="info-row">
                <span class="text-muted fw-semibold">
                    <i class="fa-solid fa-hashtag me-1" style="color: var(--pink-primary);"></i> Order ID
                </span>
                <span class="fw-bold text-dark">#{{ $order->id ?? '' }}</span>
            </div>
            <div class="info-row">
                <span class="text-muted fw-semibold">
                    <i class="fa-solid fa-money-bill-wave me-1" style="color: var(--pink-primary);"></i> စုစုပေါင်း ကျသင့်ငွေ
                </span>
                <span class="fw-bold" style="color: var(--pink-primary);">
                    {{ number_format($order->total_price ?? 0) }} Ks
                </span>
            </div>
            <div class="info-row">
                <span class="text-muted fw-semibold">
                    <i class="fa-solid fa-wallet me-1" style="color: var(--pink-primary);"></i> ငွေချေစနစ်
                </span>
                <span class="fw-bold text-dark">
                    @php
                        $method = $order->payment->payment_method ?? 'cod';
                    @endphp

                    @if($method == 'cod')
                        Cash on Delivery (COD)
                    @elseif($method == 'kbzpay')
                        KBZPay
                    @elseif($method == 'wavepay')
                        WavePay
                    @else
                        {{ strtoupper($method) }}
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="text-muted fw-semibold">
                    <i class="fa-solid fa-clock-rotate-left me-1" style="color: var(--pink-primary);"></i> Payment Status
                </span>
                <span>
                    @if($method == 'cod')
                        <span class="badge bg-secondary text-white px-3 py-2 rounded-pill" style="font-size: 0.8rem;">Pending (COD)</span>
                    @else
                        <span class="status-badge">Paid (Pending Verification)</span>
                    @endif
                </span>
            </div>
        </div>
        <a href="{{ route('shop.products') }}" class="btn-home">
            <i class="fa-solid fa-house me-2"></i> ပင်မစာမျက်နှာသို့ ပြန်သွားမည်
        </a>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>