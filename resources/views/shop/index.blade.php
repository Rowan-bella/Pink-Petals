<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.products') }} | Pink Petals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    :root {
        --pink: #ec4899;
        --pink-primary: #ec4899;
        --pink-deep: #be185d;
        --pink-hover: #db2777;
        --dark-pink: #71354c;
        --text-main: #581c42;
        --pink-bg: #fff5f7;
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
    }

    .card-custom {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid #fbcfe8;
        border-radius: 22px;
        box-shadow: 0 8px 22px rgba(190, 24, 93, 0.075);
    }

    .product-card {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid #fbcfe8;
        border-radius: 22px;
        box-shadow: 0 8px 22px rgba(190, 24, 93, 0.075);
        transition: all 0.25s ease;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(190, 24, 93, 0.13);
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

                <a href="{{ route('home') }}" class="nav-link-item">{{ __('messages.home') }}</a>
                <a href="{{ route('shop.products') }}" class="nav-link-item active">{{ __('messages.products') }}</a>
                <a href="{{ route('home') }}#about-section" class="nav-link-item">{{ __('messages.about_us') }}</a>
                <a href="{{ route('home') }}#contact-section" class="nav-link-item">{{ __('messages.contact') }}</a>
            </div>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#productsNavbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end mt-2 mt-lg-0" id="productsNavbarCollapse">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 gap-md-3">
                    @if(auth()->check())
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
                                       
                    @else
                    <a href="{{ route('login') }}" class="btn btn-pink btn-sm rounded-pill py-2 px-3">{{ __('messages.login') }}</a>
                    <a href="{{ route('register') }}" class="btn btn-pink btn-sm rounded-pill py-2 px-3">{{ __('messages.register') }}</a>
                    @endif

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

    <div class="container py-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row g-4">

            <div class="col-lg-3 col-md-4">
                <form
                    action="{{ isset($selectedCategory) ? route('shop.category', $selectedCategory->id) : route('shop.products') }}"
                    method="GET">
                    <h5 class="fw-bold mb-3" style="color: var(--pink-deep);">
                        <i class="fa-solid fa-seedling me-2"></i> {{ __('messages.categories') }}
                    </h5>
                    <ul class="list-group card-custom rounded-4 overflow-hidden p-2 mb-4">
                        @php
                        $totalProductsCount = \App\Models\Product::count();
                        @endphp
                        <a href="{{ route('shop.products') }}"
                            class="list-group-item list-group-item-action border-0 rounded-3 mb-1 d-flex justify-content-between align-items-center {{ !isset($selectedCategory) ? 'text-white' : 'text-dark' }}"
                            style="{{ !isset($selectedCategory) ? 'background: linear-gradient(110deg, #f472b6, #ec4899 60%, #db2777);' : 'background-color: transparent;' }}">
                            <span class="fw-semibold">{{ __('messages.all_products') }}</span>
                            <span
                                class="badge rounded-pill {{ !isset($selectedCategory) ? 'bg-white text-dark' : 'bg-light text-muted' }}"
                                style="font-size: 0.8rem;">
                                {{ $totalProductsCount }}
                            </span>
                        </a>

                        @foreach($categories as $cat)
                        @php
                        $isActive = isset($selectedCategory) && $selectedCategory->id == $cat->id;
                        @endphp
                        <a href="{{ route('shop.category', $cat->id) }}"
                            class="list-group-item list-group-item-action border-0 rounded-3 mb-1 d-flex justify-content-between align-items-center {{ $isActive ? 'text-white' : 'text-dark' }}"
                            style="{{ $isActive ? 'background: linear-gradient(110deg, #f472b6, #ec4899 60%, #db2777);' : 'background-color: transparent;' }}">
                            <span class="fw-semibold">{{ $cat->name }}</span>
                            <span
                                class="badge rounded-pill {{ $isActive ? 'bg-white text-dark' : 'bg-light text-muted' }}"
                                style="font-size: 0.8rem;">
                                {{ $cat->products_count }}
                            </span>
                        </a>
                        @endforeach
                    </ul>

                    <h5 class="fw-bold mb-3" style="color: var(--pink-deep);">
                        <i class="fa-solid fa-tags me-2"></i> {{ __('messages.price_range') }}
                    </h5>
                    <div class="card card-custom rounded-4 p-3 mb-4">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="prices[]" value="under_40k"
                                id="price1" {{ in_array('under_40k', request('prices', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="price1">{{ __('messages.under_40k_mmk') }}</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="prices[]" value="40k_60k" id="price2"
                                {{ in_array('40k_60k', request('prices', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="price2">{{ __('messages.range_40k_60k_mmk') }}</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="prices[]" value="60k_80k" id="price3"
                                {{ in_array('60k_80k', request('prices', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="price3">{{ __('messages.range_60k_80k_mmk') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="prices[]" value="over_80k" id="price4"
                                {{ in_array('over_80k', request('prices', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="price4">{{ __('messages.over_80k_mmk') }}</label>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3" style="color: var(--pink-deep);">
                        <i class="fa-solid fa-box-open me-2"></i> {{ __('messages.availability') }}
                    </h5>
                    <div class="card card-custom rounded-4 p-3 mb-4">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="availability[]" value="in_stock"
                                id="inStock" {{ in_array('in_stock', request('availability', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="inStock">{{ __('messages.in_stock') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="availability[]" value="out_stock"
                                id="outStock" {{ in_array('out_stock', request('availability', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="outStock">{{ __('messages.out_of_stock') }}</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-pink w-100 rounded-pill py-2 fw-semibold shadow-sm">
                        {{ __('messages.apply_filter') }}
                    </button>
                </form>
            </div>

            <div class="col-lg-9 col-md-8">
                <h3 class="fw-bold mb-4" style="color: var(--dark-pink);">
                    {{ isset($selectedCategory) ? $selectedCategory->name : __('messages.beautiful_flowers_every_moment') }}
                </h3>

                <div class="row">
                    @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card product-card h-100 position-relative">

                            @php
                            $isWishlisted = auth()->check() && \App\Models\Wishlist::where('user_id',
                            auth()->id())->where('product_id', $product->id)->exists();
                            @endphp

                            @if(auth()->check())
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST"
                                class="position-absolute top-0 end-0 m-3 z-3">
                                @csrf
                                <button type="submit"
                                    class="btn btn-light rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center"
                                    style="width: 38px; height: 38px;">
                                    @if($isWishlisted)
                                    <i class="fa-solid fa-heart text-danger fs-5"></i>
                                    @else
                                    <i class="fa-regular fa-heart text-secondary fs-5"></i>
                                    @endif
                                </button>
                            </form>
                            @else
                            <div class="position-absolute top-0 end-0 m-3 z-3">
                                <button type="button" onclick="toggleGuestWishlist({{ data_get($product, 'id') }})"
                                    class="btn btn-light rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center"
                                    style="width: 38px; height: 38px;">
                                    <i class="fa-regular fa-heart text-secondary fs-5"
                                        id="heart-icon-{{ data_get($product, 'id') }}"></i>
                                </button>
                            </div>
                            @endif
                            @if(data_get($product, 'image'))
                            <img src="{{ asset('storage/' . data_get($product, 'image')) }}"
                                class="card-img-top p-3 rounded-4" alt="{{ data_get($product, 'name') }}"
                                style="height: 160px; object-fit: cover;">
                            @else
                            <img src="{{ asset('images/default.jpg') }}" class="card-img-top p-3 rounded-4"
                                alt="{{ __('messages.default_image') }}" style="height: 160px; object-fit: cover;">
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-bold text-truncate mb-1"
                                    title="{{ data_get($product, 'name') }}">
                                    {{ data_get($product, 'name') }}
                                </h6>

                                <p class="text-muted small mb-1">
                                    {{ data_get($product, 'category.name') ?? __('messages.uncategorized') }}</p>
                                <div class="mb-2 d-flex align-items-center gap-1"
                                    onclick="openRatingAlert({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                    style="cursor: pointer;" title="{{ __('messages.click_to_rate_product') }}">
                                    @php
                                    $avgRating = method_exists($product, 'averageRating') ? $product->averageRating() :
                                    0;
                                    $ratingCount = method_exists($product, 'ratings') ? $product->ratings()->count() :
                                    0;
                                    $roundedRating = round($avgRating);
                                    @endphp

                                    <div class="star-rating" id="stars-{{ $product->id }}">
                                        @for ($i = 1; $i <= 5; $i++) <i
                                            class="{{ $i <= $roundedRating ? 'fa-solid text-warning' : 'fa-regular text-muted' }} fa-star">
                                            </i>
                                            @endfor
                                    </div>

                                    <span class="fw-bold text-dark small ms-1"
                                        id="avg-rating-{{ $product->id }}">{{ number_format($avgRating, 1) }}</span>
                                    <span class="text-muted" id="rating-count-{{ $product->id }}"
                                        style="font-size: 0.75rem;">({{ $ratingCount }})</span>
                                </div>
                                <div class="mb-2">
                                    @if(data_get($product, 'stock', 0) > 0)
                                    <span
                                        class="badge bg-success-subtle text-success border border-success-subtle rounded-pill"
                                        style="font-size: 0.75rem;">
                                        {{ __('messages.stock_label') }}: {{ data_get($product, 'stock') }}
                                    </span>
                                    @else
                                    <span
                                        class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill"
                                        style="font-size: 0.75rem;">
                                        {{ __('messages.out_of_stock') }}
                                    </span>
                                    @endif
                                </div>

                                @if(data_get($product, 'description'))
                                <div class="text-muted small mb-2" style="font-size: 0.8rem; line-height: 1.4;">
                                    {{ data_get($product, 'description') }}
                                </div>
                                @endif

                                <p class="fw-bold mb-3 small" style="color: var(--pink-deep);">
                                    {{ number_format(data_get($product, 'price', 0)) }} {{ __('messages.mmk') }}
                                </p>

                                <div class="mt-auto">
                                    @if(data_get($product, 'stock', 0) > 0)
                            
                                    <form action="{{ route('cart.add', data_get($product, 'id')) }}" method="POST"
                                        onsubmit="addToCartWithSweetAlert(event, this, {{ data_get($product, 'stock') }})">
                                        @csrf
                                        <div class="d-flex align-items-center gap-1">
                                            <div class="input-group input-group-sm" style="width: 100px;">
                                                <button type="button" class="btn btn-outline-secondary px-1"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                                                <input type="number" name="quantity" value="1" min="1"
                                                    id="qty-{{ data_get($product, 'id') }}"
                                                    class="form-control text-center px-1">
                                                <button type="button" class="btn btn-outline-secondary px-1"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                                            </div>

                                            @if(auth()->check())
                                            <button type="submit" class="btn btn-pink btn-sm flex-grow-1 py-1 rounded-pill"
                                                style="font-size: 0.75rem;">
                                                <i class="fa-solid fa-cart-shopping"></i> {{ __('messages.add') }}
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-pink btn-sm flex-grow-1 py-1 rounded-pill"
                                                style="font-size: 0.75rem;"
                                                onclick="showLoginAlert({{ data_get($product, 'id') }})">
                                                <i class="fa-solid fa-cart-shopping"></i> {{ __('messages.add') }}
                                            </button>
                                            @endif
                                        </div>
                                    </form>
                                    @else
                                    <button type="button" class="btn btn-secondary w-100 rounded-pill py-1" disabled
                                        style="font-size: 0.85rem;">
                                        {{ __('messages.out_of_stock') }}
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">{{ __('messages.no_matching_products') }}</p>
                    </div>
                    @endforelse
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
    <script>
    const loginUrl = "{{ route('login') }}";
    const isLoggedIn = @json(auth()->check());
    const i18n = {
        loginRequiredTitle: @json(__('messages.login_required_title')),
        loginRequiredCartText: @json(__('messages.login_required_cart_text')),
        loginRequiredRatingText: @json(__('messages.login_required_rating_text')),
        loginBtn: @json(__('messages.login_btn')),
        cancelBtn: @json(__('messages.cancel_btn')),
        wishlistRemovedToast: @json(__('messages.wishlist_removed_toast')),
        wishlistAddedToast: @json(__('messages.wishlist_added_toast')),
        stockExceededTitle: @json(__('messages.stock_exceeded_title')),
        stockExceededTextPrefix: @json(__('messages.stock_exceeded_text_prefix')),
        stockExceededTextSuffix: @json(__('messages.stock_exceeded_text_suffix')),
        successTitle: @json(__('messages.success_title')),
        okBtn: @json(__('messages.ok_btn')),
        rateProductPrefix: @json(__('messages.rate_product_prefix')),
        clickStarPrompt: @json(__('messages.click_star_prompt')),
        ratingInstantNote: @json(__('messages.rating_instant_note'))
    };

    function showLoginAlert(productId) {
        let qtyInput = document.getElementById('qty-' + productId);
        let qty = qtyInput ? qtyInput.value : 1;

        Swal.fire({
            title: i18n.loginRequiredTitle,
            text: i18n.loginRequiredCartText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ec4899',
            cancelButtonColor: '#6c757d',
            confirmButtonText: i18n.loginBtn,
            cancelButtonText: i18n.cancelBtn
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = loginUrl + "?product_id=" + productId + "&quantity=" + qty;
            }
        });
    }

    function toggleGuestWishlist(productId) {
        let wishlist = JSON.parse(localStorage.getItem('guest_wishlist')) || [];
        let index = wishlist.indexOf(productId);
        let icon = document.getElementById('heart-icon-' + productId);

        if (index > -1) {
            wishlist.splice(index, 1);
            if (icon) {
                icon.classList.remove('fa-solid', 'text-danger');
                icon.classList.add('fa-regular', 'text-secondary');
            }
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: i18n.wishlistRemovedToast,
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            wishlist.push(productId);
            if (icon) {
                icon.classList.remove('fa-regular', 'text-secondary');
                icon.classList.add('fa-solid', 'text-danger');
            }
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: i18n.wishlistAddedToast,
                showConfirmButton: false,
                timer: 1500
            });
        }

        localStorage.setItem('guest_wishlist', JSON.stringify(wishlist));
    }

    document.addEventListener("DOMContentLoaded", function() {
        let wishlist = JSON.parse(localStorage.getItem('guest_wishlist')) || [];
        wishlist.forEach(id => {
            let icon = document.getElementById('heart-icon-' + id);
            if (icon) {
                icon.classList.remove('fa-regular', 'text-secondary');
                icon.classList.add('fa-solid', 'text-danger');
            }
        });
    });

    function addToCartWithSweetAlert(event, form, maxStock) {
        event.preventDefault();

        let qtyInput = form.querySelector('input[name="quantity"]');
        let selectedQty = parseInt(qtyInput.value);

        if (selectedQty > maxStock) {
            Swal.fire({
                title: i18n.stockExceededTitle,
                text: i18n.stockExceededTextPrefix + maxStock + i18n.stockExceededTextSuffix,
                icon: 'warning',
                confirmButtonText: i18n.okBtn
            });
            return false;
        }

        let formData = new FormData(form);
        let actionUrl = form.action;

        fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data && data.success) {
                    if (typeof data.cartCount !== 'undefined') {
                        const badge = document.getElementById('cart-count-badge');
                        if (badge) {
                            badge.innerText = data.cartCount;
                        }
                    }
                    Swal.fire({
                        title: i18n.successTitle,
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: i18n.okBtn,
                        allowOutsideClick: false
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function openRatingAlert(productId, productName) {
        if (!isLoggedIn) {
            Swal.fire({
                title: i18n.loginRequiredTitle,
                text: i18n.loginRequiredRatingText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ec4899',
                cancelButtonColor: '#6c757d',
                confirmButtonText: i18n.loginBtn,
                cancelButtonText: i18n.cancelBtn
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = loginUrl;
                }
            });
            return;
        }

        fetch(`/products/${productId}/user-rating`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                let existingRating = data.user_rating || 0;

                Swal.fire({
                    title: `${i18n.rateProductPrefix} ${productName}`,
                    html: `
                <p class="text-muted small mb-3">${i18n.clickStarPrompt}</p>
                <div id="swal-star-box" class="d-flex justify-content-center gap-2 fs-1 mb-2" style="cursor: pointer;">
                    <i class="fa-solid fa-star swal-star" data-val="1" style="color: ${existingRating >= 1 ? '#ffc107' : '#dcdcdc'}; transition: 0.2s;"></i>
                    <i class="fa-solid fa-star swal-star" data-val="2" style="color: ${existingRating >= 2 ? '#ffc107' : '#dcdcdc'}; transition: 0.2s;"></i>
                    <i class="fa-solid fa-star swal-star" data-val="3" style="color: ${existingRating >= 3 ? '#ffc107' : '#dcdcdc'}; transition: 0.2s;"></i>
                    <i class="fa-solid fa-star swal-star" data-val="4" style="color: ${existingRating >= 4 ? '#ffc107' : '#dcdcdc'}; transition: 0.2s;"></i>
                    <i class="fa-solid fa-star swal-star" data-val="5" style="color: ${existingRating >= 5 ? '#ffc107' : '#dcdcdc'}; transition: 0.2s;"></i>
                </div>
                <p class="text-muted mt-3 mb-0" style="font-size: 0.75rem;">${i18n.ratingInstantNote}</p>
            `,
                    showConfirmButton: false,
                    showCloseButton: true,
                    didOpen: () => {
                        const stars = Swal.getPopup().querySelectorAll('.swal-star');

                        stars.forEach((star, index) => {
                            star.addEventListener('mouseover', () => {
                                stars.forEach((s, i) => {
                                    s.style.color = i <= index ? '#ffc107' :
                                        '#dcdcdc';
                                });
                            });
                            star.addEventListener('mouseout', () => {
                                stars.forEach((s, i) => {
                                    s.style.color = i < existingRating ?
                                        '#ffc107' : '#dcdcdc';
                                });
                            });
                            star.addEventListener('click', () => {
                                const selectedRating = star.getAttribute('data-val');
                                existingRating = selectedRating;
                                submitRatingToServer(productId, selectedRating);
                            });
                        });
                    }
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function submitRatingToServer(productId, rating) {
        fetch(`/products/${productId}/rating`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    rating: rating
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.close();

                    document.getElementById('avg-rating-' + productId).innerText = data.average;
                    document.getElementById('rating-count-' + productId).innerText = `(${data.count})`;

                    let starContainer = document.getElementById('stars-' + productId);
                    let stars = starContainer.querySelectorAll('i');
                    let rounded = Math.round(parseFloat(data.average));
                    stars.forEach((star, index) => {
                        if (index < rounded) {
                            star.className = 'fa-solid text-warning fa-star';
                        } else {
                            star.className = 'fa-regular text-muted fa-star';
                        }
                    });

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }
    </script>
</body>

</html>