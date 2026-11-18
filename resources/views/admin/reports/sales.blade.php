<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Report | Pink Petals Admin</title>
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
        .btn-pink {
            background: var(--pink-primary); color: white; border-radius: 30px;
            padding: 8px 20px; font-weight: 600; border: none;
        }
        .btn-pink:hover { background: var(--pink-hover); color: white; }
    </style>
</head>
<body>

    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            🌸 <span>Pink Petals</span>
        </a>
        <ul class="sidebar-menu">
            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            @endif

            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
                <li><a href="{{ route('products.index') }}"><i class="fa-solid fa-box"></i> Products</a></li>
            @endif

            <li><a href="{{ route('admin.categories') }}"><i class="fa-solid fa-list"></i> Categories</a></li>

            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager' || strtolower(auth()->user()->role) === 'staff')
                <li><a href="{{ route('admin.orders') }}"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
            @endif

            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'manager'))
                <li><a href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users"></i> Users</a></li>
            @endif

            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'manager'))
                <li><a href="{{ route('admin.coupons.index') }}"><i class="fa-solid fa-ticket me-1"></i> Manage Coupons</a></li>
            @endif

            @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'manager')
                <li><a href="{{ route('admin.reports.sales') }}" class="active"><i class="fa-solid fa-chart-line"></i> Sales Report</a></li>
                <li><a href="{{ route('admin.reports.inventory') }}"><i class="fa-solid fa-boxes-stacked"></i> Inventory Report</a></li>
                <li><a href="{{ route('admin.reports.activity') }}"><i class="fa-solid fa-users-viewfinder"></i> Customer Activity</a></li>
            @endif

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

    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h3 class="fw-bold mb-1" style="color: var(--dark-pink); font-family: 'Playfair Display', serif;">Sales Report</h3>
                <p class="text-muted small mb-0">Detailed Sales and Revenue Report</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-inline-flex gap-2">
                    <a href="{{ route('admin.reports.sales.export', request()->all()) }}" class="btn text-white btn-sm rounded-3 px-3 py-2 shadow-sm d-flex align-items-center gap-2" style="background: #198754; font-weight: 500;">
                        <i class="fa-solid fa-file-excel"></i> Export Sales Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="card card-custom p-3 mb-4">
            <form action="{{ route('admin.reports.sales') }}" method="GET" class="row g-3 align-items-end">
                
        
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Select by Period</label>
                    <select name="filter" id="filterSelect" class="form-select form-select-sm rounded-3">
                        <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ $filter == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        <option value="custom" {{ $filter == 'custom' ? 'selected' : '' }}>Custom Range</option>
                    </select>
                </div>

                <div class="col-md-6" id="dateFieldContainer">
                    <label class="form-label small fw-bold" id="dateLabel">Select Date</label>
                
                    <input type="date" name="date_value" id="dailyInput" value="{{ in_array($filter, ['daily']) ? ($dateValue ?? request('date_value')) : '' }}" class="form-control form-control-sm rounded-3 filter-input" style="display: none;">
                    
                    <input type="month" name="date_value" id="monthlyInput" value="{{ $filter == 'monthly' ? ($dateValue ?? request('date_value')) : '' }}" class="form-control form-control-sm rounded-3 filter-input" style="display: none;">

                    <select name="date_value" id="yearlyInput" class="form-select form-select-sm rounded-3 filter-input" style="display: none;">
                        @for($y = date('Y'); $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ ($dateValue ?? request('date_value')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-6" id="customRangeContainer" style="display: none;">
                    <label class="form-label small fw-bold">Custom Range</label>
                    <div class="input-group input-group-sm">
                        <input type="date" name="start_date" id="startDateInput" value="{{ $startDate }}" class="form-control" placeholder="Start Date">
                        <input type="date" name="end_date" id="endDateInput" value="{{ $endDate }}" class="form-control" placeholder="End Date">
                    </div>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-pink btn-sm w-100">Search with Filter</button>
                </div>
            </form>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <span class="text-muted small text-uppercase">Total Revenue</span>
                    <h3 class="fw-bold mt-2" style="color: var(--pink-primary);">{{ number_format($totalRevenue) }} MMK</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <span class="text-muted small text-uppercase">Total Items Sold</span>
                    <h3 class="fw-bold mt-2 text-dark">{{ $totalItemsSold }} Items</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <span class="text-muted small text-uppercase">Successful Orders</span>
                    <h3 class="fw-bold mt-2 text-dark">{{ $totalOrdersCount }} Orders</h3>
                </div>
            </div>
        </div>
        <div class="card card-custom p-4">
            <h5 class="fw-bold mb-3" style="color: var(--dark-pink);">Detailed Sales Transactions</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Items & Quantity</th>
                            <th>Total Price</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? 'Guest' }}</td>
                                <td>
                                    <ul class="list-unstyled mb-0 small">
                                        @foreach($order->items as $item)
                                            <li>🌸 {{ $item->product->name ?? 'Flower' }} (x{{ $item->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="fw-bold" style="color: var(--pink-primary);">{{ number_format($order->total_price) }} MMK</td>
                                <td class="small text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No Sales Records Available For This Period</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.getElementById('filterSelect');
            const dateFieldContainer = document.getElementById('dateFieldContainer');
            const dailyInput = document.getElementById('dailyInput');
            const monthlyInput = document.getElementById('monthlyInput');
            const yearlyInput = document.getElementById('yearlyInput');
            const customRangeContainer = document.getElementById('customRangeContainer');
            const startDateInput = document.getElementById('startDateInput');
            const endDateInput = document.getElementById('endDateInput');
            const dateLabel = document.getElementById('dateLabel');

            function updateInputs() {
                const val = filterSelect.value;
            
                dailyInput.removeAttribute('name');
                monthlyInput.removeAttribute('name');
                yearlyInput.removeAttribute('name');
                startDateInput.removeAttribute('name');
                endDateInput.removeAttribute('name');

                dailyInput.style.display = 'none';
                monthlyInput.style.display = 'none';
                yearlyInput.style.display = 'none';
                dateFieldContainer.style.display = 'block';
                customRangeContainer.style.display = 'none';

                if (val === 'daily') {
                    dailyInput.style.display = 'block';
                    dailyInput.setAttribute('name', 'date_value');
                    dateLabel.innerText = 'Select Day';
                } else if (val === 'monthly') {
                    monthlyInput.style.display = 'block';
                    monthlyInput.setAttribute('name', 'date_value');
                    dateLabel.innerText = 'Select Month';
                } else if (val === 'yearly') {
                    yearlyInput.style.display = 'block';
                    yearlyInput.setAttribute('name', 'date_value');
                    dateLabel.innerText = 'Select Year';
                } else if (val === 'custom') {
                
                    dateFieldContainer.style.display = 'none';
                    customRangeContainer.style.display = 'block';
                    startDateInput.setAttribute('name', 'start_date');
                    endDateInput.setAttribute('name', 'end_date');
                }
            }

            filterSelect.addEventListener('change', updateInputs);
            updateInputs();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>