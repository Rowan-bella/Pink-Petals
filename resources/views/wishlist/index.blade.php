<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.wishlist_page_title') }} | Pink Petals</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .wishlist-banner {
            background: linear-gradient(110deg, #f472b6, #ec4899 55%, #be185d);
            border-radius: 22px;
            box-shadow: 0 10px 26px rgba(190, 24, 93, 0.16);
        }

        .wishlist-card {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid #fbcfe8;
            border-radius: 22px;
            box-shadow: 0 8px 22px rgba(190, 24, 93, 0.075);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .wishlist-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(190, 24, 93, 0.12);
            border-color: #f472b6;
        }

        .wishlist-img {
            height: 175px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid #fce7f3;
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
                data-bs-target="#wishlistNavbarCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end mt-3 mt-lg-0" id="wishlistNavbarCollapse">
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
                        <a href="{{ route('register') }}" class="btn btn-pink btn-sm rounded-pill py-2 px-3">
                            {{ __('messages.register') }}
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
        <div class="d-flex align-items-center justify-content-between mb-4 p-4 text-white wishlist-banner">
            <div class="d-flex align-items-center gap-3">
                <i class="fa-solid fa-heart fs-3"></i>
                <div>
                    <h4 class="mb-0 fw-bold">{{ __('messages.wishlist_heading') }}</h4>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($wishlists->isEmpty())
            <div class="text-center py-5 wishlist-card">
                <i class="fa-regular fa-heart text-muted mb-3" style="font-size: 3rem;"></i>
                <p class="text-muted fs-5">{{ __('messages.wishlist_empty') }}</p>
                <a href="{{ route('shop.products') }}" class="btn btn-pink rounded-pill px-4 mt-2">
                    {{ __('messages.go_to_shop') }}
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($wishlists as $item)
                    <div class="col-md-4">
                        <div class="card wishlist-card h-100 border-0">
                            @if(data_get($item->product, 'image'))
                                <img src="{{ asset('storage/' . data_get($item->product, 'image')) }}"
                                    class="card-img-top p-3 wishlist-img"
                                    alt="{{ data_get($item->product, 'name') }}">
                            @else
                                <img src="{{ asset('images/default.jpg') }}"
                                    class="card-img-top p-3 wishlist-img"
                                    alt="Default Image">
                            @endif

                            <div class="card-body d-flex flex-column pt-1">
                                <h6 class="card-title fw-bold text-truncate mb-1"
                                    style="color: var(--dark-pink);"
                                    title="{{ data_get($item->product, 'name') }}">
                                    {{ data_get($item->product, 'name') }}
                                </h6>

                                <p class="text-muted small mb-1">
                                    {{ data_get($item->product, 'category.name') ?? __('messages.uncategorized') }}
                                </p>

                                <p class="fw-bold mb-3 small" style="color: var(--pink-deep);">
                                    {{ number_format(data_get($item->product, 'price', 0)) }} {{ __('messages.mmk') }}
                                </p>

                                <div class="mt-auto d-flex gap-2">
                                    <a href="{{ route('shop.products') }}"
                                        class="btn btn-outline-secondary btn-sm flex-grow-1 py-1 rounded-pill"
                                        style="font-size: 0.78rem;">
                                        {{ __('messages.view_details') }}
                                    </a>

                                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="flex-grow-1 m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-outline-danger btn-sm w-100 py-1 rounded-pill"
                                            style="font-size: 0.78rem;">
                                            <i class="fa-solid fa-trash me-1"></i> {{ __('messages.remove') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>