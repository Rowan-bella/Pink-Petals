<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping Cart | Pink Petals</title>
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
                <a href="{{ route('shop.products') }}" class="text-decoration-none text-dark fw-semibold">Products</a>
                <a href="{{ route('cart.index') }}" class="text-decoration-none fw-semibold" style="color: var(--pink-primary);">Cart</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        <h3 class="fw-bold mb-4" style="color: var(--pink-primary);">
            <i class="fa-solid fa-cart-shopping me-2"></i> Shopping Cart
        </h3>

        <div class="row g-4">
            <!-- Cart Items List -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3">Cart Items List</h5>
                    
                    @php $subtotal = 0; @endphp
                    @if(session('cart') && count(session('cart')) > 0)
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product Details</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('cart') as $id => $item)
                                        @php 
                                            $itemTotal = $item['price'] * $item['quantity'];
                                            $subtotal += $itemTotal;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ asset('storage/' . $item['image']) }}" class="rounded-3" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                                                    <div>
                                                        <h6 class="fw-bold mb-0">{{ $item['name'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ number_format($item['price']) }} MMK</td>
                                            <td>
                                                <!-- Quantity (+ / -) Form -->
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="input-group input-group-sm" style="width: 100px;">
                                                        <button type="submit" name="change" value="decrease" class="btn btn-outline-secondary px-1">-</button>
                                                        <input type="text" value="{{ $item['quantity'] }}" class="form-control text-center px-1 bg-white" readonly>
                                                        <button type="submit" name="change" value="increase" class="btn btn-outline-secondary px-1">+</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="fw-bold" style="color: var(--pink-primary);">{{ number_format($itemTotal) }} MMK</td>
                                            <td>
                                                <!-- Delete Single Item Button -->
                                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light text-danger border">
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
                        <p class="text-muted text-center py-4">သင့် Cart ထဲတွင် ပစ္စည်းများ မရှိသေးပါ။</p>
                    @endif
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3">Order Summary</h5>
                    
                    @php $subtotal = 0; @endphp
                    @if(session('cart') && count(session('cart')) > 0)
                        <div class="mb-3">
                            @foreach(session('cart') as $id => $item)
                                @php 
                                    $itemTotal = $item['price'] * $item['quantity'];
                                    $subtotal += $itemTotal;
                                @endphp
                                <div class="d-flex justify-content-between align-items-center mb-2 small">
                                    <span class="text-muted text-truncate" style="max-width: 150px;" title="{{ $item['name'] }}">
                                        {{ $item['name'] }} (x{{ $item['quantity'] }})
                                    </span>
                                    <span class="fw-semibold">{{ number_format($itemTotal) }} MMK</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">{{ number_format($subtotal ?? 0) }} MMK</span>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Grand Total</span>
                        <span class="fw-bold fs-5" style="color: var(--pink-primary);">{{ number_format($subtotal ?? 0) }} MMK</span>
                    </div>

                    <a href="{{route('checkout.index')}}" class="btn btn-pink w-100 rounded-pill py-2 fw-semibold mb-2">
                        Proceed to Checkout
                    </a>

                    <!-- ဆက်ဝယ်မည် (Continue Shopping) နှင့် အားလုံးကိုဖျက်မည် (Clear All) ခလုတ်များ -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('shop.products') }}" class="btn btn-outline-secondary w-50 rounded-pill py-2 small fw-semibold">
                            <i class="fa-solid fa-arrow-left me-1"></i> ဆက်ဝယ်မည်
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" class="w-50">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2 small fw-semibold">
                                <i class="fa-solid fa-trash me-1"></i> အားလုံးကိုဖျက်မည်
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>