<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products | Pink Petals Admin</title>
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
        
        /* Card & Table */
        .content-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px #d88da512;
        }
        .btn-pink { background: var(--pink-primary); color: white; border-radius: 10px; }
        .btn-pink:hover { background: var(--pink-hover); color: white; }
        
        .table-custom th {
            background: #fff0f3 !important;
            color: var(--pink-primary);
            font-weight: 600;
            border-bottom: 2px solid #f8d7e0;
            padding: 12px;
        }
        .table-custom td {
            vertical-align: middle;
            padding: 12px;
            color: #563b47;
        }
        .product-img {
            width: 45px; height: 45px;
            object-fit: cover;
            border-radius: 8px;
        }
        .badge-category {
            background: #fce8ee;
            color: var(--pink-primary);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .badge-status-in { background: #e6fcf5; color: #0ca678; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; }
        .badge-status-low { background: #fff9db; color: #f59f00; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; }
        
        .action-btn {
            width: 32px; height: 32px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 8px; border: none; color: white; margin-right: 4px;
            text-decoration: none;
        }
        .btn-view { background: #adb5bd; }
        .btn-edit { background: var(--pink-primary); }
        .btn-delete { background: #fa5252; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="sidebar-brand">
            🌸 <span>Pink Petals</span>
        </a>
        <ul class="sidebar-menu">
            <li><a href="#"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li><a href="#" class="active"><i class="fa-solid fa-box"></i> Products</a></li>
            <li><a href="#"><i class="fa-solid fa-list"></i> Categories</a></li>
            <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
            <li><a href="#"><i class="fa-solid fa-users"></i> Users</a></li>
            <li><a href="#"><i class="fa-solid fa-gear"></i> Settings</a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="#" class="text-danger text-decoration-none d-flex align-items-center gap-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <button class="btn btn-light position-relative rounded-circle"><i class="fa-regular fa-bell"></i></button>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-circle-user fs-5"></i> Admin
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Page Header & Actions -->
        <div class="content-card">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1" style="color: var(--pink-primary);">Products</h3>
                    <p class="text-muted mb-0">Manage your flower products</p>
                </div>
                <a href="{{ route('products.create') }}" class="btn btn-pink px-3 py-2">
                    <i class="fa-solid fa-plus me-1"></i> Add New Product
                </a>
            </div>

            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th width="40"><input type="checkbox" class="form-check-input"></th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price (MMK)</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="product-img" alt="Flower">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1561181286-d3fee7d55364?w=100" class="product-img" alt="Default">
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $product->name }}</div>
                                    <small class="text-muted">{{ Str::limit($product->description, 35) }}</small>
                                </td>
                                <td>
                                    <span class="badge-category">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                </td>
                                <td class="fw-semibold">{{ number_format($product->price) }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    @if($product->stock > 0)
                                        <span class="badge-status-in">In Stock</span>
                                    @else
                                        <span class="badge-status-low">Low Stock</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <!-- View Button -->
                                    <a href="{{ route('products.show', $product->id) }}" class="action-btn btn-view" title="View">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <!-- Edit Button -->
                                    <a href="{{ route('products.edit', $product->id) }}" class="action-btn btn-edit" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <!-- Delete Form -->
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ဒီပစ္စည်းကို ဖျက်မှာ သေချာပါသလား?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete border-0" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">ပစ္စည်းအချက်အလက် တစ်စုံတစ်ရာ မရှိသေးပါ။</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="text-muted small">
                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </span>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>