<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Activity Report | Pink Petals Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-hover: #a9446a;
            --pink-bg: #fff5f7;
            --sidebar-width: 250px;
            --dark-pink: #71354c;
        }
        body { background: var(--pink-bg); color: #563b47; font-family: 'DM Sans', sans-serif; }
        .sidebar {
            width: var(--sidebar-width);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            background: white;
            border-right: 1px solid #f8d7e0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 24px 20px;
            font-weight: bold;
            color: var(--pink-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
            font-family: 'Playfair Display', serif;
        }
        .sidebar-menu { list-style: none; padding: 0 15px; margin: 0; flex-grow: 1; }
        .sidebar-menu li a {
            display: flex; align-items: center; gap: 12px; padding: 12px 15px;
            color: #7a5c68; text-decoration: none; border-radius: 10px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: var(--pink-primary); color: white; }
        .main-content { margin-left: var(--sidebar-width); padding: 25px; }
        .card-custom { background: white; border-radius: 16px; border: 1px solid #f8d7e0; box-shadow: 0 4px 20px #d88da512; }
        .rank-badge {
            width: 28px; height: 28px; border-radius: 50%;
            background: #fff0f4; color: var(--pink-primary);
            display: inline-flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        🌸 <span>Pink Petals</span>
    </a>
    <ul class="sidebar-menu">
        @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
        @endif

        @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
            <li><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}"><i class="fa-solid fa-box"></i> Products</a></li>
        @endif

        <li><a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}"><i class="fa-solid fa-list"></i> Categories</a></li>

        @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager' || strtolower(auth()->user()->role) === 'staff')
            <li><a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
        @endif

        @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'manager'))
            <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Users</a></li>
        @endif

        @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'manager'))
            <li><a href="{{ route('admin.coupons.index') }}" class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}"><i class="fa-solid fa-ticket me-1"></i> Manage Coupons</a></li>
        @endif
        @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
            <li><a href="{{ route('admin.reports.sales') }}" class="{{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> Sales Report</a></li>
            <li><a href="{{ route('admin.reports.inventory') }}" class="{{ request()->routeIs('admin.reports.inventory') ? 'active' : '' }}"><i class="fa-solid fa-boxes-stacked"></i> Inventory Report</a></li>
            <li><a href="{{ route('admin.reports.activity') }}" class="{{ request()->routeIs('admin.reports.activity') ? 'active' : '' }}"><i class="fa-solid fa-users-viewfinder"></i> Customer Activity</a></li>
        @endif

        <!-- Logout -->
        <li class="mt-2">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="text-danger text-decoration-none d-flex align-items-center gap-2 border-0 bg-transparent w-100 p-2 text-start rounded-3" style="font-weight: 500;">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</div>
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h3 class="fw-bold mb-1" style="color: var(--dark-pink); font-family: 'Playfair Display', serif;">User & Order Activity Report</h3>
                <p class="text-muted small mb-0">Top Customers, Best Selling Flowers & Most Wishlisted Items</p>
            </div>
            <!-- <div class="col-md-6 text-md-end">
                <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2">
                    <i class="fa-solid fa-print me-1"></i> Print Report
                </button>
            </div> -->
        </div>

        <div class="card card-custom p-4 mb-4">
            <h5 class="fw-bold mb-3" style="color: var(--dark-pink);">
                <i class="fa-solid fa-crown text-warning me-2"></i> Top Customers
            </h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Rank</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Total Orders</th>
                            <th>Total Spent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCustomers as $index => $customer)
                            <tr>
                                <td><span class="rank-badge">{{ $index + 1 }}</span></td>
                                <td class="fw-bold">{{ $customer->name }}</td>
                                <td class="text-muted small">{{ $customer->email }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $customer->orders_count }} Orders</span></td>
                                <td class="fw-bold" style="color: var(--pink-primary);">{{ number_format($customer->orders_sum_total_price) }} MMK</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">No Customer Orders Available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card card-custom p-4 h-100">
                    <h5 class="fw-bold mb-3" style="color: var(--dark-pink);">
                        <i class="fa-solid fa-fire text-danger me-2"></i> Best Sellers
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Sold Qty</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bestSellers as $index => $item)
                                    <tr>
                                        <td><span class="rank-badge">{{ $index + 1 }}</span></td>
                                        <td>
                                            <div class="fw-bold">{{ $item->product->name ?? 'Deleted Product' }}</div>
                                            <small class="text-muted">{{ $item->product->category->name ?? '' }}</small>
                                        </td>
                                        <td><span class="badge bg-success">{{ $item->total_sold }} Sold</span></td>
                                        <td class="fw-bold small" style="color: var(--pink-primary);">{{ number_format($item->total_earned) }} MMK</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No Sales Records Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-custom p-4 h-100">
                    <h5 class="fw-bold mb-3" style="color: var(--dark-pink);">
                        <i class="fa-solid fa-heart text-danger me-2"></i> Most Wishlisted
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Wishlist Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mostWishlisted as $index => $wish)
                                    <tr>
                                        <td><span class="rank-badge">{{ $index + 1 }}</span></td>
                                        <td>
                                            <div class="fw-bold">{{ $wish->product->name ?? 'Deleted Product' }}</div>
                                            <small class="text-muted">{{ $wish->product->category->name ?? '' }}</small>
                                        </td>
                                        <td class="small">{{ number_format($wish->product->price ?? 0) }} MMK</td>
                                        <td>
                                            <span class="badge rounded-pill" style="background: #ffe3ec; color: var(--pink-primary);">
                                                <i class="fa-solid fa-heart me-1"></i> {{ $wish->wishlist_count }} Users
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No Wishlist Items Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>