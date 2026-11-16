<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Wishlist | Pink Petals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <a href="{{ route('shop.products') }}" class="text-decoration-none text-dark fw-semibold">Products</a>
                
                @if(auth()->check())
                    <span class="fw-semibold text-secondary small d-none d-md-inline">
                        <i class="fa-solid fa-user me-1" style="color: var(--pink-primary);"></i> မင်္ဂလာပါ၊ {{ auth()->user()->name }}
                    </span>
                    <a href="{{ route('user.orders') }}" class="text-decoration-none text-dark fw-semibold">
                        <i class="fa-solid fa-bag-shopping" style="color: var(--pink-primary);"></i> My Orders
                    </a>
                    
                    @php
                        $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
                    @endphp

                    <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark fw-semibold position-relative me-2">
                        <i class="fa-solid fa-cart-shopping fs-5" style="color: var(--pink-primary);"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                            {{ $cartCount }}
                        </span>
                    </a>

                    <a href="{{ route('wishlist.index') }}" class="text-decoration-none fw-semibold d-flex align-items-center gap-1" style="color: var(--pink-primary);">
                        <i class="fa-solid fa-heart text-danger"></i> Wishlist
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
    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h3 class="fw-bold mb-4" style="color: var(--pink-primary);">
            <i class="fa-solid fa-heart text-danger me-2"></i> My Wishlist Products
        </h3>

        @if($wishlists->isEmpty())
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <i class="fa-regular fa-heart text-muted mb-3" style="font-size: 3rem;"></i>
                <p class="text-muted fs-5">သင်၏ Wishlist ထဲတွင် စိတ်ကြိုက်မှတ်သားထားသော ပစ္စည်းများ မရှိသေးပါ။</p>
                <a href="{{ route('shop.products') }}" class="btn btn-pink rounded-pill px-4 mt-2">Shop သို့ သွားမည်</a>
            </div>
        @else
            <div class="row">
                @foreach($wishlists as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0 rounded-4">
                            @if(data_get($item->product, 'image'))
                                <img src="{{ asset('storage/' . data_get($item->product, 'image')) }}" class="card-img-top p-3 rounded-4" alt="{{ data_get($item->product, 'name') }}" style="height: 160px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default.jpg') }}" class="card-img-top p-3 rounded-4" alt="Default Image" style="height: 160px; object-fit: cover;">
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-bold text-truncate mb-1" title="{{ data_get($item->product, 'name') }}">
                                    {{ data_get($item->product, 'name') }}
                                </h6>
                                
                                <p class="text-muted small mb-1">{{ data_get($item->product, 'category.name') ?? 'Uncategorized' }}</p>

                                <p class="fw-bold mb-3 small" style="color: var(--pink-primary);">
                                    {{ number_format(data_get($item->product, 'price', 0)) }} MMK
                                </p>
                                
                                <div class="mt-auto d-flex gap-2">
                                
                                    <a href="{{ route('shop.products') }}" class="btn btn-outline-secondary btn-sm flex-grow-1 py-1 rounded-pill" style="font-size: 0.75rem;">
                                        View Details
                                    </a>
                                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 py-1 rounded-pill" style="font-size: 0.75rem;">
                                            <i class="fa-solid fa-trash me-1"></i> Remove
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