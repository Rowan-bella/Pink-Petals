<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.home_page_title') }} | Pink Petals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --pink: #ec4899;
            --pink-primary: #ec4899;
            --pink-deep: #be185d;
            --pink-hover: #db2777;
            --dark-pink: #71354c;
            --text-main: #581c42;
            --light-pink: #ffe4f0;
            --cream: #fff7fb;
        }

        body {
            background: linear-gradient(135deg, #fff4f9 0%, #ffeaf4 55%, #fff7fb 100%);
            color: var(--text-main);
            font-family: 'DM Sans', system-ui, -apple-system, "Segoe UI", sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, .brand {
            font-family: 'Playfair Display', serif;
        }

    
        .navbar-custom {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            margin: 14px auto 0;
            padding: 12px 22px;
            box-shadow: 0 8px 25px rgba(190, 24, 93, 0.09);
            max-width: 1320px;
            width: calc(100% - 28px);
            z-index: 1050;
        }

        .brand {
            color: var(--pink-deep);
            font-size: 1.55rem;
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
            font-size: 0.95rem;
            padding: 7px 13px;
            border-radius: 12px;
            transition: all 0.2s ease;
            white-space: nowrap;
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

    
        .hero {
            background: linear-gradient(110deg, rgba(255, 232, 237, 0.9), rgba(255, 240, 247, 0.95));
            border: 1px solid rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            margin: 18px auto 0;
            padding: 52px 28px;
            max-width: 1320px;
            width: calc(100% - 28px);
            box-shadow: 0 12px 35px rgba(190, 24, 93, 0.09);
        }

        .hero h1 {
            font-size: clamp(36px, 5vw, 54px);
            font-weight: 700;
            line-height: 1.15;
            margin: 16px 0;
            color: var(--dark-pink);
        }

        .pink-text {
            color: var(--pink);
            font-style: italic;
        }

        .hero-image {
            width: 100%;
            height: 380px;
            object-fit: cover;
            border-radius: 24px;
            box-shadow: 0 12px 30px rgba(190, 24, 93, 0.14);
        }

        .btn-pink {
            background: linear-gradient(110deg, #f472b6, #ec4899 60%, #db2777);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 11px 26px;
            text-decoration: none;
            transition: all 0.25s ease;
            font-weight: 600;
            box-shadow: 0 6px 16px rgba(236, 72, 153, 0.24);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-pink:hover {
            background: var(--pink-deep);
            color: white;
            transform: translateY(-1px);
        }

        
        .category-card,
        .product-card {
            background: rgba(255, 255, 255, 0.96);
            border-radius: 22px;
            border: 1px solid #fbcfe8;
            overflow: hidden;
            transition: all 0.25s ease;
            box-shadow: 0 8px 22px rgba(190, 24, 93, 0.075);
        }

        .category-card:hover,
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(190, 24, 93, 0.13);
        }

        .category-img {
            width: 100%;
            height: 155px;
            object-fit: cover;
            border-radius: 14px;
        }

        .product-image {
            width: 100%;
            height: 185px;
            object-fit: cover;
            background: var(--light-pink);
            border-radius: 14px;
        }

        .service-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #fbcfe8;
            border-radius: 22px;
            padding: 20px 14px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(190, 24, 93, 0.06);
            height: 100%;
        }

        .service-icon {
            width: 48px;
            height: 48px;
            border-radius: 15px;
            background: linear-gradient(145deg, #fce7f3, #fbcfe8);
            color: var(--pink-deep);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 10px;
        }


        footer.site-footer {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            color: #713653;
            padding: 28px 24px 20px;
            margin: 24px auto 14px;
            max-width: 1320px;
            width: calc(100% - 28px);
            box-shadow: 0 8px 24px rgba(190, 24, 93, 0.08);
        }

        footer.site-footer a {
            color: #713653;
            text-decoration: none;
            margin: 0 10px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        footer.site-footer a:hover {
            color: var(--pink);
        }
    </style>
</head>

<body>
    
    <nav class="navbar navbar-expand-lg sticky-top navbar-custom">
        <div class="container-fluid px-1">
            <div class="d-flex align-items-center flex-wrap gap-2 gap-lg-3">
                <a class="brand me-1" href="{{ route('home') }}">
                    <span class="brand-flower">✿</span>
                    <span>Pink Petals</span>
                </a>

                <a href="{{ route('home') }}" class="nav-link-item active">{{ __('messages.home') }}</a>
                <a href="{{ route('shop.products') }}" class="nav-link-item">{{ __('messages.products') }}</a>
                <a href="#about-section" class="nav-link-item">{{ __('messages.about_us') }}</a>
                <a href="#contact-section" class="nav-link-item">{{ __('messages.contact') }}</a>
            </div>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#homeNavbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end mt-2 mt-lg-0" id="homeNavbarCollapse">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 gap-md-3">
                    @auth
                         <span class="fw-semibold text-secondary small d-none d-xl-inline">
                            <i class="fa-solid fa-user me-1" style="color: var(--pink);"></i>
                            {{ __('messages.greeting_user') }} {{ auth()->user()->name }}
                        </span>

                        <a href="{{ route('user.orders') }}" class="nav-link-item">
                            <i class="fa-solid fa-bag-shopping me-1" style="color: var(--pink-primary);"></i>
                            {{ __('messages.my_orders') }}
                        </a>

                        @php
                    $cartCount = auth()->check() ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity') : 0;
                    @endphp

                    <a href="{{ route('cart.index') }}" class="nav-link-item position-relative">
                        <i class="fa-solid fa-cart-shopping fs-6" style="color: var(--pink-primary);"></i>
                        <span id="cart-count-badge"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.65rem;">
                            {{ $cartCount }}
                        </span>
                    </a>
                         @php
                    $wishlistCount = auth()->check() ? \App\Models\Wishlist::where('user_id', auth()->id())->count() : 0;
                    @endphp

                    <a href="{{ route('wishlist.index') }}" class="nav-link-item position-relative d-flex align-items-center gap-1">
                        <i class="fa-solid fa-heart text-danger fs-6"></i>
                        <!-- <span>{{ __('messages.wishlist') }}</span> -->
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.65rem;">
                            {{ $wishlistCount }}
                        </span>
                    </a>


                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold">
                                {{ __('messages.logout') }}
                            </button>
                        </form>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-pink btn-sm py-2 px-3">{{ __('messages.login') }}</a>
                        <a href="{{ route('register') }}" class="btn btn-pink btn-sm py-2 px-3">{{ __('messages.register') }}</a>
                    @endguest

            
                    <div class="dropdown">
                        <button class="btn lang-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                                <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">
                                    <img src="https://flagcdn.com/gb.svg" alt="English" class="flag-icon">
                                    <span>English</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() === 'my' ? 'active' : '' }}" href="{{ route('lang.switch', 'my') }}">
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


    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="text-uppercase fw-bold small mb-2" style="color: var(--pink-deep); letter-spacing: 2px;">
                        {{ __('messages.hero_tagline') }} ♥
                    </div>
                    <h1>
                        {{ __('messages.hero_title_line1') }}<br>
                        {{ __('messages.hero_title_line2_prefix') }} <span class="pink-text">{{ __('messages.hero_title_highlight') }}</span>
                    </h1>
                    <p class="text-muted mb-4" style="line-height: 1.8;">
                        {{ __('messages.hero_description') }}
                    </p>
                    <a href="{{ route('shop.products') }}" class="btn-pink">
                        {{ __('messages.shop_now') }} &nbsp; →
                    </a>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/hero5.jpg') }}" alt="{{ __('messages.flower_bouquet_alt') }}" class="hero-image">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-uppercase text-muted small" style="letter-spacing: 2px;">{{ __('messages.shop_by_category') }}</span>
                <h2 class="fw-bold mt-1" style="color: var(--dark-pink);">{{ __('messages.find_perfect_bloom') }}</h2>
                <p class="text-muted small">{{ __('messages.category_subtitle') }}</p>
            </div>

            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('shop.products', ['category' => $category->id]) }}" class="text-decoration-none">
                            <div class="category-card p-3 h-100 text-center">
                                <img src="{{ asset('storage/' . $category->image) }}" class="category-img mb-3" alt="{{ $category->name }}">
                                <h6 class="fw-bold mb-1" style="color: var(--text-main);">{{ $category->name }}</h6>
                                <small class="text-muted">{{ $category->products_count }} {{ __('messages.products') }}</small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-uppercase text-muted small" style="letter-spacing: 2px;">{{ __('messages.best_sellers') }}</span>
                <h2 class="fw-bold mt-1" style="color: var(--dark-pink);">{{ __('messages.flowers_you_love') }}</h2>
                <p class="text-muted small">{{ __('messages.best_sellers_subtitle') }}</p>
            </div>

            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-6 col-lg-3">
                        <div class="product-card p-3 d-flex flex-column h-100 position-relative">
                            @php
                                $isWishlisted = auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                            @endphp

                            @if(auth()->check())
                                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="position-absolute top-0 end-0 m-3 z-3">
                                    @csrf
                                    <button type="submit" class="btn btn-light rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        @if($isWishlisted)
                                            <i class="fa-solid fa-heart text-danger fs-6"></i>
                                        @else
                                            <i class="fa-regular fa-heart text-secondary fs-6"></i>
                                        @endif
                                    </button>
                                </form>
                            @else
                                <div class="position-absolute top-0 end-0 m-3 z-3">
                                    <button type="button" onclick="toggleGuestWishlist({{ $product->id }})" class="btn btn-light rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="fa-regular fa-heart text-secondary fs-6" id="heart-icon-{{ $product->id }}"></i>
                                    </button>
                                </div>
                            @endif

                            <img src="{{ asset('storage/' . $product->image) }}" class="product-image mb-3" alt="{{ $product->name }}">

                            <h6 class="fw-bold mb-1" style="color: var(--text-main);">{{ $product->name }}</h6>
                            <small class="text-muted mb-2">{{ $product->category->name ?? __('messages.flower_gifts_default') }}</small>

                            <div class="mb-2 d-flex align-items-center gap-1"
                                style="cursor: pointer;"
                                onclick="openRatingModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                title="{{ __('messages.click_to_rate_review') }}">

                                @php
                                    $avgRating = method_exists($product, 'averageRating') ? $product->averageRating() : 0;
                                    $ratingCount = method_exists($product, 'ratings') ? $product->ratings()->count() : 0;
                                    $roundedRating = round($avgRating);
                                @endphp

                                <div class="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $roundedRating ? 'fa-solid text-warning' : 'fa-regular text-muted' }} fa-star" style="font-size: 0.8rem;"></i>
                                    @endfor
                                </div>

                                <span class="fw-bold text-dark small ms-1" id="avg-rating-{{ $product->id }}">{{ number_format($avgRating, 1) }}</span>
                                <span class="text-muted" id="rating-count-{{ $product->id }}" style="font-size: 0.75rem;">
                                    ({{ $ratingCount }} {{ __('messages.reviews') }})
                                </span>
                            </div>

                            <div class="mb-2">
                                <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill" style="font-size: 0.75rem;">
                                    {{ __('messages.stock_label') }}: {{ $product->stock }}
                                </span>
                            </div>

                            <p class="text-muted small mb-3" style="font-size: 0.8rem; line-height: 1.4;">
                                {{ $product->description }}
                            </p>

                            <div class="fw-bold mb-3 fs-5" style="color: var(--pink-deep);">
                                {{ number_format($product->price) }} {{ __('messages.mmk') }}
                            </div>

                            <div class="mt-auto">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="input-group input-group-sm" style="width: 110px;">
                                            <button type="button" class="btn btn-outline-secondary px-2" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control text-center p-1" readonly>
                                            <button type="button" class="btn btn-outline-secondary px-2" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-pink btn-sm w-100 py-2">
                                        <i class="fa-solid fa-cart-shopping me-1"></i> {{ __('messages.add') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <section id="about-section" class="py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="service-card">
                        <div class="service-icon"><i class="fa-solid fa-truck-fast"></i></div>
                        <h6 class="fw-bold mb-1" style="color: var(--dark-pink);">{{ __('messages.free_delivery') }}</h6>
                        <small class="text-muted">{{ __('messages.free_delivery_desc') }}</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="service-card">
                        <div class="service-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <h6 class="fw-bold mb-1" style="color: var(--dark-pink);">{{ __('messages.secure_payment') }}</h6>
                        <small class="text-muted">{{ __('messages.secure_payment_desc') }}</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="service-card">
                        <div class="service-icon"><i class="fa-solid fa-seedling"></i></div>
                        <h6 class="fw-bold mb-1" style="color: var(--dark-pink);">{{ __('messages.fresh_flowers') }}</h6>
                        <small class="text-muted">{{ __('messages.fresh_flowers_desc') }}</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="service-card">
                        <div class="service-icon"><i class="fa-solid fa-headset"></i></div>
                        <h6 class="fw-bold mb-1" style="color: var(--dark-pink);">{{ __('messages.support_24_7') }}</h6>
                        <small class="text-muted">{{ __('messages.support_24_7_desc') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer id="contact-section" class="site-footer">
        <div class="container text-center">
            <h4 class="brand justify-content-center mb-3">
                <span class="brand-flower">✿</span>
                <span>Pink Petals</span>
            </h4>
            <div class="mb-3">
                <a href="{{ route('home') }}">{{ __('messages.home') }}</a>
                <a href="{{ route('shop.products') }}">{{ __('messages.products') }}</a>
                <a href="#about-section">{{ __('messages.about_us') }}</a>
                <a href="#contact-section">{{ __('messages.contact') }}</a>
            </div>
            <div class="d-flex justify-content-center gap-3 mb-3 fs-5">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-telegram"></i></a>
            </div>
            <small class="text-muted">
                &copy; {{ date('Y') }} Pink Petals. {{ __('messages.all_rights_reserved') }} {{ __('messages.footer_tagline') }}
            </small>
        </div>
    </footer>

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