<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pink Petals | Flower Shop</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --pink: #d95785;
            --pink-primary: #d95785;
            --dark-pink: #71354c;
            --light-pink: #fff0f3;
            --cream: #fffaf7;
        }

        body {
            background: var(--cream);
            color: #49313b;
            font-family: 'DM Sans', sans-serif;
        }

        h1, h2, h3, h4, .brand {
            font-family: 'Playfair Display', serif;
        }

        .navbar {
            background: rgba(255, 250, 247, 0.97);
            padding: 16px 0;
            border-bottom: 1px solid #f7e3e8;
        }

        .brand {
            color: var(--pink);
            font-size: 30px;
            font-style: italic;
            font-weight: 700;
            text-decoration: none;
        }

        .hero {
            background: linear-gradient(110deg, #ffe8ed, #fff1ed);
            padding: 60px 0;
        }

        .hero h1 {
            font-size: clamp(38px, 5vw, 55px);
            font-weight: 700;
            line-height: 1.15;
            margin: 18px 0;
        }

        .pink-text {
            color: var(--pink);
            font-style: italic;
        }

        .hero-image {
            width: 100%;
            height: 380px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(113, 53, 76, 0.1);
        }

        .btn-pink {
            background: var(--pink);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 12px 28px;
            text-decoration: none;
            transition: 0.3s;
            font-weight: 600;
        }

        .btn-pink:hover {
            background: var(--dark-pink);
            color: white;
        }

        /* Category Section */
        .category-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid #f7e3e8;
            transition: 0.3s;
            text-align: center;
            padding-bottom: 15px;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(113, 53, 76, 0.08);
        }
        .category-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        /* Product Card */
        .product-card {
            background: white;
            border-radius: 15px;
            border: 1px solid #f6e2e8;
            overflow: hidden;
            transition: 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(113, 53, 76, 0.1);
        }
        .product-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: var(--light-pink);
        }

        /* Gift Banner */
        .gift-banner {
            background: linear-gradient(100deg, #f9dce5, #fff0f2);
            border-radius: 20px;
            overflow: hidden;
        }

        /* Services */
        .service-box {
            text-align: center;
            padding: 15px;
        }
        .service-icon {
            font-size: 26px;
            color: var(--pink);
            margin-bottom: 8px;
        }

        /* Footer */
        footer {
            background: #633448;
            color: white;
            padding: 40px 0 20px;
        }
        footer a {
            color: white;
            text-decoration: none;
            margin: 0 12px;
            font-size: 14px;
        }
        footer a:hover {
            color: #ffc3d5;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="brand" href="{{ route('home') }}">
                🌸 Pink Petals
            </a>
            
            <div class="ms-auto d-flex gap-3 align-items-center">
                <a href="{{ route('home') }}" class="text-decoration-none text-dark fw-semibold">Home</a>
                <a href="{{ route('shop.products') }}" class="text-decoration-none text-dark fw-semibold">Products</a>
                
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

                    <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark fw-semibold position-relative ms-2 me-2">
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="text-uppercase fw-bold text-muted small mb-2" style="letter-spacing: 2px;">Fresh Flowers, Happy Moments ♥</div>
                    <h1>
                        Say it with<br>
                        beautiful <span class="pink-text">flowers.</span>
                    </h1>
                    <p class="text-muted mb-4" style="line-height: 1.8;">
                        Every petal tells a story. Find the perfect bouquet to celebrate love, friendship, birthdays and all of life's little moments.
                    </p>
                    <a href="{{ route('shop.products') }}" class="btn-pink">
                        Shop Now &nbsp; →
                    </a>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/hero5.jpg') }}" alt="Flower Bouquet" class="hero-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Shop By Category Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-uppercase text-muted small" style="letter-spacing: 2px;">Shop By Category</span>
                <h2 class="fw-bold mt-1" style="color: var(--dark-pink);">Find Your Perfect Bloom</h2>
                <p class="text-muted small">A little something for every special moment.</p>
            </div>

            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('shop.products', ['category' => $category->id]) }}" class="text-decoration-none">
                            <div class="category-card shadow-sm p-3 bg-white rounded-4 text-center">
                                {{-- Category ပုံ (Database တွင် ပုံသိမ်းထားသည့် Column အမည်အလိုက် ချိန်ရန် ဥပမာ - $category->image) --}}
                                <img src="{{ asset('storage/' . $category->image) }}" class="category-img mb-3 rounded-3" style="width: 100%; height: 150px; object-fit: cover;" alt="{{ $category->name }}">
                                
                                <h6 class="fw-bold mb-1 text-dark">{{ $category->name }}</h6>
                                
                                {{-- Controller ထဲက withCount('products') ဖြင့် ရလာသော အရေအတွက်ကို ပြသရန် --}}
                                <small class="text-muted">{{ $category->products_count }} Products</small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
