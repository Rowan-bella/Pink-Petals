<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Detail #{{ $order->id }} | Pink Petals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-bg: #f8f9fa;
        }
        body { background-color: var(--pink-bg); font-family: system-ui, sans-serif; }
        .sidebar { background: white; min-height: 100vh; border-right: 1px solid #dee2e6; }
        .active-pink {
            background-color: var(--pink-primary) !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(199, 93, 131, 0.25);
        }
        .nav-link:hover:not(.active-pink) {
            background-color: #fff5f7;
            color: var(--pink-primary) !important;
        }
        .table-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: none; }
        .btn-pink { background-color: var(--pink-primary); color: white; border: none; }
        .btn-pink:hover { background-color: #b04c71; color: white; }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-4 sidebar bg-white border-end">
                <h5 class="fw-bold mb-4" style="color: var(--pink-primary);">🌸 Pink Petals</h5>
                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-dark fw-semibold d-flex align-items-center gap-2 py-2 px-3 rounded-4">
                            <i class="fa-solid fa-house"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}" class="nav-link text-dark fw-semibold d-flex align-items-center gap-2 py-2 px-3 rounded-4">
                            <i class="fa-solid fa-box"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.categories') }}" class="nav-link text-dark fw-semibold d-flex align-items-center gap-2 py-2 px-3 rounded-4">
                            <i class="fa-solid fa-list"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.orders') }}" class="nav-link active-pink fw-semibold d-flex align-items-center gap-2 py-2 px-3 rounded-4">
                            <i class="fa-solid fa-cart-shopping"></i> Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link text-dark fw-semibold d-flex align-items-center gap-2 py-2 px-3 rounded-4">
                            <i class="fa-solid fa-users"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.coupons.index') }}" class="nav-link text-dark fw-semibold d-flex align-items-center gap-2 py-2 px-3 rounded-4">
                            <i class="fa-solid fa-ticket"></i> Manage Coupons
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.reports.sales') }}"  class="nav-link text-dark fw-semibold d-flex align-items-center gap-2 py-2 px-3 rounded-4">
                            <i class="fa-solid fa-chart-line"></i> Sales Report 
                         </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.reports.inventory') }}"  class="nav-link text-dark fw-semibold d-flex align-items-center gap-2 py-2 px-3 rounded-4">
                            <i class="fa-solid fa-boxes-stacked me-2"></i> Inventory Report 
                         </a>
                    </li>
                     <li class="nav-itam"><a href="{{route('admin.reports.activity')}}"class="nav-link text-dark fw-semibold d-flex align-items-center gap-2 py-2 px-3 rounded-4">
                        <i class="fa-solid fa-users-viewfinder"></i>Customer Activity</a>
                    </li>
                    <li class="nav-item mt-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link text-danger fw-semibold d-flex align-items-center gap-2 py-2 px-3 rounded-4 border-0 bg-transparent w-100 text-start">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 p-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-receipt me-2" style="color: var(--pink-primary);"></i> Order Details (#{{ $order->id }})
                    </h3>
                    <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Orders
                    </a>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-3">
                            <h5 class="fw-bold border-bottom pb-2 mb-3 text-secondary">Customer Information</h5>
                            <p class="mb-1"><strong>Name:</strong> {{ $order->user->name ?? $order->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $order->phone ?? $order->user->phone ?? 'N/A' }}</p>
                            <p class="mb-0"><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                            <h5 class="fw-bold border-bottom pb-2 mb-3 text-secondary">Payment & Status</h5>
                            <p class="mb-1"><strong>Method:</strong> <span class="badge bg-dark">{{ strtoupper($order->payment->payment_method ?? 'COD') }}</span></p>
                            <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span></p>
                            <p class="mb-2"><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                            
                            @if($order->payment && $order->payment->payment_slip)
                                <div class="mt-3">
                                    <strong class="d-block mb-2">Payment Slip:</strong>
                                    <a href="{{ asset('storage/' . $order->payment->payment_slip) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->payment->payment_slip) }}" class="img-thumbnail rounded-3 shadow-sm" style="max-height: 200px;" alt="Slip">
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card table-card p-4">
                            <h5 class="fw-bold border-bottom pb-2 mb-3 text-secondary">Ordered Items</h5>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr class="small text-muted">
                                            <th>PRODUCT</th>
                                            <th>PRICE</th>
                                            <th>QUANTITY</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if($item->product && $item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded-3 shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">
                                                        @endif
                                                        <span class="fw-semibold">{{ $item->product->name ?? 'Product Unavailable' }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ number_format($item->price) }} Ks</td>
                                                <td>x{{ $item->quantity }}</td>
                                                <td class="fw-bold" style="color: var(--pink-primary);">{{ number_format($item->price * $item->quantity) }} Ks</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @php
                            
                                $itemsSubtotal = $order->items->sum(function($item) {
                                    return $item->price * $item->quantity;
                                });
                                
                                
                                
                                 $calculatedDiscount = ($itemsSubtotal) - $order->total_price;
                            @endphp
<!-- $deliveryFee = $order->delivery_fee ?? 0;  -->
                                
            
                                <!-- $calculatedDiscount = ($itemsSubtotal + $deliveryFee) - $order->total_price; -->
                            <div class="pt-3 border-top mt-3">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Subtotal:</span>
                                    <span>{{ number_format($itemsSubtotal) }} Ks</span>
                                </div>

                                @if($calculatedDiscount > 0)
                                    <div class="d-flex justify-content-between small text-success mb-1">
                                        <span>Discount:</span>
                                        <span>-{{ number_format($calculatedDiscount) }} Ks</span>
                                    </div>
                                @endif

                                

                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <h5 class="fw-bold mb-0">Total Amount:</h5>
                                    <h4 class="fw-bold mb-0" style="color: var(--pink-primary);">{{ number_format($order->total_price) }} Ks</h4>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>