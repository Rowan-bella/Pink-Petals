<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Pink Petals Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-hover: #a9446a;
            --pink-bg: #fff5f7;
            --sidebar-width: 250px;
        }
        body { background: var(--pink-bg); color: #563b47; font-family: system-ui, -apple-system, sans-serif; }
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
        }
        .sidebar-menu {
            list-style: none;
            padding: 0 15px;
            margin: 0;
            flex-grow: 1;
        }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #7a5c68;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 5px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: var(--pink-primary);
            color: white;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 25px;
        }
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 20px #d88da512;
        }
        .chart-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px #d88da512;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <a href="#" class="sidebar-brand">
            🌸 <span>Pink Petals</span>
        </a>
        <ul class="sidebar-menu">
            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
                <li><a href="{{ route('admin.dashboard') }}" class="active"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            @endif

            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
                <li><a href="{{ route('products.index') }}"><i class="fa-solid fa-box"></i> Products</a></li>
            @endif

            <li><a href="{{ route('admin.categories') }}"><i class="fa-solid fa-list"></i> Categories</a></li>

            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager' || strtolower(auth()->user()->role) === 'staff')
                <li><a href="{{ route('admin.orders') }}"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
            @endif

            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'manager'))
                <li><a href="{{ route('admin.users.index')}}"><i class="fa-solid fa-users"></i> Users</a></li>
            @endif
                <li>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="text-danger text-decoration-none d-flex align-items-center gap-2 border-0 bg-transparent w-100 p-2 text-start" style="font-weight: 500;">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
    </form>
</li>
                </ul>
    </div>
    <div class="main-content">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <h6 class="text-muted">Total Products</h6>
                    <h3 class="fw-bold" style="color: var(--pink-primary);">{{ $totalProducts }} Flowers</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h6 class="text-muted">Total Stock Quantity</h6>
                    <h3 class="fw-bold" style="color: var(--pink-primary);">{{ $totalStock }} Items</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h6 class="text-muted">Total Revenue</h6>
                    <h3 class="fw-bold" style="color: var(--pink-primary);">{{ number_format($totalRevenue) }} MMK</h3>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-8">
                <div class="chart-card">
                    <h5 class="fw-bold mb-3" style="color: var(--pink-primary);">📈 Sales Overview</h5>
                    <canvas id="salesChart" height="130"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-card">
                    <h5 class="fw-bold mb-3" style="color: var(--pink-primary);">🌸 Categories</h5>
                    <canvas id="categoryChart" height="230"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        const salesDataValues = @json($salesData);
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Sales (MMK)',
                    data: salesDataValues,
                    borderColor: '#c75d83',
                    backgroundColor: '#c75d8320',
                    fill: true,
                    tension: 0.3
                }]
            }
        });
        const categoryLabels = @json($categoryNames);
        const categoryData = @json($categoryCounts);

        const ctxCat = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryData,
                    backgroundColor: ['#c75d83', '#e8a5be', '#f3ccd9', '#f8d7e0', '#d88da5']
                }]
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>