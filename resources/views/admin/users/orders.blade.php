<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.my_orders') }} | Pink Petals</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --pink: #ec4899;
            --pink-primary: #c75d83;
            --pink-deep: #be185d;
            --pink-hover: #db2777;
            --dark-pink: #71354c;
            --text-main: #581c42;
            --pink-bg: #fff5f7;
        }

        body {
            background: linear-gradient(135deg, #fff4f9 0%, #ffeaf4 55%, #fff7fb 100%);
            color: var(--text-main);
            font-family: 'DM Sans', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, h5, .brand {
            font-family: 'Playfair Display', Georgia, serif;
        }

        /* NAVBAR */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            margin: 14px auto 0;
            padding: 12px 24px;
            box-shadow: 0 8px 25px rgba(190, 24, 93, 0.09);
            max-width: 1320px;
            width: calc(100% - 28px);
            z-index: 1050;
        }

        .brand {
            color: var(--pink-deep);
            font-size: 1.5rem;
            font-style: italic;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .brand:hover {
            color: var(--pink-hover);
        }

        .brand-flower {
            width: 38px;
            height: 38px;
            border-radius: 13px;
            background: linear-gradient(145deg, #fce7f3, #fbcfe8);
            color: var(--pink);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-style: normal;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.16);
        }

        .nav-link-item {
            color: #713653;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.93rem;
            padding: 7px 12px;
            border-radius: 12px;
            transition: all 0.2s ease;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link-item:hover,
        .nav-link-item.active {
            background: #fff0f7;
            color: var(--pink-deep);
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
            padding: 7px 13px;
            font-weight: 600;
            font-size: 0.86rem;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            box-shadow: 0 3px 10px rgba(190, 24, 93, .05);
            white-space: nowrap;
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

        .orders-banner {
            background: linear-gradient(110deg, #f472b6, #ec4899 55%, #be185d);
            border-radius: 22px;
            box-shadow: 0 10px 26px rgba(190, 24, 93, 0.16);
        }

        .order-card {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid #fbcfe8;
            border-radius: 22px;
            box-shadow: 0 8px 22px rgba(190, 24, 93, 0.075);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(190, 24, 93, 0.11);
        }

        .product-img {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #fbcfe8;
        }

        .badge-status {
            padding: 6px 14px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .btn-pink {
            background: linear-gradient(110deg, #f472b6, #ec4899 60%, #db2777);
            color: white;
            border: none;
            transition: all 0.25s ease;
            font-weight: 600;
            box-shadow: 0 6px 16px rgba(236, 72, 153, 0.22);
        }

        .btn-pink:hover {
            background: var(--pink-deep);
            color: white;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-custom">
        <div class="container-fluid px-0 d-flex justify-content-between align-items-center">

            <div class="d-flex align-items-center flex-wrap gap-2 gap-lg-3">
                <a class="brand me-1" href="{{ route('home') }}">
                    <span class="brand-flower">✿</span>
                    <span>Pink Petals</span>
                </a>

                <div class="d-none d-lg-flex align-items-center gap-1">
                    <a href="{{ route('home') }}" class="nav-link-item">{{ __('messages.home') }}</a>
                    <a href="{{ route('shop.products') }}" class="nav-link-item">{{ __('messages.products') }}</a>
                    <a href="{{ route('home') }}#about-section" class="nav-link-item">{{ __('messages.about_us') }}</a>
                    <a href="{{ route('home') }}#contact-section" class="nav-link-item">{{ __('messages.contact') }}</a>
                </div>
            </div>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#ordersNavbarCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end mt-3 mt-lg-0" id="ordersNavbarCollapse">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 gap-md-3">
                    <div class="d-flex flex-wrap d-lg-none gap-1 pb-2 border-bottom w-100" style="border-color: #fce7f3 !important;">
                        <a href="{{ route('home') }}" class="nav-link-item">{{ __('messages.home') }}</a>
                        <a href="{{ route('shop.products') }}" class="nav-link-item">{{ __('messages.products') }}</a>
                        <a href="{{ route('home') }}#about-section" class="nav-link-item">{{ __('messages.about_us') }}</a>
                        <a href="{{ route('home') }}#contact-section" class="nav-link-item">{{ __('messages.contact') }}</a>
                    </div>

                    @if(auth()->check())
                        @php
                            $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
                            $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                        @endphp

                        <a href="{{ route('user.orders') }}" class="nav-link-item active">
                            <i class="fa-solid fa-bag-shopping" style="color: var(--pink);"></i>
                            <span>{{ __('messages.my_orders') }}</span>
                        </a>

                        <a href="{{ route('cart.index') }}" class="nav-link-item position-relative me-1">
                            <i class="fa-solid fa-cart-shopping fs-6" style="color: var(--pink);"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 0.65rem;">
                                {{ $cartCount }}
                            </span>
                        </a>

                        <a href="{{ route('wishlist.index') }}" class="nav-link-item position-relative me-1">
                            <i class="fa-solid fa-heart text-danger fs-6"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 0.65rem;">
                                {{ $wishlistCount }}
                            </span>
                        </a>
                    @endif

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
            </div>
        </div>
    </nav>

    <div class="container py-4 pb-5">
        <div class="d-flex align-items-center justify-content-between mb-4 p-4 text-white orders-banner">
            <div class="d-flex align-items-center gap-3">
                <i class="fa-solid fa-bag-shopping fs-3"></i>
                <div>
                    <h4 class="mb-0 fw-bold">{{ __('messages.my_orders_history') }}</h4>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row g-4">
            @forelse($orders as $order)
                @php
                    $orderItems = collect($order->items);

                    $subtotal = $orderItems->sum(function ($item) {
                        return ($item->price ?? 0) * ($item->quantity ?? 1);
                    });

                    $calculatedDiscount = max(
                        0,
                        $subtotal - ($order->total_price ?? 0)
                    );

                    $statusLower = strtolower($order->status ?? 'pending');
                @endphp

                <div class="col-12">
                    <div class="order-card p-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center pb-3 mb-3 border-bottom gap-2"
                            style="border-color: #fbcfe8 !important;">
                            <div>
                                <span class="fw-bold fs-5 me-3" style="color: var(--dark-pink);">
                                    {{ __('messages.order_number', ['id' => $order->id]) }}
                                </span>
                                <span class="text-muted small">
                                    <i class="fa-regular fa-clock me-1"></i>
                                    {{ optional($order->created_at)->format('Y-m-d H:i') }}
                                </span>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <span class="text-muted small d-block mb-1">{{ __('messages.status') }}:</span>

                                    @if($statusLower == 'pending')
                                        <span class="badge bg-warning bg-opacity-10 text-warning badge-status">
                                            {{ __('messages.status_pending') }}
                                        </span>
                                    @elseif($statusLower == 'approved')
                                        <span class="badge bg-info bg-opacity-10 text-info badge-status">
                                            {{ __('messages.status_approved') }}
                                        </span>
                                    @elseif($statusLower == 'delivered')
                                        <span class="badge bg-primary bg-opacity-10 text-primary badge-status">
                                            {{ __('messages.status_delivered') }}
                                        </span>
                                    @elseif($statusLower == 'received')
                                        <span class="badge bg-success bg-opacity-10 text-success badge-status">
                                            {{ __('messages.status_received') }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary badge-status">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    <span class="text-muted small d-block mb-1">{{ __('messages.payment') }}:</span>
                                    <span class="badge bg-light text-dark border px-2 py-1 text-uppercase">
                                        {{ $order->payment->payment_method ?? 'COD' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mb-3">
                            <table class="table align-middle mb-0">
                                <thead class="table-light small text-muted">
                                    <tr>
                                        <th>{{ __('messages.th_product') }}</th>
                                        <th>{{ __('messages.th_price') }}</th>
                                        <th>{{ __('messages.th_qty') }}</th>
                                        <th class="text-end">{{ __('messages.th_total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orderItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                                            class="product-img shadow-sm" alt="{{ $item->product->name }}">
                                                    @else
                                                        <div class="product-img bg-light d-flex align-items-center justify-content-center text-muted">
                                                            <i class="fa-solid fa-image"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="fw-bold mb-0" style="color: var(--dark-pink);">
                                                            {{ $item->product->name ?? __('messages.product_unavailable') }}
                                                        </h6>
                                                        <small class="text-muted">{{ __('messages.flower_item') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted">
                                                {{ number_format($item->price ?? 0) }} {{ __('messages.ks') }}
                                            </td>
                                            <td class="text-muted">
                                                x{{ $item->quantity ?? 1 }}
                                            </td>
                                            <td class="text-end fw-bold" style="color: var(--pink-deep);">
                                                {{ number_format(($item->price ?? 0) * ($item->quantity ?? 1)) }} {{ __('messages.ks') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="pt-3 border-top mb-3" style="border-color: #fbcfe8 !important;">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>{{ __('messages.subtotal') }}:</span>
                                <span>{{ number_format($subtotal) }} {{ __('messages.ks') }}</span>
                            </div>

                            @if($calculatedDiscount > 0)
                                <div class="d-flex justify-content-between small text-success mb-1">
                                    <span>{{ __('messages.discount') }}:</span>
                                    <span>-{{ number_format($calculatedDiscount) }} {{ __('messages.ks') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-top gap-3"
                            style="border-color: #fbcfe8 !important;">
                            <div>
                                <span class="text-muted small">{{ __('messages.total_amount_label') }}:</span>
                                <h4 class="fw-bold mb-0" style="color: var(--pink-deep);">
                                    {{ number_format($order->total_price ?? 0) }} {{ __('messages.ks') }}
                                </h4>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                @if($statusLower == 'delivered')
                                    <form action="{{ route('user.order.received', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 shadow-sm py-2">
                                            <i class="fa-solid fa-check-double me-1"></i>
                                            {{ __('messages.order_received_btn') }}
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('user.order.pdf', $order->id) }}"
                                    class="btn btn-outline-danger btn-sm rounded-pill px-4 shadow-sm py-2"
                                    title="{{ __('messages.download_invoice') }}">
                                    <i class="fa-solid fa-file-pdf me-1"></i>
                                    {{ __('messages.pdf_invoice') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card order-card text-center py-5">
                        <i class="fa-solid fa-box-open fs-1 text-muted mb-2 opacity-50 d-block"></i>
                        <h5 class="text-muted">{{ __('messages.no_orders_found') }}</h5>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>