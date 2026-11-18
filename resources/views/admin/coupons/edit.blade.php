<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Coupon | Pink Petals Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-hover: #a9446a;
            --pink-bg: #fff5f7;
            --sidebar-width: 250px;
        }
        body { background: var(--pink-bg); color: #563b47; font-family: system-ui, -apple-system, sans-serif; margin: 0; display: flex; }
        .sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; top: 0; left: 0; background: white; border-right: 1px solid #f8d7e0; display: flex; flex-direction: column; z-index: 1000; }
        .sidebar-brand { padding: 24px 20px; font-weight: bold; color: var(--pink-primary); text-decoration: none; display: flex; align-items: center; gap: 10px; font-size: 1.1rem; }
        .sidebar-menu { list-style: none; padding: 0 15px; margin: 0; flex-grow: 1; }
        .sidebar-menu li a { display: flex; align-items: center; gap: 12px; padding: 12px 15px; color: #7a5c68; text-decoration: none; border-radius: 10px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: var(--pink-primary); color: white; }
        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 30px; min-height: 100vh; box-sizing: border-box; }
        .form-control, .form-select { border-radius: 10px; padding: 11px; border-color: #f8d7e0; }
        .form-control:focus, .form-select:focus { border-color: var(--pink-primary); box-shadow: 0 0 0 0.25rem #c75d8325; }
        .btn-pink { background: var(--pink-primary); color: white; border-radius: 10px; }
        .btn-pink:hover { background: var(--pink-hover); color: white; }
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
            <li><a href="{{route('admin.reports.activity')}}"><i class="fa-solid fa-users-viewfinder"></i>Customer Activity</a></li>
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
        
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3 text-dark">Edit Coupon</h5>
                    
                    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Coupon Code</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" required value="{{ old('code', $coupon->code) }}">
                            @error('code')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Discount Type</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="percent" {{ (old('type', $coupon->type) == 'percent') ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed" {{ (old('type', $coupon->type) == 'fixed') ? 'selected' : '' }}>Fixed Amount</option>
                            </select>
                            @error('type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Value</label>
                            <input type="number" step="1" name="value" class="form-control @error('value') is-invalid @enderror" required value="{{ old('value', $coupon->value) }}">
                            @error('value')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Minimum Spend</label>
                            <input type="number" step="1" name="min_spend" class="form-control @error('min_spend') is-invalid @enderror" value="{{ old('min_spend', $coupon->min_spend) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Expires At</label>
                            <input type="datetime-local" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror" value="{{ old('expires_at', isset($coupon->expires_at) ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-pink w-100 rounded-pill py-2 fw-semibold shadow-sm">Update</button>
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary rounded-pill py-2 px-4 fw-semibold">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>