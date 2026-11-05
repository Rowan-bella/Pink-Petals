<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout | Pink Petals</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-bg: #fff5f7;
            --pink-hover: #b04c71;
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
            background-color: var(--pink-hover);
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
        <!-- Pink Petals Theme Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 p-4 rounded-4 text-white shadow-sm" style="background-color: var(--pink-primary);">
            <div class="d-flex align-items-center gap-3">
                <i class="fa-solid fa-bag-shopping fs-3"></i>
                <div>
                    <h4 class="mb-0 fw-bold">Order Checkout</h4>
                    <small class="opacity-75">သင့်ရဲ့ မှာယူမှုအချက်အလက်များကို ဖြည့်သွင်းပြီး အတည်ပြုပါ</small>
                </div>
            </div>
            <div class="d-none d-md-flex align-items-center gap-2 bg-white bg-opacity-25 px-3 py-2 rounded-pill small">
                <i class="fa-solid fa-lock"></i> Secure Checkout
            </div>
        </div>

        <!-- 💡 Form action ကို processShipping route သို့ ချိတ်ဆက်ပေးခြင်း -->
        <form action="{{ route('checkout.shipping.process') }}" method="POST">
            @csrf
            <div class="row g-4">
                <!-- Left Side: Delivery Information Form -->
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                        <h5 class="fw-bold mb-4" style="color: var(--pink-primary);">
                            <i class="fa-solid fa-truck-fast me-2"></i> Delivery Information
                        </h5>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', Auth::user()->phone ?? '') }}" placeholder="" required>
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Select Delivery Area -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Select Delivery Area </label>
                            <select name="delivery_area" id="deliveryArea" class="form-select @error('delivery_area') is-invalid @enderror" required onchange="updateTotal()">
                                <option value="3000" {{ old('delivery_area') == '3000' ? 'selected' : '' }}>ရန်ကုန် / မန္တလေး မြို့တွင်း (3,000 MMK)</option>
                                <option value="2000" {{ old('delivery_area', '2000') == '2000' ? 'selected' : '' }}>ကားဂိတ်ချ (2,000 MMK)</option>
                                <option value="5000" {{ old('delivery_area') == '5000' ? 'selected' : '' }}>အခြား နယ်မြို့များ (5,000 MMK)</option>
                            </select>
                            @error('delivery_area')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Delivery Address -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Delivery Address </label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="4" placeholder="" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Right Side: Order Summary -->
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                        <h5 class="fw-bold mb-3" style="color: var(--pink-primary);">
                            <i class="fa-solid fa-receipt me-2"></i> Order Summary
                        </h5>
                        
                        @php $subtotal = 0; @endphp
                        @if(session('cart') && count(session('cart')) > 0)
                            <div class="mb-3">
                                @foreach(session('cart') as $id => $item)
                                    @php 
                                        $itemTotal = $item['price'] * $item['quantity'];
                                        $subtotal += $itemTotal;
                                    @endphp
                                    <div class="d-flex justify-content-between align-items-center mb-2 small">
                                        <span class="text-muted text-truncate" style="max-width: 180px;" title="{{ $item['name'] }}">
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
                            <span class="fw-semibold"><span id="subtotalValue">{{ $subtotal ?? 0 }}</span> MMK</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                            <span class="text-muted">Delivery Fee</span>
                            <span class="fw-semibold"><span id="deliveryFee">2,000</span> MMK</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5 text-dark">Grand Total</span>
                            <span class="fw-bold fs-5" style="color: var(--pink-primary);"><span id="grandTotal">0</span> MMK</span>
                        </div>

                        <!-- Proceed to Payment Button -->
                        <button type="submit" class="btn btn-pink w-100 rounded-pill py-2 fw-semibold mb-2 shadow-sm">
                            <i class="fa-solid fa-circle-chevron-right me-1"></i> Proceed to Payment
                        </button>

                        <!-- Back to Cart Button -->
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2 small fw-semibold">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Delivery Fee Dynamic Calculation Script -->
    <script>
        function updateTotal() {
            let subtotal = parseFloat(document.getElementById('subtotalValue').innerText.replace(/,/g, '')) || 0;
            let selectBox = document.getElementById('deliveryArea');
            let deliveryFee = parseFloat(selectBox.value) || 0;
            let grandTotal = subtotal + deliveryFee;
            
            document.getElementById('deliveryFee').innerText = deliveryFee.toLocaleString();
            document.getElementById('grandTotal').innerText = grandTotal.toLocaleString();
        }

        // Page load တွင် ပထမအကြိမ် တွက်ချက်ရန်
        window.onload = updateTotal;
    </script>
</body>
</html>