<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coupon Management | Pink Petals Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-hover: #a9446a;
            --pink-bg: #fff5f7;
            --sidebar-width: 250px;
        }
        body { 
            background: var(--pink-bg); 
            color: #563b47; 
            font-family: system-ui, -apple-system, sans-serif; 
            margin: 0;
        }
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
            padding: 30px;
            position:relative;
            z-index: 1;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 11px;
            border-color: #f8d7e0;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--pink-primary);
            box-shadow: 0 0 0 0.25rem #c75d8325;
        }
        .btn-pink { 
            background: var(--pink-primary); 
            color: white; 
            border-radius: 10px; 
        }
        .btn-pink:hover { 
            background: var(--pink-hover); 
            color: white; 
        }
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
            <li><a href="{{ route('admin.coupons.index') }}" class="active"><i class="fa-solid fa-ticket"></i> Manage Coupons</a></li>
            <li><a href="{{ route('admin.reports.sales') }}" > <i class="fa-solid fa-chart-line"></i> Sales Report  </a></li>
               <li><a href="{{ route('admin.reports.inventory') }}" > <i class="fa-solid fa-boxes-stacked me-2"></i> Inventory Report  </a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn text-danger text-decoration-none d-flex align-items-center gap-2 w-100 p-0 border-0 bg-transparent" style="padding: 12px 15px !important; font-weight: 500;">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark mb-0"><i class="fa-solid fa-ticket me-2" style="color: var(--pink-primary);"></i> Coupon Management</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show small" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3 text-dark">ကူပွန်အသစ် ဖန်တီးရန်</h5>
                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Coupon Code</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" placeholder="ဥပမာ - PROMO50" required value="{{ old('code') }}">
                            @error('code')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Discount Type</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="percent">ရာခိုင်နှုန်း (%)</option>
                                <option value="fixed">ကျပ်ငွေ တိကျစွာ (Fixed)</option>
                            </select>
                            @error('type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
    <label class="form-label small fw-semibold text-muted">Value</label>
    <input type="number" step="1" name="value" class="form-control @error('value') is-invalid @enderror" placeholder="ဥပမာ - 10 သို့မဟုတ် 5000" value="{{ old('value') }}" required>
    @error('value')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label small fw-semibold text-muted">Minimum Spend</label>
    <input type="number" step="1" name="min_spend" class="form-control @error('min_spend') is-invalid @enderror" placeholder="0 လျှင် အကန့်အသတ်မရှိ" value="{{ old('min_spend') }}">
</div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Expires At</label>
                            <input type="datetime-local" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror" value="{{ old('expires_at') }}">
                        </div>

                        <button type="submit" class="btn btn-pink w-100 rounded-pill py-2 fw-semibold shadow-sm">ကူပွန် သိမ်းဆည်းမည်</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3 text-dark">လက်ရှိ ကူပွန်များစာရင်း</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr class="small">
                                    <th>Code</th>
                                    <th>Type & Value</th>
                                    <th>Min Spend</th>
                                    <th>Expires</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $coupon)
                                    <tr class="small">
                                        <td class="fw-bold text-dark">{{ $coupon->code }}</td>
                                        <td>
                                            @if($coupon->type == 'percent')
                                                <span class="badge bg-info text-dark">{{ $coupon->value }}%</span>
                                            @else
                                                <span class="badge bg-success">{{ number_format($coupon->value) }} MMK</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($coupon->min_spend) }} MMK</td>
                                        <td>{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d H:i') : 'No Expiry' }}</td>
                                        <td class="text-end">
                                         <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-outline-primary px-2 py-1 me-1">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>  
                                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ဤကူပွန်ကို ဖျက်ရန် သေချာပါသလား?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">ကူပွန်များ ထည့်သွင်းထားခြင်း မရှိသေးပါ။</td>
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