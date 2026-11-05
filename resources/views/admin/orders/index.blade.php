<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Management | Pink Petals</title>
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
            <!-- Sidebar -->
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

            <!-- Main Content -->
            <div class="col-md-10 p-5">
                <h3 class="fw-bold mb-4 text-dark">Order Management</h3>

                <div class="card table-card p-4">
                    <div class="d-flex align-items-center mb-3 gap-2">
                        <i class="fa-solid fa-list-check" style="color: var(--pink-primary);"></i>
                        <h6 class="fw-bold mb-0">All Customer Orders ({{ $orders->total() }})</h6>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr class="small text-muted">
                                    <th>ORDER ID</th>
                                    <th>TOTAL AMOUNT</th>
                                    <th>PAYMENT METHOD</th>
                                    <th>SLIP (ပြေစာ)</th>
                                    <th>ORDER DATE</th>
                                    <th>CURRENT STATUS</th>
                                    <th>ACTION (STATUS)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td class="fw-bold">#{{ $order->id }}</td>
                                    <td class="fw-bold" style="color: var(--pink-primary);">{{ number_format($order->total_price) }} Ks</td>
                                    <td>{{ $order->payment->payment_method ?? 'COD' }}</td>
                                    <td>
                                        @if($order->payment && $order->payment->payment_slip)
                                            <a href="{{ asset('storage/' . $order->payment->payment_slip) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $order->payment->payment_slip) }}" width="40" height="40" class="rounded object-fit-cover shadow-sm">
                                            </a>
                                        @else
                                            <span class="text-muted small">No Slip</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-flex gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm" style="width: 130px;">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="unpaid" {{ $order->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-pink">Save</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">မှာယူထားသော Order များ မရှိသေးပါ။</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>