<!-- Best Sellers Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-uppercase text-muted small" style="letter-spacing: 2px;">Best Sellers</span>
                <h2 class="fw-bold mt-1" style="color: var(--dark-pink);">Flowers You'll Love</h2>
                <p class="text-muted small">Customer များ အများဆုံး ဝယ်ယူအားပေးကြသော အရောင်းရဆုံး ပစ္စည်းများ</p>
            </div>

            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-6 col-lg-3">
                        <div class="product-card p-3 shadow-sm rounded-4 border d-flex flex-column h-100 bg-white">
                            <!-- Product Image -->
                            <img src="{{ asset('storage/' . $product->image) }}" class="product-image rounded-3 mb-3" style="width: 100%; height: 180px; object-fit: cover;" alt="{{ $product->name }}">
                            
                            <!-- Product Name -->
                            <h6 class="fw-bold mb-1 text-dark">{{ $product->name }}</h6>
                            
                            <!-- Category Name (ဟိုဘက် Page လိုမျိုး Category ပါ ပြလိုပါက) -->
                            <small class="text-muted mb-2">{{ $product->category->name ?? 'Flower Gifts' }}</small>

                            <!-- Stock Badge -->
                            <div class="mb-2">
                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1" style="font-size: 0.75rem;">
                                    Stock: {{ $product->stock }}
                                </span>
                            </div>

                            <!-- Description (Str::limit ကို ဖြုတ်၍ အပြည့်အစုံ ပြသရန်) -->
                            <p class="text-muted small mb-3" style="font-size: 0.8rem; line-height: 1.4;">
                               {{ $product->description }}
                            </p>                            
                            <!-- Price -->
                            <div class="fw-bold mb-3 fs-5" style="color: var(--pink);">
                                {{ number_format($product->price) }} MMK
                            </div>

                            <!-- Quantity Selector & Add to Cart Form (ဟိုဘက် Page ပုံစံအတိုင်း) -->
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
                                    
                                    <button type="submit" class="btn btn-pink btn-sm w-100 rounded-pill py-2" style="background: var(--pink); color: white;">
                                        <i class="fa-solid fa-cart-shopping me-1"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Services Section -->
    <section class="py-4 bg-light border-top border-bottom">
        <div class="container">
            <div class="row text-center">
                <div class="col-6 col-md-3 service-box">
                    <div class="service-icon"><i class="fa-solid fa-truck-fast"></i></div>
                    <h6 class="fw-bold mb-1">Free Delivery</h6>
                    <small class="text-muted">On selected orders</small>
                </div>
                <div class="col-6 col-md-3 service-box">
                    <div class="service-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <h6 class="fw-bold mb-1">Secure Payment</h6>
                    <small class="text-muted">100% safe & secure</small>
                </div>
                <div class="col-6 col-md-3 service-box">
                    <div class="service-icon"><i class="fa-solid fa-seedling"></i></div>
                    <h6 class="fw-bold mb-1">Fresh Flowers</h6>
                    <small class="text-muted">Always fresh & beautiful</small>
                </div>
                <div class="col-6 col-md-3 service-box">
                    <div class="service-icon"><i class="fa-solid fa-headset"></i></div>
                    <h6 class="fw-bold mb-1">24/7 Support</h6>
                    <small class="text-muted">We're here for you</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <h4 class="brand text-white mb-3">🌸 Pink Petals</h4>
            <div class="mb-3">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('shop.products') }}">Products</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
            </div>
            <div class="d-flex justify-content-center gap-3 mb-3 fs-5">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-telegram"></i></a>
            </div>
            <small class="text-white-50">&copy; 2026 Pink Petals. All rights reserved. Flowers make life more beautiful.</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>