<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Choose Payment Method | Pink Petals</title>
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
    <div class="container py-4" style="max-width: 800px;">
        <!-- Header Title -->
        <div class="d-flex align-items-center gap-3 mb-4 p-4 rounded-4 text-white shadow-sm" style="background-color: var(--pink-primary);">
            <i class="fa-solid fa-wallet fs-3"></i>
            <div>
                <h4 class="mb-0 fw-bold">Choose Payment Method</h4>
                <small class="opacity-75">ငွေပေးချေမည့် နည်းလမ်းကို ရွေးချယ်ပါ</small>
            </div>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Total Amount Card -->
            <div class="card shadow-sm border-0 rounded-4 p-4 bg-white mb-4 text-center">
                <span class="text-muted small mb-1">စုစုပေါင်း ကျသင့်ငွေ </span>
                <h2 class="fw-bold mb-0" style="color: var(--pink-primary);">
                    {{ number_format($grandTotal) }} Ks
                </h2>
            </div>

            <!-- Payment Options Card -->
            <div class="card shadow-sm border-0 rounded-4 p-4 bg-white mb-4">
                <label class="form-label fw-bold mb-3" style="color: var(--pink-primary);">ငွေပေးချေမည့် နည်းလမ်း ရွေးချယ်ပါ -</label>

                <!-- Cash on Delivery -->
                <div class="form-check p-3 border rounded-3 mb-3 d-flex align-items-center gap-3">
                    <input class="form-check-input ms-0" type="radio" name="payment_method" id="cod" value="cod" checked onchange="togglePaymentFields()">
                    <label class="form-check-label fw-semibold text-dark w-100 cursor-pointer" for="cod">
                        <i class="fa-solid fa-house-chimney text-pink me-2" style="color: var(--pink-primary);"></i> Cash on Delivery 
                    </label>
                </div>

                <!-- KBZPay -->
                <div class="form-check p-3 border rounded-3 mb-3 d-flex align-items-center gap-3">
                    <input class="form-check-input ms-0" type="radio" name="payment_method" id="kbzpay" value="kbzpay" onchange="togglePaymentFields()">
                    <label class="form-check-label fw-semibold text-dark w-100 cursor-pointer" for="kbzpay">
                        <i class="fa-solid fa-mobile-screen text-pink me-2" style="color: var(--pink-primary);"></i> KBZPay
                    </label>
                </div>

                <!-- WavePay -->
                <div class="form-check p-3 border rounded-3 mb-3 d-flex align-items-center gap-3">
                    <input class="form-check-input ms-0" type="radio" name="payment_method" id="wavepay" value="wavepay" onchange="togglePaymentFields()">
                    <label class="form-check-label fw-semibold text-dark w-100 cursor-pointer" for="wavepay">
                        <i class="fa-solid fa-wallet text-pink me-2" style="color: var(--pink-primary);"></i> WavePay
                    </label>
                </div>

                <!-- Online Payment Details Box (KBZPay / WavePay Info & Screenshot Upload) -->
                <div id="onlinePaymentBox" class="p-4 border rounded-3 bg-light mt-3" style="display: none;">
                    <div class="mb-3 small text-muted">
                        <i class="fa-solid fa-circle-info text-pink me-1" style="color: var(--pink-primary);"></i> 
                        <span id="accountInfo">KBZPay Phone: 09-450310990 (Name: YA MIN SHWE SIN)</span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold text-muted">ငွေလွှဲပြေစာ ပုံ တင်ပေးပါ -</label>
                        <input type="file" name="payment_slip" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <!-- Confirm Payment Button -->
            <button type="submit" class="btn btn-pink w-100 rounded-pill py-3 fw-bold shadow-sm fs-6">
                <i class="fa-solid fa-circle-check me-2"></i> Confirm Payment 
            </button>
        </form>
    </div>

    <!-- JavaScript for Toggle Online Payment Box -->
    <script>
        function togglePaymentFields() {
            let kbz = document.getElementById('kbzpay').checked;
            let wave = document.getElementById('wavepay').checked;
            let box = document.getElementById('onlinePaymentBox');
            let info = document.getElementById('accountInfo');

            if (kbz || wave) {
                box.style.display = 'block';
                if (kbz) {
                    info.innerText = "KBZPay Phone: 09-450310990 (Name: YA MIN SHWE SIN)";
                } else {
                    info.innerText = "WavePay Phone: 09-450310990 (Name: YA MIN SHWE SIN)";
                }
            } else {
                box.style.display = 'none';
            }
        }
    </script>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>