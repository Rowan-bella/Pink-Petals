<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Orders | Pink Petals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --pink-primary: #d95785;
            --dark-pink: #71354c;
            --cream: #fffaf7;
        }
        body { background-color: var(--cream); font-family: 'DM Sans', sans-serif; color: #49313b; }
        .brand { font-family: 'Playfair Display', serif; color: var(--pink-primary); text-decoration: none; font-weight: 700; font-size: 24px; }
        .order-card { background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(113, 53, 76, 0.05); border: 1px solid #f7e3e8; transition: 0.3s; }
        .product-img { width: 55px; height: 55px; object-fit: cover; border-radius: 12px; border: 1px solid #f7e3e8; }
        .badge-status { padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 0.75rem; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 mb-4">
        <div class="container">
            <a class="brand" href="{{ route('home') }}">🌸 Pink Petals</a>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-house me-1"></i> Home
            </a>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="d-flex align-items-center mb-4 gap-3">
            <div class="p-3 bg-white shadow-sm rounded-4" style="color: var(--pink-primary); font-size: 24px;">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-1" style="color: var(--dark-pink);">My Orders History</h3>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($orders as $order)
                <div class="col-12">
                    <div class="order-card p-4">
                        <!-- Order Header Info -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center pb-3 mb-3 border-bottom gap-2">
                            <div>
                                <span class="fw-bold fs-5 text-dark me-3">Order #{{ $order->id }}</span>
                                <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> {{ $order->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <span class="text-muted small d-block">Status:</span>
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning bg-opacity-10 text-warning badge-status">Pending</span>
                                    @elseif($order->status == 'approved')
                                        <span class="badge bg-info bg-opacity-10 text-info badge-status">Approved</span>
                                    @elseif($order->status == 'delivered')
                                        <span class="badge bg-primary bg-opacity-10 text-primary badge-status">Delivered</span>
                                    @elseif($order->status == 'received')
                                        <span class="badge bg-success bg-opacity-10 text-success badge-status">Received</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary badge-status">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-muted small d-block">Payment:</span>
                                    <span class="badge bg-light text-dark border px-2 py-1 uppercase text-uppercase">
                                        {{ $order->payment->payment_method ?? 'COD' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    
                        <div class="table-responsive mb-3">
                            <table class="table align-middle mb-0">
                                <thead class="table-light small text-muted">
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th>PRICE</th>
                                        <th>QTY</th>
                                        <th class="text-end">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="product-img shadow-sm" alt="{{ $item->product->name }}">
                                                @else
                                                    <div class="product-img bg-light d-flex align-items-center justify-content-center text-muted">
                                                        <i class="fa-solid fa-image"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="fw-bold mb-0 text-dark">{{ $item->product->name ?? 'Product Unavailable' }}</h6>
                                                    <small class="text-muted">Flower Item</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ number_format($item->price) }} Ks</td>
                                        <td class="text-muted">x{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold" style="color: var(--pink-primary);">
                                            {{ number_format($item->price * $item->quantity) }} Ks
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @php
                            $subtotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
                            
                            $calculatedDiscount = ($subtotal ) - $order->total_price;

                        @endphp
<!-- $deliveryFee = $order->delivery_fee ??2000;  -->
                        <div class="pt-3 border-top mb-3">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Subtotal:</span>
                                <span>{{ number_format($subtotal) }} Ks</span>
                            </div>

                            @if($calculatedDiscount > 0)
                                <div class="d-flex justify-content-between small text-success mb-1">
                                    <span>Discount :</span>
                                    <span>-{{ number_format($calculatedDiscount) }} Ks</span>
                                </div>
                            @endif

                                                  </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-top gap-3">
                            <div>
                                <span class="text-muted small">Total Amount:</span>
                                <h4 class="fw-bold mb-0" style="color: var(--pink-primary);">{{ number_format($order->total_price) }} Ks</h4>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if($order->status == 'delivered')
                                    <form action="{{ route('user.order.received', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 shadow-sm py-2">
                                            <i class="fa-solid fa-check-double me-1"></i> ပစ္စည်းလက်ခံရရှိပြီ (Received)
                                        </button>
                                    </form>
                                @endif

                        
                                <a href="{{ route('user.order.pdf', $order->id) }}" class="btn btn-outline-danger btn-sm rounded-pill px-4 shadow-sm py-2" title="Download Invoice">
                                    <i class="fa-solid fa-file-pdf me-1"></i> PDF Invoice
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card order-card text-center py-5">
                        <i class="fa-solid fa-box-open fs-1 text-muted mb-2 opacity-50 d-block"></i>
                        <h5 class="text-muted">မှာယူထားသော Order များ မရှိသေးပါ။</h5>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>