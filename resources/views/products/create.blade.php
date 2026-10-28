<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Flower | Pink Petals Admin</title>
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
        
        /* Form Card */
        .form-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 20px #d88da512;
            max-width: 800px;
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

        <!-- Form Container -->
        <div class="form-card mx-auto">
            <h3 class="fw-bold mb-1" style="color: var(--pink-primary);">🌸 Add a New Flower</h3>
            <p class="text-muted mb-4">Add a beautiful bloom to your collection.</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Flower Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter flower name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Category *</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Choose category</option>
                        <option value="1" @selected(old('category_id') == 1)>Rose Bouquets</option>
                        <option value="2" @selected(old('category_id') == 2)>Mixed Flowers</option>
                        <option value="3" @selected(old('category_id') == 3)>Tulips</option>
                        <option value="4" @selected(old('category_id') == 4)>Flower Gifts</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Enter product description...">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Price (MMK) *</label>
                        <input type="number" name="price" class="form-control" min="0" step="1" value="{{ old('price') }}" placeholder="25000" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Stock Quantity *</label>
                        <input type="number" name="stock" class="form-control" min="0" step="1" value="{{ old('stock', 0) }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Flower Image (Optional)</label>
                    <input type="file" name="image" class="form-content form-control" accept="image/*">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-pink px-4 py-2">Save Flower ♡</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4 py-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>