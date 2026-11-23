<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.checkout_page_title') }} | Pink Petals</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

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

        
        .checkout-banner {
            background: linear-gradient(110deg, #f472b6, #ec4899 55%, #be185d);
            border-radius: 22px;
            box-shadow: 0 10px 26px rgba(190, 24, 93, 0.16);
        }

        .card-custom {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid #fbcfe8;
            border-radius: 22px;
            box-shadow: 0 8px 22px rgba(190, 24, 93, 0.075);
        }

        .form-control-pink,
        .form-select-pink {
            border-radius: 14px;
            border: 1px solid #f5d0df;
            background-color: #fffafb;
            padding: 11px 14px;
            color: var(--text-main);
        }

        .form-control-pink:focus,
        .form-select-pink:focus {
            background-color: #fff;
            border-color: var(--pink);
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.12);
        }

        .coupon-box {
            background-color: #fff5f9;
            border: 1px solid #fbcfe8;
            border-radius: 16px;
        }

        .coupon-item {
            background: #fff;
            border: 1px solid #f5d0df;
            border-radius: 12px;
            transition: border-color 0.2s ease;
        }

        .coupon-item:hover {
            border-color: var(--pink);
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

        .cursor-pointer {
            cursor: pointer;
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
                data-bs-target="#checkoutNavbarCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            
            <div class="collapse navbar-collapse justify-content-end mt-3 mt-lg-0" id="checkoutNavbarCollapse">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 gap-md-3">
                    <div class="d-flex flex-wrap d-lg-none gap-1 pb-2 border-bottom w-100" style="border-color: #fce7f3 !important;">
                        <a href="{{ route('home') }}" class="nav-link-item">{{ __('messages.home') }}</a>
                        <a href="{{ route('shop.products') }}" class="nav-link-item">{{ __('messages.products') }}</a>
                        <a href="{{ route('home') }}#about-section" class="nav-link-item">{{ __('messages.about_us') }}</a>
                        <a href="{{ route('home') }}#contact-section" class="nav-link-item">{{ __('messages.contact') }}</a>
                    </div>

                    @if(auth()->check())
                        @php
                            $cartCount = isset($cartItems)
                                ? $cartItems->sum('quantity')
                                : \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
                            $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                        @endphp

                        <span class="fw-semibold text-secondary small d-none d-xl-inline">
                            <i class="fa-solid fa-user me-1" style="color: var(--pink);"></i>
                            {{ __('messages.greeting_user') }} {{ auth()->user()->name }}
                        </span>

                        <a href="{{ route('user.orders') }}" class="nav-link-item">
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

                        <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold">
                                {{ __('messages.logout') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link-item">{{ __('messages.login') }}</a>
                        <a href="{{ route('register') }}" class="btn btn-pink btn-sm rounded-pill py-2 px-3">{{ __('messages.register') }}</a>
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

    <div class="container py-4">
        <div class="d-flex align-items-center justify-content-between mb-4 p-4 text-white checkout-banner">
            <div class="d-flex align-items-center gap-3">
                <i class="fa-solid fa-bag-shopping fs-3"></i>
                <div>
                    <h4 class="mb-0 fw-bold">{{ __('messages.order_checkout_title') }}</h4>
                    <small class="opacity-75">{{ __('messages.order_checkout_subtitle') }}</small>
                </div>
            </div>
            <div class="d-none d-md-flex align-items-center gap-2 bg-white bg-opacity-25 px-3 py-2 rounded-pill small fw-semibold">
                <i class="fa-solid fa-lock"></i> {{ __('messages.secure_checkout') }}
            </div>
        </div>

        <form action="{{ route('checkout.shipping.process') }}" method="POST" id="mainCheckoutForm">
            @csrf
            <div class="row g-4">

                <div class="col-lg-7">
                    <div class="card card-custom p-4">
                        <h5 class="fw-bold mb-4" style="color: var(--dark-pink);">
                            <i class="fa-solid fa-truck-fast me-2" style="color: var(--pink);"></i> {{ __('messages.delivery_information') }}
                        </h5>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">{{ __('messages.phone_number') }}</label>
                            <input type="text" name="phone" class="form-control form-control-pink @error('phone') is-invalid @enderror"
                                value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">{{ __('messages.delivery_address') }}</label>
                            <textarea name="address" class="form-control form-control-pink @error('address') is-invalid @enderror" rows="4" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card card-custom p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--dark-pink);">
                            <i class="fa-solid fa-receipt me-2" style="color: var(--pink);"></i> {{ __('messages.order_summary') }}
                        </h5>

                        @php
                            $subtotal = 0;
                        @endphp

                        @if(isset($cartItems) && $cartItems->count() > 0)
                            <div class="mb-3">
                                @foreach($cartItems as $item)
                                    @php
                                        $itemTotal = $item->product->price * $item->quantity;
                                        $subtotal += $itemTotal;
                                    @endphp
                                    <div class="d-flex justify-content-between align-items-center mb-2 small">
                                        <span class="text-muted text-truncate" style="max-width: 180px;" title="{{ $item->product->name }}">
                                            {{ $item->product->name }} (x{{ $item->quantity }})
                                        </span>
                                        <span class="fw-semibold">{{ number_format($itemTotal) }} {{ __('messages.mmk') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <hr style="border-color: #fbcfe8;">

                        <div class="coupon-box p-3 mb-3">
                            <span class="small fw-bold text-muted mb-2 d-block">
                                <i class="fa-solid fa-ticket me-1 text-danger"></i> {{ __('messages.available_coupons_prompt') }}
                            </span>
                            <div class="d-flex flex-column gap-2">
                                @forelse($availableCoupons ?? [] as $coupon)
                                    <div class="form-check coupon-item p-2 small d-flex align-items-center m-0">
                                        <input class="form-check-input ms-0 me-2 cursor-pointer coupon-radio"
                                               type="radio"
                                               name="coupon_code"
                                               value="{{ $coupon->code }}"
                                               data-type="{{ $coupon->type }}"
                                               data-value="{{ $coupon->value }}"
                                               data-min="{{ $coupon->min_spend }}"
                                               id="coupon_{{ $coupon->id }}"
                                               onchange="updateTotal()"
                                               @if($subtotal < $coupon->min_spend) disabled @endif>

                                        <label class="form-check-label w-100 d-flex justify-content-between align-items-center cursor-pointer" for="coupon_{{ $coupon->id }}">
                                            <span class="fw-bold text-dark">{{ $coupon->code }}</span>
                                            <span class="text-muted" style="font-size: 11px;">
                                                @if($coupon->type == 'percent')
                                                    ({{ $coupon->value }}% {{ __('messages.discount_suffix') }})
                                                @else
                                                    ({{ number_format($coupon->value) }} {{ __('messages.mmk') }} {{ __('messages.discount_suffix') }})
                                                @endif
                                                @if($coupon->min_spend > 0)
                                                    - ({{ number_format($coupon->min_spend) }} {{ __('messages.min_spend_suffix') }})
                                                @endif
                                            </span>
                                        </label>
                                    </div>
                                @empty
                                    <span class="text-muted small text-center py-2">{{ __('messages.no_coupons_available') }}</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ __('messages.subtotal') }}</span>
                            <span class="fw-semibold"><span id="subtotalValue">{{ $subtotal }}</span> {{ __('messages.mmk') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2 text-success" id="discountRow" style="display: none !important;">
                            <span id="discountLabel">{{ __('messages.discount_label') }}</span>
                            <span class="fw-semibold">-<span id="discountValue">0</span> {{ __('messages.mmk') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5" style="color: var(--dark-pink);">{{ __('messages.grand_total') }}</span>
                            <span class="fw-bold fs-5" style="color: var(--pink-deep);"><span id="grandTotal">0</span> {{ __('messages.mmk') }}</span>
                        </div>

                        <button type="submit" form="mainCheckoutForm" class="btn btn-pink w-100 rounded-pill py-2 fw-semibold mb-2 shadow-sm">
                            <i class="fa-solid fa-circle-chevron-right me-1"></i> {{ __('messages.proceed_to_payment') }}
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2 small fw-semibold">
                            <i class="fa-solid fa-arrow-left me-1"></i> {{ __('messages.back_to_cart') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
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
    <script>
        const discountPrefix = @json(__('messages.discount_label'));

        function updateTotal() {
            let subtotal = parseFloat(document.getElementById('subtotalValue').innerText.replace(/,/g, '')) || 0;
            let discount = 0;
            let selectedCoupon = document.querySelector('input.coupon-radio:checked');

            let discountRow = document.getElementById('discountRow');
            let discountLabel = document.getElementById('discountLabel');
            let discountValueEl = document.getElementById('discountValue');

            if (selectedCoupon) {
                let couponCode = selectedCoupon.value;
                let type = selectedCoupon.getAttribute('data-type');
                let val = parseFloat(selectedCoupon.getAttribute('data-value')) || 0;

                if (type === 'percent') {
                    discount = (subtotal * val) / 100;
                    discountLabel.innerText = `${discountPrefix} (${couponCode} - ${val}%)`;
                } else {
                    discount = val;
                    discountLabel.innerText = `${discountPrefix} (${couponCode})`;
                }

                fetch("{{ route('coupon.apply.ajax') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ coupon_code: couponCode })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert(data.message);
                        selectedCoupon.checked = false;
                        discountRow.style.setProperty('display', 'none', 'important');
                        updateTotal();
                    }
                });

                discountRow.style.setProperty('display', 'flex', 'important');
                discountValueEl.innerText = discount.toLocaleString();
            } else {
                discountRow.style.setProperty('display', 'none', 'important');

                fetch("{{ route('coupon.remove') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                });
            }

            let grandTotal = subtotal - discount;
            if (grandTotal < 0) grandTotal = 0;

            document.getElementById('grandTotal').innerText = grandTotal.toLocaleString();
        }

        window.onload = updateTotal;
    </script>
</body>

</html>