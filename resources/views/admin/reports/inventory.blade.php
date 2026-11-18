<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Report | Pink Petals Admin</title>
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
    </style>
</head>
<body>

    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            🌸 <span>Pink Petals</span>
        </a>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li><a href="{{ route('products.index') }}"><i class="fa-solid fa-box"></i> Products</a></li>
            <li><a href="{{ route('admin.categories') }}"><i class="fa-solid fa-list"></i> Categories</a></li>
            <li><a href="{{ route('admin.orders') }}"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
            <li><a href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users"></i> Users</a></li>
            <li><a href="{{ route('admin.coupons.index') }}"><i class="fa-solid fa-ticket me-1"></i> Manage Coupons</a></li>
            <li><a href="{{ route('admin.reports.sales') }}"><i class="fa-solid fa-chart-line"></i> Sales Report</a></li>
            <li>
                <a href="{{ route('admin.reports.inventory') }}" class="active">
                    <i class="fa-solid fa-boxes-stacked"></i> Inventory Report
                </a>
            </li>
            <li><a href="{{route('admin.reports.activity')}}"><i class="fa-solid fa-users-viewfinder"></i>Customer Activity</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="text-danger text-decoration-none d-flex align-items-center gap-2 border-0 bg-transparent w-100 p-2 text-start rounded-3" style="font-weight: 500;">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h3 class="fw-bold mb-1" style="color: var(--dark-pink); font-family: 'Playfair Display', serif;">Inventory & Stock Report</h3>
                <p class="text-muted small mb-0">Inventory Status and Low Stock List </p>
            </div>
            <!-- <div class="col-md-6 text-md-end">
                <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2">
                    <i class="fa-solid fa-print me-1"></i> Print Report
                </button>
            </div> -->
        </div>

        <!-- Alert Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card card-custom p-4 border-start border-danger border-4">
                    <span class="text-muted small text-uppercase">Out of Stock</span>
                    <h3 class="fw-bold mt-2 text-danger">{{ $outOfStockProducts->count() }} Items</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-custom p-4 border-start border-warning border-4">
                    <span class="text-muted small text-uppercase">Low Stock <= {{ $threshold }}</span>
                    <h3 class="fw-bold mt-2 text-warning">{{ $lowStockProducts->count() }} Items</h3>
                </div>
            </div>
        </div>


        @if($outOfStockProducts->count() > 0)
        <div class="card card-custom p-4 mb-4">
            <h5 class="fw-bold mb-3 text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i> Out of Stock Products</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-danger">
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Current Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($outOfStockProducts as $product)
                            <tr>
                                <td class="fw-bold">{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>{{ number_format($product->price) }} MMK</td>
                                <td class="fw-bold text-danger">{{ $product->stock }}</td>
                                <td><span class="badge bg-danger">Out of Stock</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($lowStockProducts->count() > 0)
        <div class="card card-custom p-4 mb-4">
            <h5 class="fw-bold mb-3 text-warning"><i class="fa-solid fa-exclamation-circle me-2"></i> Low Stock Warning</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-warning">
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Current Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockProducts as $product)
                            <tr>
                                <td class="fw-bold">{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>{{ number_format($product->price) }} MMK</td>
                                <td class="fw-bold text-warning">{{ $product->stock }}</td>
                                <td><span class="badge bg-warning text-dark">Low Stock</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        
        <div class="card card-custom p-4">
            <h5 class="fw-bold mb-3" style="color: var(--dark-pink);">All Products Stock Status</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock Quantity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>{{ number_format($product->price) }} MMK</td>
                                <td class="fw-bold">{{ $product->stock }}</td>
                                <td>
                                    @if($product->stock <= 0)
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @elseif($product->stock <= 5)
                                        <span class="badge bg-warning text-dark">Low Stock</span>
                                    @else
                                        <span class="badge bg-success">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>