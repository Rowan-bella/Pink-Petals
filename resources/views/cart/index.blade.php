<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.shopping_cart_title') }} | Pink Petals</title>

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

        /* LANGUAGE DROPDOWN WITH FLAG */
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

        /* CARDS & BUTTONS */
        .card-custom {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid #fbcfe8;
            border-radius: 22px;
            box-shadow: 0 8px 22px rgba(190, 24, 93, 0.075);
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

        .product-thumb {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 14px;
            border: 1px solid #fbcfe8;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
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
                data-bs-target="#cartNavbarCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse justify-content-end mt-3 mt-lg-0" id="cartNavbarCollapse">
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

                        <a href="{{ route('cart.index') }}" class="nav-link-item active position-relative me-1">
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

                    <!-- LANGUAGE DROPDOWN WITH FLAG -->
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
        <h3 class="fw-bold mb-4" style="color: var(--dark-pink);">
            <i class="fa-solid fa-cart-shopping me-2" style="color: var(--pink);"></i> {{ __('messages.shopping_cart_title') }}
        </h3>

        <div class="row g-4">
        
            <div class="col-lg-8">
                <div class="card card-custom p-4">
                    <h5 class="fw-bold mb-3" style="color: var(--dark-pink);">{{ __('messages.cart_items_list') }}</h5>

                    @php $subtotal = 0; @endphp

                    @if(isset($cartItems) && count($cartItems) > 0)
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead style="background-color: #fff5f9;">
                                    <tr>
                                        <th>{{ __('messages.product_details') }}</th>
                                        <th>{{ __('messages.price') }}</th>
                                        <th>{{ __('messages.quantity') }}</th>
                                        <th>{{ __('messages.total') }}</th>
                                        <th class="text-end">{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        @php
                                            $itemTotal = $item->product->price * $item->quantity;
                                            $subtotal += $itemTotal;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    @if($item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="product-thumb" alt="{{ $item->product->name }}">
                                                    @else
                                                        <img src="{{ asset('images/default.jpg') }}" class="product-thumb" alt="{{ $item->product->name }}">
                                                    @endif
                                                    <div>
                                                        <h6 class="fw-bold mb-0" style="color: var(--text-main);">{{ $item->product->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ number_format($item->product->price) }} {{ __('messages.mmk') }}</td>
                                            <td>
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="input-group input-group-sm" style="width: 104px;">
                                                        <button type="submit" name="change" value="decrease" class="btn btn-outline-secondary px-2">-</button>
                                                        <input type="text" value="{{ $item->quantity }}" class="form-control text-center px-1 bg-white fw-semibold" readonly>
                                                        <button type="submit" name="change" value="increase" class="btn btn-outline-secondary px-2">+</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="fw-bold" style="color: var(--pink-deep);">{{ number_format($itemTotal) }} {{ __('messages.mmk') }}</td>
                                            <td class="text-end">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light text-danger border rounded-circle" style="width: 34px; height: 34px;" title="{{ __('messages.remove_item') }}">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted mb-3">{{ __('messages.empty_cart_message') }}</p>
                            <a href="{{ route('shop.products') }}" class="btn btn-pink rounded-pill px-4 py-2">
                                <i class="fa-solid fa-bag-shopping me-1"></i> {{ __('messages.choose_flowers_btn') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

    
            <div class="col-lg-4">
                <div class="card card-custom p-4">
                    <h5 class="fw-bold mb-3" style="color: var(--dark-pink);">{{ __('messages.order_summary') }}</h5>

                    @if(isset($cartItems) && count($cartItems) > 0)
                        <div class="mb-3">
                            @foreach($cartItems as $item)
                                @php
                                    $itemTotal = $item->product->price * $item->quantity;
                                @endphp
                                <div class="d-flex justify-content-between align-items-center mb-2 small">
                                    <span class="text-muted text-truncate" style="max-width: 170px;" title="{{ $item->product->name }}">
                                        {{ $item->product->name }} (x{{ $item->quantity }})
                                    </span>
                                    <span class="fw-semibold">{{ number_format($itemTotal) }} {{ __('messages.mmk') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <hr style="border-color: #fbcfe8;">

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('messages.subtotal') }}</span>
                        <span class="fw-semibold">{{ number_format($subtotal ?? 0) }} {{ __('messages.mmk') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5" style="color: var(--dark-pink);">{{ __('messages.grand_total') }}</span>
                        <span class="fw-bold fs-5" style="color: var(--pink-deep);">{{ number_format($subtotal ?? 0) }} {{ __('messages.mmk') }}</span>
                    </div>

                    @if(isset($cartItems) && count($cartItems) > 0)
                        <a href="{{ route('checkout.index') }}" class="btn btn-pink w-100 rounded-pill py-2 fw-semibold mb-2">
                            {{ __('messages.proceed_to_checkout') }}
                        </a>
                    @else
                        <button type="button" class="btn btn-secondary w-100 rounded-pill py-2 fw-semibold mb-2" disabled>
                            {{ __('messages.proceed_to_checkout') }}
                        </button>
                    @endif

                    <div class="d-flex gap-2">
                        <a href="{{ route('shop.products') }}" class="btn btn-outline-secondary w-50 rounded-pill py-2 small fw-semibold">
                            <i class="fa-solid fa-arrow-left me-1"></i> {{ __('messages.continue_shopping') }}
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" class="w-50">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2 small fw-semibold" {{ (isset($cartItems) && count($cartItems) > 0) ? '' : 'disabled' }}>
                                <i class="fa-solid fa-trash me-1"></i> {{ __('messages.clear_all') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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