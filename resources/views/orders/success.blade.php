<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.order_success_page_title') }} | Pink Petals</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --pink: #ec4899;
            --pink-primary: #c75d83;
            --pink-deep: #be185d;
            --pink-bg: #fff5f7;
            --dark-pink: #71354c;
            --text-main: #581c42;
        }

        body {
            background: linear-gradient(135deg, #fff4f9 0%, #ffeaf4 55%, #fff7fb 100%);
            background-image:
                radial-gradient(rgba(199, 93, 131, 0.14) 1px, transparent 1px),
                linear-gradient(135deg, #fff4f9 0%, #ffeaf4 55%, #fff7fb 100%);
            background-size: 22px 22px, 100% 100%;
            font-family: 'DM Sans', system-ui, -apple-system, sans-serif;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        h3, h4, .brand {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .success-card {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(10px);
            border-radius: 28px;
            padding: 36px 30px;
            width: 100%;
            max-width: 580px;
            box-shadow: 0 14px 36px rgba(190, 24, 93, 0.14);
            border: 1px solid #fbcfe8;
            text-align: center;
        }

        .brand {
            color: var(--pink-deep);
            font-size: 1.3rem;
            font-style: italic;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .brand-flower {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: linear-gradient(145deg, #fce7f3, #fbcfe8);
            color: var(--pink);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-style: normal;
            font-size: 1rem;
        }

        .flag-icon {
            width: 20px;
            height: 14px;
            object-fit: cover;
            border-radius: 2px;
            box-shadow: 0 0 1px rgba(0, 0, 0, .25);
        }

        .lang-dropdown-btn {
            background: #fff;
            border: 1px solid #f3c5da;
            color: #581c42;
            border-radius: 14px;
            padding: 6px 12px;
            font-weight: 600;
            font-size: 0.84rem;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            box-shadow: 0 3px 10px rgba(190, 24, 93, .05);
        }

        .lang-dropdown-btn:hover,
        .lang-dropdown-btn:focus {
            background: #fff5fa;
            border-color: var(--pink);
            color: var(--pink-deep);
        }

        .lang-dropdown-menu {
            border: 1px solid #fbcfe8;
            border-radius: 14px;
            padding: 6px;
            box-shadow: 0 10px 24px rgba(190, 24, 93, .12);
            min-width: 145px;
            z-index: 1060;
        }

        .lang-dropdown-menu .dropdown-item {
            border-radius: 10px;
            padding: 8px 12px;
            font-weight: 600;
            font-size: 0.88rem;
            color: #581c42;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lang-dropdown-menu .dropdown-item:hover,
        .lang-dropdown-menu .dropdown-item.active {
            background: linear-gradient(110deg, #f472b6, #ec4899);
            color: #fff;
        }

        .success-icon-box {
            width: 72px;
            height: 72px;
            background: linear-gradient(145deg, #fce7f3, #fbcfe8);
            color: var(--pink-deep);
            font-size: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 12px auto 20px auto;
            box-shadow: 0 6px 18px rgba(236, 72, 153, 0.2);
        }

        .info-box {
            background-color: #fff5f9;
            border: 1px dashed #f5c2d7;
            border-radius: 18px;
            padding: 20px;
            margin-top: 22px;
            margin-bottom: 24px;
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #fce4ec;
            font-size: 0.94rem;
            gap: 12px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .btn-home {
            background: linear-gradient(110deg, #f472b6, #ec4899 60%, #db2777);
            color: white;
            border-radius: 16px;
            padding: 13px 20px;
            font-weight: 600;
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 6px 16px rgba(236, 72, 153, 0.24);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-home:hover {
            background: var(--pink-deep);
            color: white;
            transform: translateY(-1px);
        }

        .btn-orders-outline {
            background: #fff;
            color: var(--pink-deep);
            border: 1px solid #f3c5da;
            border-radius: 16px;
            padding: 12px 20px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-orders-outline:hover {
            background: #fff0f7;
            border-color: var(--pink);
            color: var(--pink-deep);
        }

        .status-badge {
            background-color: #fff8e1;
            color: #d97706;
            border: 1px solid #fde68a;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="success-card">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-flower">✿</span>
                <span>Pink Petals</span>
            </a>

    
            <div class="dropdown">
                <button class="btn lang-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    @if(app()->getLocale() === 'my')
                        <img src="https://flagcdn.com/mm.svg" alt="မြန်မာ" class="flag-icon">
                        <span>မြန်မာ</span>
                    @else
                        <img src="https://flagcdn.com/gb.svg" alt="English" class="flag-icon">
                        <span>English</span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end lang-dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                            href="{{ route('lang.switch', 'en') }}">
                            <img src="https://flagcdn.com/gb.svg" alt="English" class="flag-icon">
                            <span>English</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === 'my' ? 'active' : '' }}"
                            href="{{ route('lang.switch', 'my') }}">
                            <img src="https://flagcdn.com/mm.svg" alt="မြန်မာ" class="flag-icon">
                            <span>မြန်မာ</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="success-icon-box">
            <i class="fa-solid fa-check"></i>
        </div>

        <h3 class="fw-bold mb-2" style="color: var(--dark-pink);">
            {{ __('messages.order_success_heading') }}
        </h3>

        <p class="text-muted small mb-0 px-2" style="line-height: 1.65;">
            {{ __('messages.order_success_description') }}
        </p>

        <div class="info-box">
            <div class="info-row">
                <span class="text-muted fw-semibold">
                    <i class="fa-solid fa-hashtag me-1" style="color: var(--pink);"></i> {{ __('messages.order_id_label') }}
                </span>
                <span class="fw-bold text-dark">#{{ $order->id ?? '' }}</span>
            </div>

            <div class="info-row">
                <span class="text-muted fw-semibold">
                    <i class="fa-solid fa-money-bill-wave me-1" style="color: var(--pink);"></i> {{ __('messages.total_payable_amount') }}
                </span>
                <span class="fw-bold" style="color: var(--pink-deep);">
                    {{ number_format($order->total_price ?? 0) }} {{ __('messages.mmk') }}
                </span>
            </div>

            <div class="info-row">
                <span class="text-muted fw-semibold">
                    <i class="fa-solid fa-wallet me-1" style="color: var(--pink);"></i> {{ __('messages.payment_method_label') }}
                </span>
                <span class="fw-bold text-dark">
                    @php
                        $method = $order->payment->payment_method ?? 'cod';
                    @endphp

                    @if($method == 'cod')
                        {{ __('messages.cash_on_delivery_short') }}
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
                    <i class="fa-solid fa-clock-rotate-left me-1" style="color: var(--pink);"></i> {{ __('messages.payment_status_label') }}
                </span>
                <span>
                    @if($method == 'cod')
                        <span class="badge bg-secondary text-white px-3 py-2 rounded-pill" style="font-size: 0.78rem;">
                            {{ __('messages.status_pending_cod') }}
                        </span>
                    @else
                        <span class="status-badge">{{ __('messages.status_paid_pending_verification') }}</span>
                    @endif
                </span>
            </div>
        </div>

        <div class="d-grid gap-2">
            <a href="{{ route('home') }}" class="btn-home">
                <i class="fa-solid fa-house me-2"></i> {{ __('messages.back_to_home') }}
            </a>
            <a href="{{ route('user.orders') }}" class="btn-orders-outline">
                <i class="fa-solid fa-bag-shopping me-2"></i> {{ __('messages.my_orders') }}
            </a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.querySelector('.lang-dropdown-btn');
        if (toggleBtn && typeof bootstrap === 'undefined') {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const menu = this.nextElementSibling;
                if (menu) menu.classList.toggle('show');
            });
            document.addEventListener('click', function() {
                document.querySelectorAll('.lang-dropdown-menu.show').forEach(function(m) {
                    m.classList.remove('show');
                });
            });
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>