<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} | Pink Petals Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pink-primary: #c75d83;
            --pink-hover: #a9446a;
            --pink-bg: #fff5f7;
            --sidebar-width: 250px;
        }
        body { background: var(--pink-bg); color: #563b47; font-family: system-ui, -apple-system, sans-serif; }
        
        /* Sidebar Layout */
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
        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid #f8d7e0;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 25px;
        }
        .top-navbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }
        
        /* Detail Card */
        .detail-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 20px #d88da512;
            max-width: 900px;
            margin: 0 auto;
        }
        .flower-photo { width: 100%; max-height: 420px; object-fit: cover; border-radius: 12px; }
        .price { color: var(--pink-primary); font-size: 26px; font-weight: 700; }
        .btn-pink { background: var(--pink-primary); color: white; border-radius: 10px; }
        .btn-pink:hover { background: var(--pink-hover); color: white; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="sidebar-brand">
            🌸 <span>Pink Petals</span>
        </a>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li><a href="{{ route('products.index') }}" class="active"><i class="fa-solid fa-box"></i> Products</a></li>
            <li><a href="{{ route('admin.categories') }}"><i class="fa-solid fa-list"></i> Categories</a></li>
            <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
            <li><a href="{{ route('admin.users.index')}}"><i class="fa-solid fa-users"></i> Users</a></li>
            <li><a href="{{ route('home')}}" class="text-danger text-decoration-none d-flex align-items-center gap-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</a><li>
            
        </ul>
        
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Top Navbar -->
        

        <!-- Detail Card Container -->
        <div class="detail-card">
            <div class="row g-4 align-items-center">
                <div class="col-md-6">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="flower-photo" alt="{{ $product->name }}">
                    @else
                        <div class="flower-photo bg-light d-flex align-items-center justify-content-center" style="height:350px; font-size:70px;">💐</div>
                    @endif
                </div>

                <div class="col-md-6">
                    <p class="text-uppercase text-secondary small fw-semibold mb-1">Pink Petals Collection</p>
                    <h1 class="mb-3 fw-bold" style="color: #563b47;">{{ $product->name }}</h1>

                    <p class="mb-2">
                        Category: 
                        <span class="badge bg-light text-dark border px-2 py-1">{{ $product->category->name ?? 'Uncategorized' }}</span>
                    </p>

                    <p class="price mb-3">{{ number_format($product->price, 0) }} MMK</p>

                    <p class="mb-3">
                        Stock: 
                        @if($product->stock > 0)
                            <span class="badge bg-success-subtle text-success px-2 py-1">{{ $product->stock }} available</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger px-2 py-1">Out of stock</span>
                        @endif
                    </p>

                    <h6 class="fw-bold mb-1">Description</h6>
                    <p class="text-secondary small mb-4">
                        {{ $product->description ?: 'A beautiful flower arrangement, made with love.' }}
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-pink px-4 py-2">
                            <i class="fa-solid fa-pen me-1"></i> Edit Flower
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4 py-2">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back to Flowers
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>