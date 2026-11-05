<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products | Pink Petals</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-bg: #fff5f7;
        }
        body {
            background-color: var(--pink-bg);
            color: #563b47;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .btn-pink {
            background-color: var(--pink-primary);
            color: white;
            border: none;
        }
        .btn-pink:hover {
            background-color: #b04c71;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}" style="color: var(--pink-primary);">
                🌸 Pink Petals
            </a>
            <div class="ms-auto d-flex gap-3 align-items-center">
                <a href="{{ route('home') }}" class="text-decoration-none text-dark fw-semibold">Home</a>
                <a href="{{ route('shop.products') }}" class="text-decoration-none fw-semibold" style="color: var(--pink-primary);">Products</a>
                
                @if(auth()->check())
                    <span class="fw-semibold text-secondary small d-none d-md-inline">
                        <i class="fa-solid fa-user me-1" style="color: var(--pink-primary);"></i> မင်္ဂလာပါ၊ {{ auth()->user()->name }}
                    </span>
                    @php
                        $cartCount = 0;
                        if(session('cart')) {
                            foreach(session('cart') as $item) {
                                $cartCount += $item['quantity'];
                            }
                        }
                    @endphp
                    <a href="{{route('cart.index')}}" class="text-decoration-none text-dark fw-semibold position-relative me-2">
                        <i class="fa-solid fa-cart-shopping fs-5" style="color: var(--pink-primary);"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                            {{ $cartCount }}
                        </span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-decoration-none text-dark fw-semibold">Login</a>
                    <a href="{{ route('register') }}" class="text-decoration-none text-dark fw-semibold">Register</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            
            <!-- ဘယ်ဘက်ခြမ်း Sidebar (Filter Form သီးသန့် - မူလအတိုင်း အပြည့်အစုံ) -->
            <div class="col-lg-3 col-md-4">
                <form action="{{ isset($selectedCategory) ? route('shop.category', $selectedCategory->id) : route('shop.products') }}" method="GET">
                    
                    <!-- 1. Categories Box -->
                    <h5 class="fw-bold mb-3" style="color: var(--pink-primary);">
                        <i class="fa-solid fa-seedling me-2"></i> Categories
                    </h5>
                    <ul class="list-group shadow-sm rounded-4 overflow-hidden border-0 bg-white p-2 mb-4">
                        @php
                            $totalProductsCount = \App\Models\Product::count();
                        @endphp
                        <a href="{{ route('shop.products') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 d-flex justify-content-between align-items-center {{ !isset($selectedCategory) ? 'text-white' : 'text-dark' }}" style="{{ !isset($selectedCategory) ? 'background-color: var(--pink-primary);' : 'background-color: transparent;' }}">
                            <span class="fw-semibold">All Products</span>
                            <span class="badge rounded-pill {{ !isset($selectedCategory) ? 'bg-white text-dark' : 'bg-light text-muted' }}" style="font-size: 0.8rem;">
                                {{ $totalProductsCount }}
                            </span>
                        </a>

                        @foreach($categories as $cat)
                            @php
                                $isActive = isset($selectedCategory) && $selectedCategory->id == $cat->id;
                            @endphp
                            <a href="{{ route('shop.category', $cat->id) }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 d-flex justify-content-between align-items-center {{ $isActive ? 'text-white' : 'text-dark' }}" style="{{ $isActive ? 'background-color: var(--pink-primary);' : 'background-color: transparent;' }}">
                                <span class="fw-semibold">{{ $cat->name }}</span>
                                <span class="badge rounded-pill {{ $isActive ? 'bg-white text-dark' : 'bg-light text-muted' }}" style="font-size: 0.8rem;">
                                    {{ $cat->products_count }}
                                </span>
                            </a>
                        @endforeach
                    </ul>

                    <!-- 2. Price Range Box -->
                    <h5 class="fw-bold mb-3" style="color: var(--pink-primary);">
                        <i class="fa-solid fa-tags me-2"></i> Price Range
                    </h5>
                    <div class="card shadow-sm border-0 rounded-4 p-3 mb-4 bg-white">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="prices[]" value="under_40k" id="price1" {{ in_array('under_40k', request('prices', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="price1">Under 40,000 MMK</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="prices[]" value="40k_60k" id="price2" {{ in_array('40k_60k', request('prices', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="price2">40,000 - 60,000 MMK</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="prices[]" value="60k_80k" id="price3" {{ in_array('60k_80k', request('prices', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="price3">60,000 - 80,000 MMK</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="prices[]" value="over_80k" id="price4" {{ in_array('over_80k', request('prices', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="price4">Over 80,000 MMK</label>
                        </div>
                    </div>

                    <!-- 3. Availability Box -->
                    <h5 class="fw-bold mb-3" style="color: var(--pink-primary);">
                        <i class="fa-solid fa-box-open me-2"></i> Availability
                    </h5>
                    <div class="card shadow-sm border-0 rounded-4 p-3 mb-4 bg-white">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="availability[]" value="in_stock" id="inStock" {{ in_array('in_stock', request('availability', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="inStock">In Stock</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="availability[]" value="out_stock" id="outStock" {{ in_array('out_stock', request('availability', [])) ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="outStock">Out of Stock</label>
                        </div>
                    </div>

                    <!-- Apply Filter Button -->
                    <button type="submit" class="btn btn-pink w-100 rounded-pill py-2 fw-semibold shadow-sm">
                        Apply Filter
                    </button>
                </form>
            </div>

            <!-- ညာဘက်ခြမ်း Products Cards များ -->
            <div class="col-lg-9 col-md-8">
                <h3 class="fw-bold mb-4" style="color: var(--pink-primary);">
                    {{ isset($selectedCategory) ? $selectedCategory->name : 'Beautiful Flowers for Every Moment' }}
                </h3>
                
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm border-0 rounded-4">
                                @if(data_get($product, 'image'))
                                    <img src="{{ asset('storage/' . data_get($product, 'image')) }}" class="card-img-top p-3 rounded-4" alt="{{ data_get($product, 'name') }}" style="height: 160px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/default.jpg') }}" class="card-img-top p-3 rounded-4" alt="Default Image" style="height: 160px; object-fit: cover;">
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title fw-bold text-truncate mb-1" title="{{ data_get($product, 'name') }}">
                                        {{ data_get($product, 'name') }}
                                    </h6>
                                    
                                    <p class="text-muted small mb-1">{{ data_get($product, 'category.name') ?? 'Uncategorized' }}</p>

                                    <div class="mb-2">
                                        @if(data_get($product, 'stock', 0) > 0)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill" style="font-size: 0.75rem;">
                                                Stock: {{ data_get($product, 'stock') }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill" style="font-size: 0.75rem;">
                                                Out of Stock
                                            </span>
                                        @endif
                                    </div>

                                    @if(data_get($product, 'description'))
                                        <div class="text-muted small mb-2" style="font-size: 0.8rem; line-height: 1.4;">
                                            {{ data_get($product, 'description') }}
                                        </div>
                                    @endif

                                    <p class="fw-bold mb-3 small" style="color: var(--pink-primary);">
                                        {{ number_format(data_get($product, 'price', 0)) }} MMK
                                    </p>
                                    
                                    <div class="mt-auto">
                                        @if(data_get($product, 'stock', 0) > 0)
                                            <form action="{{ route('cart.add', data_get($product, 'id')) }}" method="POST" onsubmit="return checkStock(event, {{ data_get($product, 'stock') }})">
                                                @csrf
                                                <div class="d-flex align-items-center gap-1">
                                                    <div class="input-group input-group-sm" style="width: 100px;">
                                                        <button type="button" class="btn btn-outline-secondary px-1" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                                                        <input type="number" name="quantity" value="1" min="1" id="qty-{{ data_get($product, 'id') }}" class="form-control text-center px-1">
                                                        <button type="button" class="btn btn-outline-secondary px-1" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                                                    </div>

                                                    @if(auth()->check())
                                                        <button type="submit" class="btn btn-pink btn-sm flex-grow-1 py-1" style="font-size: 0.75rem;">
                                                            <i class="fa-solid fa-cart-shopping"></i> Add
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-pink btn-sm flex-grow-1 py-1" style="font-size: 0.75rem;" onclick="showLoginAlert({{ data_get($product, 'id') }})">
                                                            <i class="fa-solid fa-cart-shopping"></i> Add
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-secondary w-100 rounded-pill py-1" disabled style="font-size: 0.85rem;">
                                                Out of Stock
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">ယခုလောလောဆယ် ရွေးချယ်ထားသော အချက်အလက်များနှင့် ကိုက်ညီသော ပန်းပစ္စည်းများ မရှိသေးပါ။</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const loginUrl = "{{ route('login') }}";
        const isLoggedIn = @json(auth()->check());

        // Login မဝင်ရသေးလျှင် product_id ကို URL တွင် တွဲ၍ Login မျက်နှာပြင်သို့ ခေါ်သွားမည်
        function showLoginAlert(productId) {
            let confirmLogin = confirm("ကျေးဇူးပြု၍ Login အရင်ဝင်ပေးပါရှင်။");
            if (confirmLogin) {
                window.location.href = loginUrl + "?product_id=" + productId;
            }
        }

        function checkStock(event, maxStock) {
            if (!isLoggedIn) {
                event.preventDefault();
                return false;
            }

            let qtyInput = event.target.querySelector('input[name="quantity"]');
            let selectedQty = parseInt(qtyInput.value);

            if (selectedQty > maxStock) {
                alert("တောင်းဆိုထားသော ပမာဏသည် လက်ကျန် Stock (" + maxStock + ") ထက် ကျော်လွန်နေပါသည်။");
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>
</body>
</html>