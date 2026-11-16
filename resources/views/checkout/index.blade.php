<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout | Pink Petals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
</head>
<body>
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
                    <a href="{{ route('cart.index') }}" class="text-decoration-none fw-semibold" style="color: var(--pink-primary);">Cart</a>

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

        <form action="{{ route('checkout.shipping.process') }}" method="POST" id="mainCheckoutForm">
            @csrf
            <div class="row g-4">
                
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                        <h5 class="fw-bold mb-4" style="color: var(--pink-primary);">
                            <i class="fa-solid fa-truck-fast me-2"></i> Delivery Information
                        </h5>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    <!-- <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Select Delivery Area </label>
                            <select name="delivery_area" id="deliveryArea" class="form-select @error('delivery_area') is-invalid @enderror" required onchange="updateTotal()">
                                <option value="" {{ old('delivery_area') ? '' : 'selected' }}>ပို့ဆောင်ရန်နေရာကို ရွေးချယ်ပါ</option>
                                <option value="3000" {{ old('delivery_area') == '3000' ? 'selected' : '' }}>ရန်ကုန် / မန္တလေး မြို့တွင်း (3,000 MMK)</option>
                                <option value="2000" {{ old('delivery_area', '2000') == '2000' ? 'selected' : '' }}>ကားဂိတ်ချ (2,000 MMK)</option>
                                <option value="5000" {{ old('delivery_area') == '5000' ? 'selected' : '' }}>အခြား နယ်မြို့များ (5,000 MMK)</option>
                            </select>
                            @error('delivery_area')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div> -->

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Delivery Address </label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="4" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                        <h5 class="fw-bold mb-3" style="color: var(--pink-primary);">
                            <i class="fa-solid fa-receipt me-2"></i> Order Summary
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
                                        <span class="fw-semibold">{{ number_format($itemTotal) }} MMK</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <hr>
                    
                        <div class="card border-0 bg-light p-3 rounded-3 mb-3">
                            <span class="small fw-bold text-muted mb-2 d-block"><i class="fa-solid fa-ticket me-1 text-danger"></i> ရရှိနိုင်သော ကူပွန်များ (တစ်ခုကို ရွေးပါ)</span>
                            <div class="d-flex flex-column gap-2">
                                @forelse($availableCoupons ?? [] as $coupon)
                                    <div class="form-check bg-white p-2 rounded border small d-flex align-items-center m-0">
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
                                                    ({{ $coupon->value }}% လျှော့စျေး)
                                                @else
                                                    ({{ number_format($coupon->value) }} MMK လျှော့စျေး)
                                                @endif
                                                @if($coupon->min_spend > 0)
                                                    - ({{ number_format($coupon->min_spend) }} ကျပ်နှင့်အထက်)
                                                @endif
                                            </span>
                                        </label>
                                    </div>
                                @empty
                                    <span class="text-muted small text-center py-2">လက်ရှိတွင် အသုံးပြုနိုင်သော ကူပွန်များ မရှိသေးပါ။</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-semibold"><span id="subtotalValue">{{ $subtotal }}</span> MMK</span>
                        </div>


                        <div class="d-flex justify-content-between mb-2 text-success" id="discountRow" style="display: none !important;">
                            <span id="discountLabel">Discount</span>
                            <span class="fw-semibold">-<span id="discountValue">0</span> MMK</span>
                        </div>

                        <!-- <div class="d-flex justify-content-between mb-3 pb-2 border-bottom"> -->
                            <!-- <span class="text-muted">Delivery Fee</span> -->
                            <!-- <span class="fw-semibold"><span id="deliveryFee">2,000</span> MMK</span> -->
                        <!-- </div> -->

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5 text-dark">Grand Total</span>
                            <span class="fw-bold fs-5" style="color: var(--pink-primary);"><span id="grandTotal">0</span> MMK</span>
                        </div>

                        <button type="submit" form="mainCheckoutForm" class="btn btn-pink w-100 rounded-pill py-2 fw-semibold mb-2 shadow-sm">
                            <i class="fa-solid fa-circle-chevron-right me-1"></i> Proceed to Payment
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2 small fw-semibold">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateTotal() {
            let subtotal = parseFloat(document.getElementById('subtotalValue').innerText.replace(/,/g, '')) || 0;
            // let selectBox = document.getElementById('deliveryArea');
            // let deliveryFee = selectBox ? (parseFloat(selectBox.value) || 0) : 0;
            
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
                    discountLabel.innerText = `Discount (${couponCode} - ${val}%)`;
                } else {
                    discount = val;
                    discountLabel.innerText = `Discount (${couponCode})`;
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

            let grandTotal = (subtotal - discount) ;
            if (grandTotal < 0) grandTotal = 0;
            
            // if(document.getElementById('deliveryFee')) {
            //     document.getElementById('deliveryFee').innerText = deliveryFee.toLocaleString();
            // }
            document.getElementById('grandTotal').innerText = grandTotal.toLocaleString();
        }

        window.onload = updateTotal;
    </script>
    </body>
</html>